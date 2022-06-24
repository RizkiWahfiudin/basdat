<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JSvalidation;
use Illuminate\Database\QueryException;
use App\Http\Controllers\AppWebController;

class KotaController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:kota,read')->only('index');
        $this->middleware('role:kota,create')->only(['create', 'store']);
        $this->middleware('role:kota,update')->only(['edit', 'update']);
        $this->middleware('role:kota,delete')->only('delete');

        $this->AppWeb = new AppWebController();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sql = 'SELECT id_region, nama_region FROM region';
        $itemRegion = DB::select($sql);

        $region = '';
        if(!empty($itemRegion)){
            $region .= '<option value="">Pilih Region</option>';
            foreach($itemRegion as $key=>$val){
                $region .= '<option value="'.$val->id_region.'">'.$val->nama_region.'</option>';
            }
        }

        return view('kota.index')->with([
            'title' => 'Kota',
            'region' => $region
        ]);
    }

    public function ajax(Request $r)
    {
        $where = '';

        $region = $r->region;
        $nama = $r->cari;

        $sql = '
            SELECT a.*, b.nama_region as region FROM kota AS a
            JOIN region AS b ON b.id_region = a.region_id
            WHERE a.nama_kota LIKE "%' . $nama . '%" AND b.id_region LIKE "%' . $region . '%"
        ';
        $data = DB::select($sql);

        return DataTables::of($data)
            ->addColumn('aksi', function ($d) {
                $data = '';
                if (hakAksesMenu('kota', 'update')) {
                    $data .= '<a href="kota/' . $d->id_kota . '/edit" class="edit-btn"><i class="feather-edit"></i></a>';
                }

                if (hakAksesMenu('kota', 'delete')) {
                    $data .= '<a href="kota/delete/' . $d->id_kota . '" data-nama="' . $d->nama_kota . '" data-tipe="hapus" class="hapus-btn hapus_data_list"><i class="feather-x-circle"></i></a>';
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
            'region' => 'required',
            'nama' => 'required',
        ]);

        $sql = 'SELECT id_region, nama_region FROM region';
        $itemRegion = DB::select($sql);

        $region = '';
        if(!empty($itemRegion)){
            $region .= '<option value="">Pilih Region</option>';
            foreach($itemRegion as $key=>$val){
                $region .= '<option value="'.$val->id_region.'">'.$val->nama_region.'</option>';
            }
        }

        return view('kota.create')->with([
            'title' => 'Tambah Kota',
            'validator' => $validator,
            'region'=>$region
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
            'region' => 'required',
            'nama' => 'required',
        ]);

        $isExist = $this->AppWeb->checkDataManyCol('kota', [
            'region_id'=>$r->region,
            'nama_kota'=>$r->nama
        ]);
        if($isExist>0) {
            return redirect('kota/create')->with(['pesan'=>'<div class="alert alert-danger">Data Kota Sudah Ada!</div>']);
        }

        try {
            DB::insert(' INSERT INTO kota(region_id, nama_kota) VALUES("'.$r->region.'", "'.$r->nama.'"); ');

            return redirect('/kota')->with(['pesan' => '<div class="alert alert-success">Data berhasil ditambahkan</div>']);

        } catch (QueryException $e) {
            return redirect('/kota')->with(['pesan' => '<div class="alert alert-danger">' . $e->errorInfo[2] . '</div>']);
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
            'region' => 'required',
            'nama' => 'required',
        ]);

        $sql = ' SELECT * FROM kota WHERE id_kota = "' . $id . '" ';
        $kota = DB::select($sql);

        $sql1 = 'SELECT id_region, nama_region FROM region';
        $itemRegion = DB::select($sql1);

        $region = '';
        if(!empty($itemRegion)){
            $region .= '<option value="">Pilih Region</option>';
            foreach($itemRegion as $key=>$val){
                $region .= '<option value="'.$val->id_region.'">'.$val->nama_region.'</option>';
            }
        }

        return view('kota.edit')->with([
            'title'     => 'Edit Kota',
            'kota'      => $kota[0],
            'validator' => $validator,
            'region'=>$region
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
        $sql = ' SELECT region_id, nama_kota FROM kota WHERE id_kota = "' . $r->id . '" ';
        $item = DB::select($sql)[0];

        if($item->region_id!=$r->region || $item->nama_kota!=$r->nama) {
            $isExist = $this->AppWeb->checkDataManyCol('kota',[
                'region_id'=>$r->region,
                'nama_kota'=>$r->nama
            ]);
            if($isExist>0) {
                if(strtolower($item->nama_kota) != strtolower($r->nama)) return redirect('kota/'.$r->id.'/edit')->with(['pesan'=>'<div class="alert alert-danger">Data Kota Sudah Ada!</div>']);
            }
        }

        try{
            DB::update(' UPDATE kota SET region_id = "'.$r->region.'", nama_kota = "'.$r->nama.'" WHERE id_kota = "'.$r->id.'" ');

            return redirect('/kota')->with(['pesan' => '<div class="alert alert-success">Data berhasil diperbarui</div>']);

        }catch(QueryException $e){

            DB::rollBack();
            return redirect('/kota')->with(['pesan' => '<div class="alert alert-danger">' . $e->errorInfo[2] . '</div>']);
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
            DB::delete(' DELETE FROM kota WHERE id_kota = "' . $id . '"; ');

            return response()->json([
                'tipe' => true,
                'pesan' => 'Kota berhasil dihapus'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'tipe' => false,
                'pesan' => $e->errorInfo,
            ]);
        }
    }
}
