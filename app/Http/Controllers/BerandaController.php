<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Http;

class BerandaController extends Controller
{
    public function index() {
        return view('frontend.index')->with([
            'title' => 'Landing Page'
        ]);
    }

    public function logout() {
        session()->forget(['member','member_id']);
        return redirect(url('/'));
    }
}
