<?php

use App\Models\RolesItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

function hakAksesMenu($roleitem, $role){
    $roles_id = session('roles_id');
    $item_id = RolesItem::where('nama', $roleitem)->first();

    if($item_id != null){
        $item_id = $item_id->id;
        $permission = DB::table('roles_item_pivot')
                    ->where('roles_id', $roles_id)
                    ->where('roles_item_id', $item_id)
                    ->first();

        if($permission != null){
            if($permission->$role == '1'){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }

    }else{
        return false;
    }


}

function input_log(){
    $insert = DB::table('log_user')->insert([
        'users_id'  => Auth::user()->id,
        'url'       => URL::full(),
        'ip'        => request()->ip(),
        'created_at'=> Carbon::now(),
    ]);
}

function xButton($link='', $tipe='kembali', $name='Buat'){
    if($tipe == 'kembali'){
        return '<a href="'.url(''.$link.'').'" class="btn btn-link">Kembali</a>';

    }else if($tipe == 'tambah_view'){
        return '<a href="'.url(''.$link.'').'" class="btn btn-sm btn-primary float-right">'.$name.'</a>';

    }else if($tipe == 'tambah'){
        return '<button class="btn btn-primary btn-sm" type="submit">Ya! Simpan</button>';

    }else if($tipe == 'cari'){
        return '<button class="btn btn-warning btn-sm" type="submit">GO</button>';

    }else if($tipe == 'print'){
        return '<button class="btn btn-success btn-sm float-right" style="margin-right:10px;" type="submit">Export</button>';

    }else if($tipe == 'edit'){
        return '<button class="btn btn-primary btn-sm" type="submit">Perbarui</button>';

    }else if($tipe == 'download'){
        return '<a href="'.url(''.$link.'').'" class="btn btn-sm btn-success float-right" target="_blank">'.$name.'</a>';

    }else if($tipe == 'report'){
        return '<a href="'.url(''.$link.'').'" class="btn btn-sm btn-danger float-right">'.$name.'</a>';

    }

}
