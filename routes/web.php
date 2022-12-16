<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GolonganTarifController;

use App\Http\Controllers\CatatMeterController;
use App\Http\Controllers\PembayaranController;

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
        'level'=>'admin'
    ]);
});


Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin'])->name('doLogin');


Route::middleware(['auth'])->group(function () {
    Route::get('/', [AuthController::class, 'dashboard'])->name('auth.dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/resetPassword', [ProfileController::class, 'resetPassword'])->name('auth.logout');
    Route::post('/resetPasswordSave', [ProfileController::class, 'resetPasswordSave'])->name('auth.logout');

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
            Route::get('/cetakQr/{idPegawai}', [PelangganController::class, 'cetakQr'])->name('admin.pelanggan.cetakQr');
        });

        Route::prefix('golonganTarif')->group(function () {
            Route::get('/', [GolonganTarifController::class, 'index'])->name('admin.golonganTarif.index');
            Route::get('/add', [GolonganTarifController::class, 'add'])->name('admin.golonganTarif.add');
            Route::get('/edit/{idPegawai}', [GolonganTarifController::class, 'edit'])->name('admin.golonganTarif.edit');
            Route::post('/addSave', [GolonganTarifController::class, 'addSave'])->name('admin.golonganTarif.addSave');
            Route::post('/editSave', [GolonganTarifController::class, 'editSave'])->name('admin.golonganTarif.editSave');
            Route::get('/remove/{idPegawai}', [GolonganTarifController::class, 'remove'])->name('admin.golonganTarif.remove');
        });

        Route::prefix('pembayaran')->group(function () {
            Route::get('/', [PembayaranController::class, 'index'])->name('admin.pegawai.index');

            Route::get('/bayar/{idPelanggan}', [PembayaranController::class, 'bayar'])->name('admin.pegawai.bayar');
            Route::post('/bayarSave', [PembayaranController::class, 'bayarSave'])->name('admin.pegawai.bayarSave');
        });


        Route::prefix('setting')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('admin.pegawai.index');
            Route::post('/settingSave', [SettingController::class, 'settingSave'])->name('admin.pegawai.settingSave');
        });
    });

    Route::prefix('pencatatMeter')->group(function () {

        Route::get('/catatMeterQr', [CatatMeterController::class, 'qr'])->name('admin.pegawai.qr');

        Route::prefix('catatMeter')->group(function () {
            Route::get('/', [CatatMeterController::class, 'index'])->name('admin.pegawai.index');
            Route::get('/add/{idPelanggan}', [CatatMeterController::class, 'add']);
            Route::get('/edit/{idPelanggan}', [CatatMeterController::class, 'edit'])->name('admin.pegawai.edit');
            Route::post('/addSave', [CatatMeterController::class, 'addSave'])->name('admin.pegawai.addSave');
        });

        Route::prefix('pembayaran')->group(function () {
            Route::get('/', [PembayaranController::class, 'index'])->name('admin.pegawai.index');

            Route::get('/bayar/{idPelanggan}', [PembayaranController::class, 'bayar'])->name('admin.pegawai.bayar');
            Route::post('/bayarSave', [PembayaranController::class, 'bayarSave'])->name('admin.pegawai.bayarSave');
        });
    });

    
});