<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $tahun = '<option value="">All Year</option>';
        $dateNow = Carbon::now()->format('Y');
        for ($i=2020; $i <= (int)$dateNow; $i++) {
            $tahun .= '<option value="'.$i.'">'.$i.'</option>';
        }

        return view('home')->with([
            'title' => 'Dashboard',
            'tahun' => $tahun
        ]);
    }

    public function eventByMonth(Request $r)
    {
        $searchDate = $r->tahun;

        $sql = 'SELECT tanggal FROM event WHERE tanggal LIKE "%' . $searchDate . '%"';
        $item = DB::select($sql);

        $result = [];
        if($item) {
            $januari = 0;
            $februari = 0;
            $maret = 0;
            $april = 0;
            $mei = 0;
            $juni = 0;
            $juli = 0;
            $agustus = 0;
            $september = 0;
            $oktober = 0;
            $november = 0;
            $desember = 0;

            foreach ($item as $key => $val) {
                $temp = explode("-", $val->tanggal);
                if((int)$temp[1] === 1) $januari += 1;
                if((int)$temp[1] === 2) $februari += 1;
                if((int)$temp[1] === 3) $maret += 1;
                if((int)$temp[1] === 4) $april += 1;
                if((int)$temp[1] === 5) $mei += 1;
                if((int)$temp[1] === 6) $juni += 1;
                if((int)$temp[1] === 7) $juli += 1;
                if((int)$temp[1] === 8) $agustus += 1;
                if((int)$temp[1] === 9) $september += 1;
                if((int)$temp[1] === 10) $oktober += 1;
                if((int)$temp[1] === 11) $november += 1;
                if((int)$temp[1] === 12) $desember += 1;
            }
            
            array_push($result, $januari);
            array_push($result, $februari);
            array_push($result, $maret);
            array_push($result, $april);
            array_push($result, $mei);
            array_push($result, $juni);
            array_push($result, $juli);
            array_push($result, $agustus);
            array_push($result, $september);
            array_push($result, $oktober);
            array_push($result, $november);
            array_push($result, $desember);
        }
        
        return $result;
    }

    public function eventByRegion(Request $r)
    {
        $searchDate = $r->tahun;

        $sql = 'SELECT b.nama_region as region FROM event as a
            LEFT JOIN region as b ON b.id_region = a.region_id
            WHERE a.tanggal LIKE "%' . $searchDate . '%"';
        $item = DB::select($sql);

        $result = [];
        if($item) {
            $arrRegion = [];
            foreach ($item as $key => $val) {
                array_push($arrRegion, $val->region);
            }
            $res = array_count_values($arrRegion);

            $totalEvent = 0;
            foreach ($res as $key => $val) {
                $totalEvent += $val;
            }

            foreach ($res as $key => $val) {
                $percent = ($val*100)/$totalEvent;
                $arr = [];
                array_push($arr, $key);
                array_push($arr, $val);
                array_push($arr, round($percent,1).' %');
                array_push($result, $arr);
            }
        }
        
        return $result;
    }
}