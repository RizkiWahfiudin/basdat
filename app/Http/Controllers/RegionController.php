<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JSvalidation;
use Illuminate\Database\QueryException;
use App\Http\Controllers\AppWebController;

class RegionController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:region,read')->only('index');
        $this->middleware('role:region,create')->only(['create', 'store']);
        $this->middleware('role:region,update')->only(['edit', 'update']);
        $this->middleware('role:region,delete')->only('delete');

        $this->AppWeb = new AppWebController();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('region.index')->with([
            'title' => 'Region'
        ]);
    }

    public function ajax(Request $r)
    {
        $nama = $r->cari;

        $sql = 'SELECT * FROM region WHERE nama_region LIKE "%' . $nama . '%"';
        $data = DB::select($sql);

        return DataTables::of($data)
            ->addColumn('aksi', function ($d) {
                $data = '';
                if (hakAksesMenu('region', 'update')) {
                    $data .= '<a href="region/' . $d->id_region . '/edit" class="edit-btn"><i class="feather-edit"></i></a>';
                }

                if (hakAksesMenu('region', 'delete')) {
                    $data .= '<a href="region/delete/' . $d->id_region . '" data-nama="' . $d->nama_region . '" data-tipe="hapus" class="hapus-btn hapus_data_list"><i class="feather-x-circle"></i></a>';
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

        return view('region.create')->with([
            'title' => 'Tambah Region',
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

        $isExist = $this->AppWeb->checkData('region','nama_region',$r->nama);
        if($isExist>0) {
            return redirect('region/create')->with(['pesan'=>'<div class="alert alert-danger">Data Region Sudah Ada!</div>']);
        }

        try {
            DB::insert(' INSERT INTO region(nama_region) VALUES("'.$r->nama.'"); ');

            return redirect('/region')->with(['pesan' => '<div class="alert alert-success">Data berhasil ditambahkan</div>']);

        } catch (QueryException $e) {
            return redirect('/region')->with(['pesan' => '<div class="alert alert-danger">' . $e->errorInfo[2] . '</div>']);
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

        $sql = ' SELECT * FROM region WHERE id_region = "' . $id . '" ';
        $region = DB::select($sql);

        return view('region.edit')->with([
            'title'     => 'Edit Region',
            'region'  => $region[0],
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
        $sql = ' SELECT nama_region FROM region WHERE id_region = "' . $r->id . '" ';
        $item = DB::select($sql)[0];

        if($item->nama_region!=$r->nama) {
            $isExist = $this->AppWeb->checkData('region','nama_region',$r->nama);
            if($isExist>0) {
                if(strtolower($item->nama_region) != strtolower($r->nama)) return redirect('region/'.$r->id.'/edit')->with(['pesan'=>'<div class="alert alert-danger">Data Region Sudah Ada!</div>']);
            }
        }

        try{
            DB::update(' UPDATE region SET nama_region = "'.$r->nama.'" WHERE id_region = "'.$r->id.'" ');

            return redirect('/region')->with(['pesan' => '<div class="alert alert-success">Data berhasil diperbarui</div>']);

        }catch(QueryException $e){

            DB::rollBack();
            return redirect('/region')->with(['pesan' => '<div class="alert alert-danger">' . $e->errorInfo[2] . '</div>']);
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
            DB::delete(' DELETE FROM region WHERE id_region = "' . $id . '"; ');

            return response()->json([
                'tipe' => true,
                'pesan' => 'Region berhasil dihapus'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'tipe' => false,
                'pesan' => $e->errorInfo,
            ]);
        }
    }
}
