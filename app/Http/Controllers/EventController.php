<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JSvalidation;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\AppWebController;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:event,read')->only('index');
        $this->middleware('role:event,create')->only(['create', 'store']);
        $this->middleware('role:event,update')->only(['edit', 'update']);
        $this->middleware('role:event,delete')->only('delete');

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

        $sql1 = 'SELECT id_kota, nama_kota FROM kota';
        $itemKota = DB::select($sql1);

        $kota = '';
        if(!empty($itemKota)){
            $kota .= '<option value="">Pilih Kota</option>';
            foreach($itemKota as $key=>$val){
                $kota .= '<option value="'.$val->id_kota.'">'.$val->nama_kota.'</option>';
            }
        }

        $sql2 = 'SELECT id_kategori, nama_kategori FROM kategori';
        $itemKategori = DB::select($sql2);

        $kategori = '';
        if(!empty($itemKategori)){
            $kategori .= '<option value="">Pilih Kategori</option>';
            foreach($itemKategori as $key=>$val){
                $kategori .= '<option value="'.$val->id_kategori.'">'.$val->nama_kategori.'</option>';
            }
        }

        return view('event.index')->with([
            'title' => 'Data Event',
            'region' => $region,
            'kota' => $kota,
            'kategori' => $kategori
        ]);
    }

    public function ajax(Request $r)
    {
        $region = $r->region;
        $kota = $r->kota;
        $kategori = $r->kategori;

        $sql = 'SELECT a.*, b.nama_region as region, c.nama_kota as kota, d.nama_kategori as kategori FROM event as a
            LEFT JOIN region as b ON b.id_region = a.region_id
            LEFT JOIN kota as c ON c.id_kota = a.kota_id
            LEFT JOIN kategori as d ON d.id_kategori = a.kategori_id
            WHERE a.region_id LIKE "%' . $region . '%" AND a.kota_id LIKE "%' . $kota . '%" AND a.kategori_id LIKE "%' . $kategori . '%"';
        $data = DB::select($sql);

        return DataTables::of($data)
            ->addColumn('tanggal', function($d){
                $tanggal = Carbon::parse($d->tanggal);
                return $tanggal->isoFormat('D MMM Y');
            })
            ->addColumn('isExpired', function($d){
                $sekarang = Carbon::now(); 
                $tanggal = Carbon::parse($d->tanggal)->format('Y-m-d');
                if($sekarang > $tanggal) return 0; // sudah berjalan
                if($sekarang == $tanggal) return 1; // sedang berjalan
            })
            ->addColumn('aksi', function ($d) {
                $data = '';
                if (hakAksesMenu('event', 'update')) {
                    $data .= '<a href="event/' . $d->id_event . '/edit" class="edit-btn"><i class="feather-edit"></i></a>';
                }

                if (hakAksesMenu('event', 'delete')) {
                        $data .= '<a href="event/delete/' . $d->id_event . '" data-nama="' . $d->lokasi . '" data-tipe="hapus" class="hapus-btn hapus_data_list"><i class="feather-trash"></i></a>';
                }

                return $data;
            })
            ->rawColumns(['aksi','tanggal','isExpired'])
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
            'kota' => 'required',
            'kategori' => 'required'
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

        $sql2 = 'SELECT id_kategori, nama_kategori FROM kategori';
        $itemKategori = DB::select($sql2);

        $kategori = '';
        if(!empty($itemKategori)){
            $kategori .= '<option value="">Pilih Kategori</option>';
            foreach($itemKategori as $key=>$val){
                $kategori .= '<option value="'.$val->id_kategori.'">'.$val->nama_kategori.'</option>';
            }
        }

        return view('event.create')->with([
            'title' => 'Tambah Event',
            'validator' => $validator,
            'region' => $region,
            'kategori' => $kategori
        ]);
    }

    public function getKota(Request $r){
        $sql = 'SELECT id_kota, nama_kota FROM kota WHERE region_id = "'.$r->id.'"';
        return DB::select($sql);
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
            'kota' => 'required',
            'kategori' => 'required'
        ]);

        try {
            DB::insert(' INSERT INTO event(region_id, kota_id, kategori_id, lokasi, speaker, moderator, tanggal) VALUES("'.$r->region.'", "'.$r->kota.'", "'.$r->kategori.'", "'.$r->lokasi.'", "'.$r->speaker.'", "'.$r->moderator.'", "'.$r->tanggal.'"); ');

            return redirect('/event')->with(['pesan' => '<div class="alert alert-success">Data berhasil ditambahkan</div>']);
        } catch (QueryException $e) {
            return redirect('/event')->with(['pesan' => '<div class="alert alert-danger">' . $e->errorInfo[2] . '</div>']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $validator = JSvalidation::make([
            'region' => 'required',
            'kota' => 'required',
            'kategori' => 'required'
        ]);

        $sql = 'SELECT a.*, b.nama_region as region, c.nama_kota as kota, d.nama_kategori as kategori FROM event as a
            LEFT JOIN region as b ON b.id_region = a.region_id
            LEFT JOIN kota as c ON c.id_kota = a.kota_id
            LEFT JOIN kategori as d ON d.id_kategori = a.kategori_id
            WHERE a.id_event = "' . $id . '" ';
        $event = DB::select($sql);

        $sql1 = 'SELECT id_region, nama_region FROM region';
        $itemRegion = DB::select($sql1);

        $region = '';
        if(!empty($itemRegion)){
            $region .= '<option value="">Pilih Region</option>';
            foreach($itemRegion as $key=>$val){
                if($event[0]->region_id == $val->id_region) $region .= '<option value="'.$val->id_region.'" selected>'.$val->nama_region.'</option>';
                else $region .= '<option value="'.$val->id_region.'">'.$val->nama_region.'</option>';
            }
        }

        $sql2 = 'SELECT id_kategori, nama_kategori FROM kategori';
        $itemKategori = DB::select($sql2);

        $kategori = '';
        if(!empty($itemKategori)){
            $kategori .= '<option value="">Pilih Kategori</option>';
            foreach($itemKategori as $key=>$val){
                if($event[0]->kategori_id == $val->id_kategori) $kategori .= '<option value="'.$val->id_kategori.'" selected>'.$val->nama_kategori.'</option>';
                else $kategori .= '<option value="'.$val->id_kategori.'">'.$val->nama_kategori.'</option>';
            }
        }

        return view('event.edit')->with([
            'title'     => 'Edit Event',
            'event'      => $event[0],
            'validator' => $validator,
            'region' => $region,
            'kategori' => $kategori
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r)
    {
        try{
            DB::update(' UPDATE event SET region_id = "'.$r->region.'", kota_id = "'.$r->kota.'", kategori_id = "'.$r->kategori.'", lokasi = "'.$r->lokasi.'", speaker = "'.$r->speaker.'", moderator = "'.$r->moderator.'", tanggal = "'.$r->tanggal.'" WHERE id_event = "'.$r->id.'" ');

            return redirect('/event')->with(['pesan' => '<div class="alert alert-success">Data berhasil diperbarui</div>']);
        }catch(QueryException $e){
            return redirect('/event')->with(['pesan' => '<div class="alert alert-danger">' . $e->errorInfo[2] . '</div>']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            DB::delete(' DELETE FROM event WHERE id_event = "' . $id . '"; ');

            return response()->json([
                'tipe' => true,
                'pesan' => 'Event berhasil dihapus'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'tipe' => false,
                'pesan' => $e->errorInfo,
            ]);
        }
    }
}