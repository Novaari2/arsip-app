<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PejabatLelangController;
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
});
