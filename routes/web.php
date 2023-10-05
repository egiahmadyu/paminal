<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DatasemenController;
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


Route::middleware(['auth'])->group(function () {
    // Route::get('/', function () {
    //     return view('pages.dashboard.index');
    // });

    Route::get('user', [UserController::class, 'index']);
    Route::post('user/save', [UserController::class, 'store']);
    Route::get('role', [RoleController::class, 'index']);
    Route::get('role/permission/{id}', [RoleController::class, 'permission']);
    Route::get('role/permission/{id}/save', [RoleController::class, 'savePermission']);

    //Dashboard
    Route::prefix('/')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->name('dashboard');
        Route::get('/get-chart/{tipe}', [DashboardController::class, 'getDataChart'])->name('dashboard')->name('get.chart');
        Route::get('/get-data-dumas/{tipe}', [DashboardController::class, 'getDataDumas'])->name('dashboard')->name('get.data.dumas');
        Route::get('/get-data/{tipe}', [DashboardController::class, 'getData'])->name('dashboard')->name('get.data');
    });
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

    // Datasemen & Unit
    Route::get('list-datasemen', [DatasemenController::class, 'listDatasemen'])->name('list.datasemen');
    Route::post('get-datasemen', [DatasemenController::class, 'getDatasemen'])->name('get.datasemen');
    Route::get('unit-datasemen', [DatasemenController::class, 'unitDatasemen'])->name('unit.datasemen');
    Route::post('get-unit', [DatasemenController::class, 'getUnit'])->name('get.unit');
    Route::get('tambah-datasemen', [DatasemenController::class, 'tambahDatasemen'])->name('tambah.datasemen');
    Route::post('store-datasemen', [DatasemenController::class, 'storeDatasemen'])->name('store.datasemen');
    Route::get('edit-datasemen/{id}', [DatasemenController::class, 'editDatasemen'])->name('edit.datasemen');
    Route::post('update-datasemen/{id}', [DatasemenController::class, 'updateDatasemen'])->name('update.datasemen');
    Route::get('delete-datasemen/{id}', [DatasemenController::class, 'deleteDatasemen'])->name('delete.datasemen');
    // End Datasemen

    // Anggota
    Route::get('list-anggota', [AnggotaController::class, 'listAnggota'])->name('list.anggota');
    Route::post('get-anggota', [AnggotaController::class, 'getAnggota'])->name('get.anggota');
    Route::post('tambah-anggota', [AnggotaController::class, 'tambahAnggota'])->name('tambah.anggota');
    Route::post('edit-anggota/{id}', [AnggotaController::class, 'editAnggota'])->name('edit.anggota');
    Route::get('delete-anggota/{id}', [AnggotaController::class, 'deleteAnggota'])->name('delete.anggota');
    // End Anggota

    // Tambah Saksi
    Route::post('/tambah-saksi/{id}', [PulbaketController::class, 'tambahSaksi'])->name('tambah.saksi');

    // View Kasus
    Route::get('data-kasus/view/{kasus_id}/{id}', [KasusController::class, 'viewProcess'])->name('kasus.proses.view');
    Route::get('pulbaket/view/next-data/{id}', [PulbaketController::class, 'viewNextData'])->name('kasus.pulbaket.next');

    // End View Kasus

    // Generate
    Route::get('/lembar-disposisi/{id}', [LimpahPoldaController::class, 'generateDisposisi']);
    Route::post('/lembar-disposisi/{id}', [LimpahPoldaController::class, 'generateDisposisi']);
    // Route::get('/lembar-disposisi/{id}/{type}', [LimpahPoldaController::class, 'downloadDisposisi']);
    Route::post('/surat-limpah-polda/{id}', [LimpahPoldaController::class, 'generateLimpahPolda']);
    Route::get('/surat-perintah/{id}', [PulbaketController::class, 'printSuratPerintah']);
    Route::get('/surat-perintah-pengantar/{id}', [PulbaketController::class, 'printSuratPengantarSprin']);
    Route::post('/surat-perintah/{id}', [PulbaketController::class, 'printSuratPerintah']);
    Route::get('/surat-uuk/{id}', [PulbaketController::class, 'printUUK']);
    Route::get('/surat-sp2hp2-awal/{id}', [PulbaketController::class, 'sp2hp2Awal']);
    Route::get('/surat-sp2hp2-akhir/{id}', [PulbaketController::class, 'sp2hp2Akhir']);
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
    Route::get('/undangan-klarifikasi/{id}', [PulbaketController::class, 'printUndanganKlarifikasi']);
    Route::post('/undangan-klarifikasi/{id}', [PulbaketController::class, 'printUndanganKlarifikasi']);
    Route::get('/laporan-hasil-limpah-biro/{id}', [ProvostWabprofController::class, 'printLimpahBiro']);


    Route::post('/limpah-biro/{id}', [ProvostWabprofController::class, 'simpanData']);



    // Route::group(['middleware' => ['role:super-admin']], function () {
    //     Route::get('/user',[UserController::class, 'index'])->name('user-index');
    //     Route::get('/role',[RoleController::class, 'index'])->name('role-index');
    // });
});
