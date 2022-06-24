<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JSvalidation;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function index()
    {
        $title = 'Login Administrator';

        if (Auth::check()) {
            return redirect(route('home'));
        }

        $validator = JSvalidation::make([
            'username'  => 'required',
            'password'  => 'required'
        ]);

        return view('login.login')->with([
            'title'     => $title,
            'validator' => $validator
        ]);
    }

    public function login(Request $r)
    {
        if (Auth::attempt([
            'username' => $r->username,
            'password' => $r->password,
            'status'   => 'y'
        ])) {

            return redirect('/roles/pilihan');

        }else{
            return redirect(route('login'))->with([
                'pesan' => '<div class="alert alert-danger">Login gagal, username atau password salah!</div>'
            ]);
        }

        return redirect(route('home'));
    }

    public function logout()
    {
        activity()->log('Melakukan Logout');
        session()->flush();
        return redirect(route('home'));
    }
}
