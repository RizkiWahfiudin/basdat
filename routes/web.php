<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\RolesItemController;
use App\Http\Controllers\UmumController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/', [BerandaController::class, 'index']);
Route::get('/', function () { return redirect('/login'); });
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::view('/404', '404');

Route::middleware(['auth'])->group(function () {
    // home
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/home/eventByMonth', [HomeController::class, 'eventByMonth'])->name('home.eventByMonth');
    Route::post('/home/eventByRegion', [HomeController::class, 'eventByRegion'])->name('home.eventByRegion');

    Route::get('/logout', [LoginController::class, 'logout']);
    Route::get('/profil', [ProfilController::class, 'index']);
    Route::patch('/profil/{profil}', [ProfilController::class, 'update']);
    Route::get('/profil/password', [ProfilController::class, 'password']);
    Route::patch('/ganti-password/{profil}', [ProfilController::class, 'ganti_password']);
    Route::resource('umum', UmumController::class);

    // User
    Route::resource('user', UserController::class);
    Route::get('/user/delete/{id}', [UserController::class, 'delete']);
    Route::post('/ajaxUser', [UserController::class, 'ajax']);

    // Roles
    Route::get('/roles/pilihan', [RolesController::class, 'pilihan']);
    Route::get('/roles/pilih/{roles}', [RolesController::class, 'pilih']);
    Route::post('/ajaxRoles', [RolesController::class, 'ajax']);
    Route::get('/roles/delete/{id}', [RolesController::class, 'delete']);
    Route::resource('roles', RolesController::class);

    // Role Item
    Route::post('/ajaxRolesItem', [RolesItemController::class, 'ajax']);
    Route::get('/rolesitem/delete/{id}', [RolesItemController::class, 'delete']);
    Route::resource('rolesitem', RolesItemController::class);

    // Master Region
    Route::resource('region', RegionController::class);
    Route::get('/region/delete/{id}', [RegionController::class, 'delete']);
    Route::post('/ajaxRegion', [RegionController::class, 'ajax']);

    // Master Kota
    Route::resource('kota', KotaController::class);
    Route::get('/kota/delete/{id}', [KotaController::class, 'delete']);
    Route::post('/ajaxKota', [KotaController::class, 'ajax']);

    // Master Kategori
    Route::resource('kategori', KategoriController::class);
    Route::get('/kategori/delete/{id}', [KategoriController::class, 'delete']);
    Route::post('/ajaxKategori', [KategoriController::class, 'ajax']);

    // Event
    Route::resource('event', EventController::class);
    Route::get('/event/delete/{id}', [EventController::class, 'delete']);
    Route::post('/ajaxEvent', [EventController::class, 'ajax']);
    Route::post('event/getKota', [EventController::class, 'getKota'])->name('event.getKota');

    Route::view('/403', '403');
});
