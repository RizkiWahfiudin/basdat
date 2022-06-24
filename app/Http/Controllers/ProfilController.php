<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JSvalidation;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Profil::find(Auth::user()->id);

        $validator = JSvalidation::make([
            'nama'      => 'required',
            'email'     => 'required|email',
            'foto'      => 'image|max:1000'
        ]);

        return view('profil')->with([
            'title' => 'Edit Profil',
            'user'  => $user,
            'validator' => $validator
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, Profil $profil)
    {
        // live hosting
        // $file_lama = public_path().'/foto/'.$profil->foto;

        // lokal & vps
        $file_lama = public_path().'/storage/foto/'.$profil->foto;

        if($r->hasFile('foto')){
            $r->validate([
                'nama'  => 'required',
                'email' => 'required|email',
                'foto'  => 'image|max:1000'
            ]);

            $name = time();
            $ext  = $r->foto->getClientOriginalExtension();
            $foto = $name.'.'.$ext;

            $r->foto->storeAs('public/foto', $foto);

            $validator = [
                'nama'  => $r->nama,
                'email' => $r->email,
                'foto'  => $foto
            ];

        }else{
            $validator = $r->validate([
                'nama'  => 'required',
                'email' => 'required|email'
            ]);
        }

        Profil::find($profil->id)->update($validator);
        if(file_exists($file_lama)){
            unlink($file_lama);
        }

        return redirect('/profil')->with(['pesan' => '<div class="alert alert-success">Profil berhasil diperbarui</div>']);
    }

    public function password()
    {
        $user = Profil::find(Auth::user()->id);

        $validator = JSvalidation::make([
            'sandi'     => 'required',
            'password'  => 'required|confirmed|min:6',
        ]);

        return view('password')->with([
            'title' => 'Edit Sandi',
            'user'  => $user,
            'validator' => $validator
        ]);
    }

    public function ganti_password(Request $r, Profil $profil)
    {
        // dd($r->all());
        if(Hash::check($r->sandi, $profil->password)){
            $validasi = $r->validate([
                'sandi'     => 'required',
                'password'  => 'required|confirmed|min:6',
            ]);

            Profil::find($profil->id)->update([
                'password' => Hash::make($r->password),
            ]);

            return redirect('/profil/password')->with(['pesan' => '<div class="alert alert-success">Sandi berhasil dirubah</div>']);

        }else{
            return redirect('/profil/password')->with(['pesan' => '<div class="alert alert-danger">Sandi lama salah</div>']);
        }
    }

}
