<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\QueryException;

class AppWebController extends Controller
{
    public function checkData($table, $column, $value) {
        if($table!='' && $column!='' && $value!=''){
            $data =DB::table($table)
                ->where($column, $value)
                ->count();
            return $data;
        }else{
            return 0;
        }
    }

    public function checkDataManyCol($table, $columns=array()) {
        if( $table!='' && !empty($columns) ) {
            $query = DB::table($table);
            $query->where(function($query) use ($columns) {
                foreach ($columns as $key=>$val) {
                    $query->where($key, $val);
                }
            });
            return $query->count();
        }else{
            return 0;
        }
    }

    public function convertMonthRomawi($value) {
        $result = '';
        if($value == 1) $result = 'I';
        if($value == 2) $result = 'II';
        if($value == 3) $result = 'III';
        if($value == 4) $result = 'IV';
        if($value == 5) $result = 'V';
        if($value == 6) $result = 'VI';
        if($value == 7) $result = 'VII';
        if($value == 8) $result = 'VIII';
        if($value == 9) $result = 'IX';
        if($value == 10) $result = 'X';
        if($value == 11) $result = 'XI';
        if($value == 12) $result = 'XII';
        return $result;
    }
}
