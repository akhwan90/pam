<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\UserController;

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

Route::get('/crtUser', function () {
    User::insert([
        'name'=>'Administrator',
        'email'=>'administrator@system.net',
        'email_verified_at'=>date('Y-m-d H:i:s'),
        'password'=>password_hash('admin123', PASSWORD_DEFAULT),
        'created_at'=>date('Y-m-d H:i:s'),
    ]);
});


Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin'])->name('doLogin');


Route::middleware(['auth'])->group(function () {
    Route::get('/', [AuthController::class, 'dashboard'])->name('auth.dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::prefix('admin')->group(function () {

        Route::prefix('pegawai')->group(function () {
            Route::get('/', [PegawaiController::class, 'index'])->name('admin.pegawai.index');
            Route::get('/add', [PegawaiController::class, 'add'])->name('admin.pegawai.add');
            Route::get('/edit/{idPegawai}', [PegawaiController::class, 'edit'])->name('admin.pegawai.edit');
            Route::post('/addSave', [PegawaiController::class, 'addSave'])->name('admin.pegawai.addSave');
            Route::post('/editSave', [PegawaiController::class, 'editSave'])->name('admin.pegawai.editSave');
            Route::get('/remove/{idPegawai}', [PegawaiController::class, 'remove'])->name('admin.pegawai.remove');
        });

        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.user.index');
            Route::get('/add', [UserController::class, 'add'])->name('admin.user.add');
            Route::get('/edit/{idUser}', [UserController::class, 'edit'])->name('admin.user.edit');
            Route::post('/addSave', [UserController::class, 'addSave'])->name('admin.user.addSave');
            Route::post('/editSave', [UserController::class, 'editSave'])->name('admin.user.editSave');
            Route::get('/remove/{idUser}', [UserController::class, 'remove'])->name('admin.user.remove');
        });

        Route::prefix('pelanggan')->group(function () {
            Route::get('/', [PelangganController::class, 'index'])->name('admin.pelanggan.index');
            Route::get('/add', [PelangganController::class, 'add'])->name('admin.pelanggan.add');
            Route::get('/edit/{idPegawai}', [PelangganController::class, 'edit'])->name('admin.pelanggan.edit');
            Route::post('/addSave', [PelangganController::class, 'addSave'])->name('admin.pelanggan.addSave');
            Route::post('/editSave', [PelangganController::class, 'editSave'])->name('admin.pelanggan.editSave');
            Route::get('/remove/{idPegawai}', [PelangganController::class, 'remove'])->name('admin.pelanggan.remove');
        });
    });
});