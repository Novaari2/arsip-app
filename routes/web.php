<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\JenisLelangController;
use App\Http\Controllers\KategoriPemohonController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PejabatLelangController;
use App\Http\Controllers\RakGudangController;
use App\Http\Controllers\RisalahLelangController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LoginController::class, 'index'])->name('manage.login');
Route::post('/manage/login', [LoginController::class, 'checkLogin'])->name('manage.checkLogin');

Route::group(['middleware' => 'auth','prefix' => 'administrator','namespace' => 'administrator'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/manage/logout', [LoginController::class, 'logout'])->name('manage.logout');

    Route::group(['namespace' => 'pejabat_lelang', 'prefix' => 'pejabat_lelang'], function(){
        Route::get('/', [PejabatLelangController::class, 'index'])->name('pejabat_lelang.index');
        Route::get('/create', [PejabatLelangController::class, 'create'])->name('pejabat_lelang.create');
        Route::post('/store', [PejabatLelangController::class, 'store'])->name('pejabat_lelang.store');
        Route::get('edit/{id}', [PejabatLelangController::class, 'edit'])->name('pejabat_lelang.edit');
        Route::post('update/{id}', [PejabatLelangController::class, 'update'])->name('pejabat_lelang.update');
        Route::delete('destroy', [PejabatLelangController::class, 'destroy'])->name('pejabat_lelang.destroy');
    });

    Route::group(['namespace' => 'kategori_pemohon', 'prefix' => 'kategori_pemohon'], function(){
        Route::get('/', [KategoriPemohonController::class, 'index'])->name('kategori_pemohon.index');
        Route::get('/create', [KategoriPemohonController::class, 'create'])->name('kategori_pemohon.create');
        Route::post('/store', [KategoriPemohonController::class, 'store'])->name('kategori_pemohon.store');
        Route::get('edit/{id}', [KategoriPemohonController::class, 'edit'])->name('kategori_pemohon.edit');
        Route::post('update/{id}', [KategoriPemohonController::class, 'update'])->name('kategori_pemohon.update');
        Route::delete('destroy', [KategoriPemohonController::class, 'destroy'])->name('kategori_pemohon.destroy');
    });

    Route::group(['namespace' => 'jenis_lelang', 'prefix' => 'jenis_lelang'], function(){
        Route::get('/', [JenisLelangController::class, 'index'])->name('jenis_lelang.index');
        Route::get('/create', [JenisLelangController::class, 'create'])->name('jenis_lelang.create');
        Route::post('/store', [JenisLelangController::class, 'store'])->name('jenis_lelang.store');
        Route::get('edit/{id}', [JenisLelangController::class, 'edit'])->name('jenis_lelang.edit');
        Route::post('update/{id}', [JenisLelangController::class, 'update'])->name('jenis_lelang.update');
        Route::delete('destroy', [JenisLelangController::class, 'destroy'])->name('jenis_lelang.destroy');
    });

    Route::group(['namespace' => 'risalah_lelang', 'prefix' => 'risalah_lelang'], function(){
        Route::get('/', [RisalahLelangController::class, 'index'])->name('risalah_lelang.index');
        Route::get('/add', [RisalahLelangController::class, 'add'])->name('risalah_lelang.add');
        Route::post('/create', [RisalahLelangController::class, 'create'])->name('risalah_lelang.create');
    });

    Route::group(['namespace' => 'rak_gudang', 'prefix' => 'rak_gudang'], function(){
        Route::get('/', [RakGudangController::class, 'index'])->name('rak_gudang.index');
        Route::get('/create', [RakGudangController::class, 'create'])->name('rak_gudang.create');
        Route::post('/store', [RakGudangController::class, 'store'])->name('rak_gudang.store');
        Route::get('edit/{id}', [RakGudangController::class, 'edit'])->name('rak_gudang.edit');
        Route::post('update/{id}', [RakGudangController::class, 'update'])->name('rak_gudang.update');
        Route::delete('destroy', [RakGudangController::class, 'destroy'])->name('rak_gudang.destroy');
    });
});
