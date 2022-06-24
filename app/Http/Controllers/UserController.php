<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JSvalidation;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('role:users,read')->only('index');
        $this->middleware('role:users,create')->only(['create', 'store']);
        $this->middleware('role:users,update')->only(['edit', 'update']);
        $this->middleware('role:users,delete')->only('delete');
    }

    public function index()
    {
        $title = 'Pengaturan User';

        return view('user.index')->with([
            'title' => $title,
        ]);
    }

    public function ajax(Request $r)
    {
        $where = '';

        if ($r->cari) {
            $nama = $r->cari;
            $where .= DB::raw('AND LOWER(username) LIKE "%' . $nama . '%" OR LOWER(nama) LIKE "%' . $nama . '%" ');
        }


        $data = User::query()->with('roles')
            ->whereRaw('1=1 ' . $where)
            ->select(DB::raw('ROW_NUMBER() OVER(ORDER BY id) AS nomor'), 'id', 'username', 'nama', 'email', 'status');

        // $data = $data->toArray();
        // dd($data);
        return DataTables::eloquent($data)
            ->addColumn('status', function ($d) {
                if ($d->status == 'y') {
                    return '<span class="badge badge-success"><i class="feather-eye"></i> AKTIF</span>';
                } else {
                    return '<span class="badge-danger badge"><i class="feather-eye-off"></i> NONAKTIF</span>';
                }
            })
            ->addColumn('roles', function ($d) {
                $role = [];
                foreach ($d->roles as $roles) {
                    $role[]  = '<span class="badge badge-dark">' . $roles->nama . '</span>';
                }
                return implode(' ', $role);
            })
            ->addColumn('aksi', function ($d) {
                $data = '';
                if (hakAksesMenu('users', 'update')) {
                    $data .= '<a href="user/' . $d->id . '/edit" class="edit-btn"><i class="feather-edit"></i></a>';
                }

                if ($d->status == 'y') {
                    $ikon = '<i class="feather-x-circle"></i>';
                    $tipe = 'nonaktifkan';
                } else {
                    $ikon = '<i class="feather-repeat"></i>';
                    $tipe = 'aktifkan';
                }

                if (hakAksesMenu('users', 'delete')) {
                    $data .= '<a href="user/delete/' . $d->id . '" data-nama="' . $d->nama . '" data-tipe="' . $tipe . '" class="hapus-btn hapus_data_list">' . $ikon . '</a>';
                }

                return $data;
            })
            ->rawColumns(['status', 'aksi', 'roles'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $validator = JSvalidation::make([
            'username' => 'required|alpha|unique:users,username',
            'nama' => 'required',
            'email' => 'required|email',
            'roles' => 'required'
        ]);

        $roles = Roles::all();

        return view('user.create')->with([
            'title' => 'Tambah user',
            'validator' => $validator,
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {

        $r->validate([
            'username' => 'required|alpha|unique:users,username',
            'nama' => 'required',
            'email' => 'required|email',
        ]);

        $create = [
            'username'  => $r->username,
            'nama'      => $r->nama,
            'email'     => $r->email,
            'password'  => Hash::make('asd'),
            'foto'      => 'av2.jpg',
        ];

        $user = User::create($create);

        $roles = $r->input('roles');
        if (!empty($roles)) {
            foreach ($roles as $roles_id) {
                $record[] = [
                    'user_id' => $user->id,
                    'roles_id'    => $roles_id,
                    'created_at'  => Carbon::now(),
                ];
            }
        }

        try {
            // insert roles_user
            DB::table('roles_user')->insert($record);
            activity()->log('Username: '.$r->username.' ditambahkan');

            return redirect('/user')->with(['pesan' => '<div class="alert alert-success">Data berhasil ditambahkan</div>']);
        } catch (QueryException $e) {
            return redirect('/user')->with(['pesan' => '<div class="alert alert-danger">' . $e->errorInfo[2] . '</div>']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $validator = JSvalidation::make([
            'username'  => 'required|unique:users,username,' . $user->id,
            'nama'      => 'required',
            'email'     => 'required|email',
            'password'  => 'confirmed',
            'roles'     => 'required',
            'foto'      => 'image|max:1000'
        ]);


        $roles = DB::table('roles as a')
            ->leftJoin('roles_user as b', function ($join) use ($user) {
                $join->on('b.roles_id', '=', 'a.id')
                    ->where('b.user_id', $user->id);
            })
            ->select('a.id', 'a.nama', 'b.user_id')
            ->get();

        return view('user.edit')->with([
            'title'     => 'Edit User',
            'user'      => $user,
            'validator' => $validator,
            'roles'     => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, User $user)
    {

        $roles = $r->input('roles');
        if (!empty($roles)) {
            foreach ($roles as $roles_id) {
                $record[] = [
                    'user_id'   => $user->id,
                    'roles_id'  => $roles_id,
                    'created_at' => Carbon::now(),
                ];
            }
        } else {
            $record = [];
        }


        try {
            // update roles_user
            DB::table('roles_user')->where('user_id', $user->id)->delete();
            DB::table('roles_user')->insert($record);

            if ($r->hasFile('foto')) {
                // dd('ada');
                $r->validate([
                    'foto'  => 'image|max:1000'
                ]);

                $name = $user->id . $user->username;
                $ext  = $r->foto->getClientOriginalExtension();
                $foto = base64_encode($name) . '.' . $ext;

                $r->foto->storeAs('public/foto', $foto);

                $record_foto = [
                    'foto'  => $foto
                ];

                // Update foto user
                User::find($user->id)->update($record_foto);
                activity()->log('Foto username: '.$user->username.' diperbarui');
            }

            // Cek apakah dengan ganti password
            if ($r->input('password')) {
                $r->validate([
                    'username'  => 'required|alpha|unique:users,username,' . $user->id,
                    'nama'      => 'required',
                    'email'     => 'required|email',
                    'password'  => 'confirmed'
                    // 'roles[]' => 'required'
                ]);

                $update = [
                    'username'  => $r->username,
                    'nama'      => $r->nama,
                    'email'     => $r->email,
                    'password'  => Hash::make($r->password),
                ];

                activity()->log('Password username: '.$user->username.' diperbarui');

            } else {
                $r->validate([
                    'username'  => 'required|alpha|unique:users,username,' . $user->id,
                    'nama'      => 'required',
                    'email'     => 'required|email',
                    // 'roles[]' => 'required'
                ]);

                $update = [
                    'username'  => $r->username,
                    'nama'      => $r->nama,
                    'email'     => $r->email,
                ];

                activity()->log('Informasi Username: '.$user->username.' diperbarui');
            }


            // Update user
            User::find($user->id)->update($update);

            return redirect('/user')->with(['pesan' => '<div class="alert alert-success">Data berhasil diperbarui</div>']);
        } catch (QueryException $e) {
            return redirect('/user')->with(['pesan' => '<div class="alert alert-danger">' . $e->errorInfo[2] . '</div>']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $username = User::find($id)->username;

        try {
            $status = User::find($id)->status;
            if ($status == 'y') {
                User::find($id)->update([
                    'status' => 'n'
                ]);

                activity()->log('Username: '.$username.' dinonaktifkan');

                return response()->json([
                    'tipe' => true,
                    'pesan' => 'User berhasil dinonaktifkan'
                ]);
            } else {
                User::find($id)->update([
                    'status' => 'y'
                ]);

                activity()->log('Username: '.$username.' diaktifkan');

                return response()->json([
                    'tipe' => true,
                    'pesan' => 'User berhasil diakftikan kembali'
                ]);
            }
        } catch (QueryException $e) {
            return response()->json([
                'tipe' => false,
                'pesan' => $e->errorInfo,
            ]);
        }
    }
}
