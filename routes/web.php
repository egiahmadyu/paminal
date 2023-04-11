<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GelarPerkaraController;
use App\Http\Controllers\KasusController;
use App\Http\Controllers\LimpahPoldaController;
use App\Http\Controllers\ProvostWabprofController;
use App\Http\Controllers\PulbaketController;
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
//     return view('partials.master');
// });

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/pdf-test', [LimpahPoldaController::class, 'generateDocumen']);
// Route::get('/lembar-disposisi', [LimpahPoldaController::class, 'generateDisposisi']);
Route::post('login', [AuthController::class, 'loginAction'])->name('login-action');


Route::middleware(['auth'])->group(function (){
    // Route::get('/', function () {
    //     return view('pages.dashboard.index');
    // });

    Route::get('user', [UserController::class, 'index']);
    Route::post('user/save', [UserController::class, 'store']);
    Route::get('role', [RoleController::class, 'index']);
    Route::get('role/permission/{id}', [RoleController::class, 'permission']);
    Route::get('role/permission/{id}/save', [RoleController::class, 'savePermission']);

    //Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    // View Kasus
    Route::get('data-kasus', [KasusController::class, 'index'])->name('kasus.index');
    Route::post('data-kasus/data', [KasusController::class, 'data'])->name('kasus.data');
    Route::post('data-kasus/update', [KasusController::class, 'updateData'])->name('kasus.update');
    Route::get('data-kasus/detail/{id}', [KasusController::class, 'detail'])->name('kasus.detail');
    Route::post('data-kasus/status/update', [KasusController::class, 'updateStatus'])->name('kasus.update.status');
    // End View Kasus

    // Create Kasus
    Route::get('input-data-kasus', [KasusController::class, 'inputKasus'])->name('kasus.input');
    Route::post('input-data-kasus/store', [KasusController::class, 'storeKasus'])->name('kasus.store.kasus');
    // End View Kasus

    // Tambah Saksi
    Route::post('/tambah-saksi/{id}',[PulbaketController::class, 'tambahSaksi'])->name('tambah.saksi');

    // View Kasus
    Route::get('data-kasus/view/{kasus_id}/{id}', [KasusController::class, 'viewProcess'])->name('kasus.proses.view');
    Route::get('pulbaket/view/next-data/{id}', [PulbaketController::class, 'viewNextData'])->name('kasus.pulbaket.next');

    // End View Kasus

    // Generate
    Route::get('/lembar-disposisi/{id}', [LimpahPoldaController::class, 'generateDisposisi']);
    Route::post('/lembar-disposisi/{id}', [LimpahPoldaController::class, 'generateDisposisi']);
    // Route::get('/lembar-disposisi/{id}/{type}', [LimpahPoldaController::class, 'downloadDisposisi']);
    Route::post('/surat-limpah-polda', [LimpahPoldaController::class, 'generateLimpahPolda']);
    Route::get('/surat-perintah/{id}', [PulbaketController::class, 'printSuratPerintah']);
    Route::get('/surat-perintah-pengantar/{id}', [PulbaketController::class, 'printSuratPengantarSprin']);
    Route::post('/surat-perintah/{id}', [PulbaketController::class, 'printSuratPerintah']);
    Route::get('/surat-uuk/{id}', [PulbaketController::class, 'printUUK']);
    Route::get('/surat-sp2hp2-awal/{id}', [PulbaketController::class, 'sp2hp2Awal']);
    Route::get('/gelar-perkara-undangan/{id}', [GelarPerkaraController::class, 'printUGP']);
    Route::get('/notulen-gelar-perkara/{id}', [GelarPerkaraController::class, 'notulenHasilGelar']);
    Route::get('/nd-hasil-gelar-perkara/{id}', [GelarPerkaraController::class, 'laporanHasilGelar']);
    Route::get('/gelar-perkara-baglitpers/{id}', [GelarPerkaraController::class, 'baglitpers']);
    Route::get('/bai-sipil/{id}', [PulbaketController::class, 'printBaiSipil']);
    Route::get('/bai-anggota/{id}', [PulbaketController::class, 'printBaiAnggota']);
    Route::get('/laporan-hasil-penyelidikan/{id}', [PulbaketController::class, 'lhp'])->name('download-lhp');
    Route::post('/laporan-hasil-penyelidikan/{id}', [PulbaketController::class, 'lhp'])->name('generate-lhp');
    Route::get('/nd-permohonan-gerlar/{id}', [PulbaketController::class, 'ndPG']);
    Route::post('/nd-permohonan-gerlar/{id}', [PulbaketController::class, 'ndPG']);
    Route::get('/undangan-klarifikasi/{id}',[PulbaketController::class, 'printUndanganKlarifikasi']);
    Route::post('/undangan-klarifikasi/{id}',[PulbaketController::class, 'printUndanganKlarifikasi']);
    Route::get('/laporan-hasil-limpah-biro/{id}',[ProvostWabprofController::class, 'printLimpahBiro']);
   


    Route::post('/limpah-biro/{id}', [ProvostWabprofController::class, 'simpanData']);

    // Route::group(['middleware' => ['role:super-admin']], function () {
    //     Route::get('/user',[UserController::class, 'index'])->name('user-index');
    //     Route::get('/role',[RoleController::class, 'index'])->name('role-index');
    // });
});