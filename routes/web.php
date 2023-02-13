<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KasusController;
use App\Http\Controllers\LimpahPoldaController;
use App\Http\Controllers\PulbaketController;
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
    Route::get('/', function () {
        return view('pages.dashboard.index');
    });

    Route::get('data-kasus', [KasusController::class, 'index'])->name('kasus.index');
    Route::post('data-kasus/data', [KasusController::class, 'data'])->name('kasus.data');
    Route::post('data-kasus/update', [KasusController::class, 'updateData'])->name('kasus.update');
    Route::get('data-kasus/detail/{id}', [KasusController::class, 'detail'])->name('kasus.detail');
    Route::post('data-kasus/status/update', [KasusController::class, 'updateStatus'])->name('kasus.update.status');

    // View Kasus
    Route::get('data-kasus/view/{kasus_id}/{id}', [KasusController::class, 'viewProcess'])->name('kasus.proses.view');

    // End View Kasus

    // Generate
    Route::post('/lembar-disposisi', [LimpahPoldaController::class, 'generateDisposisi']);
    Route::post('/surat-limpah-polda', [LimpahPoldaController::class, 'generateLimpahPolda']);
    Route::get('/surat-perintah/{id}', [PulbaketController::class, 'printSuratPerintah']);
    Route::post('/surat-perintah/{id}', [PulbaketController::class, 'printSuratPerintah']);
    Route::get('/surat-uuk/{id}', [PulbaketController::class, 'printUUK']);
    Route::get('/surat-sp2hp2-awal/{id}', [PulbaketController::class, 'sp2hp2Awal']);

    // Route::group(['middleware' => ['role:super-admin']], function () {
    //     Route::get('/user',[UserController::class, 'index'])->name('user-index');
    //     Route::get('/role',[RoleController::class, 'index'])->name('role-index');
    // });
});