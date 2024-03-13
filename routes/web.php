<?php

use App\Http\Controllers\FormatKuitansiController;
use App\Http\Controllers\FormatKutipanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JenisLelangController;
use App\Http\Controllers\KategoriPemohonController;
use App\Http\Controllers\LaporanGudangController;
use App\Http\Controllers\LaporanRealisasiLelang;
use App\Http\Controllers\LaporanRealisasiLelangJumlah;
use App\Http\Controllers\LaporanRealisasiLelangPejabat;
use App\Http\Controllers\LaporanRealisasiLelangPerbarang;
use App\Http\Controllers\LaporanRisalahLelang;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PejabatLelangController;
use App\Http\Controllers\RakGudangController;
use App\Http\Controllers\RakGudangDetailController;
use App\Http\Controllers\RisalahLelangController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

Route::group(['middleware' => ['auth'],'prefix' => 'administrator','namespace' => 'administrator'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/manage/logout', [LoginController::class, 'logout'])->name('manage.logout');

    Route::group(['middleware' => ['can:pejabat_lelang'], 'namespace' => 'pejabat_lelang' ,'prefix' => 'pejabat_lelang'], function(){
        Route::get('/', [PejabatLelangController::class, 'index'])->name('pejabat_lelang.index');
        Route::get('/create', [PejabatLelangController::class, 'create'])->name('pejabat_lelang.create');
        Route::post('/store', [PejabatLelangController::class, 'store'])->name('pejabat_lelang.store');
        Route::get('edit/{id}', [PejabatLelangController::class, 'edit'])->name('pejabat_lelang.edit');
        Route::post('update/{id}', [PejabatLelangController::class, 'update'])->name('pejabat_lelang.update');
        Route::delete('destroy', [PejabatLelangController::class, 'destroy'])->name('pejabat_lelang.destroy');
    });

    Route::group(['middleware' => ['can:kategori_pemohon'], 'namespace' => 'kategori_pemohon', 'prefix' => 'kategori_pemohon'], function(){
        Route::get('/', [KategoriPemohonController::class, 'index'])->name('kategori_pemohon.index');
        Route::get('/create', [KategoriPemohonController::class, 'create'])->name('kategori_pemohon.create');
        Route::post('/store', [KategoriPemohonController::class, 'store'])->name('kategori_pemohon.store');
        Route::get('edit/{id}', [KategoriPemohonController::class, 'edit'])->name('kategori_pemohon.edit');
        Route::post('update/{id}', [KategoriPemohonController::class, 'update'])->name('kategori_pemohon.update');
        Route::delete('destroy', [KategoriPemohonController::class, 'destroy'])->name('kategori_pemohon.destroy');
    });

    Route::group(['middleware' => ['can:jenis_lelang'], 'namespace' => 'jenis_lelang', 'prefix' => 'jenis_lelang'], function(){
        Route::get('/', [JenisLelangController::class, 'index'])->name('jenis_lelang.index');
        Route::get('/create', [JenisLelangController::class, 'create'])->name('jenis_lelang.create');
        Route::post('/store', [JenisLelangController::class, 'store'])->name('jenis_lelang.store');
        Route::get('edit/{id}', [JenisLelangController::class, 'edit'])->name('jenis_lelang.edit');
        Route::post('update/{id}', [JenisLelangController::class, 'update'])->name('jenis_lelang.update');
        Route::delete('destroy', [JenisLelangController::class, 'destroy'])->name('jenis_lelang.destroy');
    });

    Route::group(['middleware' => ['can:risalah_lelang'], 'namespace' => 'risalah_lelang', 'prefix' => 'risalah_lelang', 'as' => 'risalah_lelang.'], function(){
        Route::get('/', [RisalahLelangController::class, 'index'])->name('index');
        Route::get('add', [RisalahLelangController::class, 'add'])->name('add');
        Route::post('/create', [RisalahLelangController::class, 'create'])->name('create');
        Route::get('edit/{id}', [RisalahLelangController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [RisalahLelangController::class, 'update'])->name('update');
        Route::delete('destroy', [RisalahLelangController::class, 'destroy'])->name('destroy');
        Route::get('detail/{id}', [RisalahLelangController::class, 'detail'])->name('detail');
        Route::post('getNomorRak', [RisalahLelangController::class, 'getNomorRak'])->name('getNomorRak');
    });

    Route::group(['middleware' => ['can:rak_gudang'], 'namespace' => 'rak_gudang', 'prefix' => 'rak_gudang'], function(){
        Route::get('/', [RakGudangController::class, 'index'])->name('rak_gudang.index');
        Route::get('/create', [RakGudangController::class, 'create'])->name('rak_gudang.create');
        Route::post('/store', [RakGudangController::class, 'store'])->name('rak_gudang.store');
        Route::get('edit/{id}', [RakGudangController::class, 'edit'])->name('rak_gudang.edit');
        Route::post('update/{id}', [RakGudangController::class, 'update'])->name('rak_gudang.update');
        Route::delete('destroy', [RakGudangController::class, 'destroy'])->name('rak_gudang.destroy');
    });

    Route::group(['middleware' => ['can:rak_detail'], 'namespace' => 'rak_detail', 'prefix' => 'rak_detail'], function(){
        Route::get('/', [RakGudangDetailController::class, 'index'])->name('rak_detail.index');
        Route::get('/create', [RakGudangDetailController::class, 'create'])->name('rak_detail.create');
        Route::post('/store', [RakGudangDetailController::class, 'store'])->name('rak_detail.store');
        Route::get('edit/{id}', [RakGudangDetailController::class, 'edit'])->name('rak_detail.edit');
        Route::post('update/{id}', [RakGudangDetailController::class, 'update'])->name('rak_detail.update');
        Route::delete('destroy', [RakGudangDetailController::class, 'destroy'])->name('rak_detail.destroy');
    });

    Route::group(['middleware' => ['can:user'], 'namespace' => 'user' ,'prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('add', [UserController::class, 'add'])->name('user.add');
        Route::post('store', [UserController::class, 'store'])->name('user.store');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::put('reset/password', [UserController::class, 'resetPassword'])->name('user.reset');
        Route::delete('delete', [UserController::class, 'delete'])->name('user.delete');
    });

    Route::group(['middleware' => ['can:role'], 'namespace' => 'role', 'prefix' => 'role', 'as' => 'role.'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/add', [RoleController::class, 'add'])->name('add');
        Route::post('store', [RoleController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [RoleController::class, 'update'])->name('update');
        Route::delete('/delete', [RoleController::class, 'delete'])->name('delete');
    });

    Route::group(['namespace' => 'laporan_gudang', 'prefix' => 'laporan_gudang', 'as' => 'laporan_gudang.'], function () {
        Route::get('/', [LaporanGudangController::class, 'index'])->name('index');
        Route::get('/risalah', [LaporanRisalahLelang::class, 'index'])->name('index-risalah');
        Route::get('/realisasi', [LaporanRealisasiLelangPerbarang::class, 'index'])->name('index-perbarang');
        Route::get('/jumlah', [LaporanRealisasiLelangJumlah::class, 'index'])->name('index-jumlah');
        Route::get('/pejabat', [LaporanRealisasiLelangPejabat::class, 'index'])->name('index-pejabat');
        Route::get('/pertahun', [LaporanRealisasiLelang::class, 'index'])->name('index-pertahun');
        Route::get('/excel', [LaporanGudangController::class, 'laporanGudangToExcel'])->name('printExcel');
        Route::get('/excel/risalah', [LaporanRisalahLelang::class, 'laporanRisalahLelang'])->name('printExcelRisalah');
        Route::get('/excel/perbarang', [LaporanRealisasiLelangPerbarang::class, 'laporanRealisasiPerJenis'])->name('printExcelPerbarang');
        Route::get('/excel/jumlah', [LaporanRealisasiLelangJumlah::class, 'laporanRealisasiJumlahPerjenis'])->name('printExcelJumlah');
        Route::get('/excel/pejabat', [LaporanRealisasiLelangPejabat::class, 'laporanRealisasiPejabat'])->name('printExcelPejabat');
        Route::get('/excel/pertahun', [LaporanRealisasiLelang::class, 'laporanRealisasiPerTahun'])->name('printExcelPertahun');
    });

    Route::group(['namespace' => 'format', 'prefix' => 'format', 'as' => 'format.'], function () {
        Route::get('/', [FormatKutipanController::class, 'index'])->name('index');
        Route::get('add/{id}', [FormatKutipanController::class, 'add'])->name('add');
        Route::post('kutipan/{id}', [FormatKutipanController::class, 'kutipanPdf'])->name('kutipan');
    });

    Route::group(['namespace' => 'kuitansi', 'prefix' => 'kuitansi', 'as' => 'kuitansi.'], function () {
        Route::get('/', [FormatKuitansiController::class, 'index'])->name('index');
        Route::get('add/{id}', [FormatKuitansiController::class, 'add'])->name('add');
        Route::post('kuitansi/{id}', [FormatKuitansiController::class, 'kuitansiPdf'])->name('kuitansi');
    });

});
