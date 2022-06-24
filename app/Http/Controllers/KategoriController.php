<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JSvalidation;
use Illuminate\Database\QueryException;
use App\Http\Controllers\AppWebController;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:kategori,read')->only('index');
        $this->middleware('role:kategori,create')->only(['create', 'store']);
        $this->middleware('role:kategori,update')->only(['edit', 'update']);
        $this->middleware('role:kategori,delete')->only('delete');

        $this->AppWeb = new AppWebController();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kategori.index')->with([
            'title' => 'Kategori'
        ]);
    }

    public function ajax(Request $r)
    {
        $nama = $r->cari;

        $sql = 'SELECT * FROM kategori WHERE nama_kategori LIKE "%' . $nama . '%"';
        $data = DB::select($sql);

        return DataTables::of($data)
            ->addColumn('aksi', function ($d) {
                $data = '';
                if (hakAksesMenu('kategori', 'update')) {
                    $data .= '<a href="kategori/' . $d->id_kategori . '/edit" class="edit-btn"><i class="feather-edit"></i></a>';
                }

                if (hakAksesMenu('kategori', 'delete')) {
                    $data .= '<a href="kategori/delete/' . $d->id_kategori . '" data-nama="' . $d->nama_kategori . '" data-tipe="hapus" class="hapus-btn hapus_data_list"><i class="feather-x-circle"></i></a>';
                }

                return $data;
            })
            ->rawColumns(['aksi'])
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
            'nama' => 'required',
        ]);

        return view('kategori.create')->with([
            'title' => 'Tambah Kategori',
            'validator' => $validator,
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
            'nama' => 'required',
        ]);

        $isExist = $this->AppWeb->checkData('kategori','nama_kategori',$r->nama);
        if($isExist>0) {
            return redirect('kategori/create')->with(['pesan'=>'<div class="alert alert-danger">Data Kategori Sudah Ada!</div>']);
        }

        try {
            DB::insert(' INSERT INTO kategori(nama_kategori) VALUES("'.$r->nama.'"); ');

            return redirect('/kategori')->with(['pesan' => '<div class="alert alert-success">Data berhasil ditambahkan</div>']);

        } catch (QueryException $e) {
            return redirect('/kategori')->with(['pesan' => '<div class="alert alert-danger">' . $e->errorInfo[2] . '</div>']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $validator = JSvalidation::make([
            'nama' => 'required',
        ]);

        $sql = ' SELECT * FROM kategori WHERE id_kategori = "' . $id . '" ';
        $kategori = DB::select($sql);

        return view('kategori.edit')->with([
            'title'     => 'Edit Kategori',
            'kategori'  => $kategori[0],
            'validator' => $validator,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r)
    {
        $sql = ' SELECT nama_kategori FROM kategori WHERE id_kategori = "' . $r->id . '" ';
        $item = DB::select($sql)[0];

        if($item->nama_kategori!=$r->nama) {
            $isExist = $this->AppWeb->checkData('kategori','nama_kategori',$r->nama);
            if($isExist>0) {
                if(strtolower($item->nama_kategori) != strtolower($r->nama)) return redirect('kategori/'.$r->id.'/edit')->with(['pesan'=>'<div class="alert alert-danger">Data Kategori Sudah Ada!</div>']);
            }
        }

        try{
            DB::update(' UPDATE kategori SET nama_kategori = "'.$r->nama.'" WHERE id_kategori = "'.$r->id.'" ');

            return redirect('/kategori')->with(['pesan' => '<div class="alert alert-success">Data berhasil diperbarui</div>']);

        }catch(QueryException $e){

            DB::rollBack();
            return redirect('/kategori')->with(['pesan' => '<div class="alert alert-danger">' . $e->errorInfo[2] . '</div>']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            DB::delete(' DELETE FROM kategori WHERE id_kategori = "' . $id . '"; ');

            return response()->json([
                'tipe' => true,
                'pesan' => 'Kategori berhasil dihapus'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'tipe' => false,
                'pesan' => $e->errorInfo,
            ]);
        }
    }
}
