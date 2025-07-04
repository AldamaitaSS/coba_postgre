<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\GaleriController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Route::get('/', [HomeController::class, 'index']);
// Route::get('/faq', function () {
//     return view('user.faq');
// });


// Route::get('/', function () {
//     return view('welcome');
// });

// Admin
// Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

// Route::get('/admin/login', [AuthController::class, 'login'])->name('login');
// Route::post('/admin/login', [AuthController::class, 'postlogin']);
// Route::get('/admin/logout', [AuthController::class, 'logout'])->middleware('auth');

// // Admin

// Route::middleware(['auth'])->group(function () {
    
    // Route::group(['middleware' => 'authorize:1'], function () {
        Route::get('/admin/', [WelcomeController::class, 'index'])->name('admin.hallo');
    // });
    // Route::get('/admin/profile', [ProfileController::class, 'index'])->name('admin.profile.index');
    // Route::patch('/admin/profile/{id}', [ProfileController::class, 'update'])->name('admin.profile.update');

     Route::group(['prefix' => '/admin/data_editor'], function(){
        Route::get('/', [EditorController::class, 'index']);
        Route::post('list', [EditorController::class, 'list']);
        Route::get('/create_ajax', [EditorController::class, 'create_ajax']);
        Route::post('/ajax', [EditorController::class, 'store_ajax']);
        Route::get('/{id}/show_ajax', [EditorController::class, 'show_ajax']);
        Route::get('/{id}/edit_ajax', [EditorController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [EditorController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [EditorController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [EditorController::class, 'delete_ajax']);
        Route::get('/import', [EditorController::class, 'import']);                      // ajax form upload excel
        Route::post('/import_ajax', [EditorController::class, 'import_ajax']);           // ajax import excel
        Route::get('/export_excel', [EditorController::class, 'export_excel']);          // ajax import excel
        Route::get('/export_pdf', [EditorController::class, 'export_pdf']);
        Route::get('/export_template', [EditorController::class, 'exportTemplate']);
    });

     Route::group(['prefix' => '/admin/galeri'], function () {
        Route::get('/', [GaleriController::class, 'index']);
        Route::post('list', [GaleriController::class, 'list']);
        Route::get('/create_ajax', [GaleriController::class, 'create_ajax']);
        Route::post('/ajax', [GaleriController::class, 'store_ajax']);
        Route::get('/{id}/show_ajax', [GaleriController::class, 'show_ajax']); // route untuk detail
        Route::get('/{id}/edit_ajax', [GaleriController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [GaleriController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [GaleriController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [GaleriController::class, 'delete_ajax']);
    });

     Route::group(['prefix' => '/admin/artikel'], function () {
        Route::get('/', [ArtikelController::class, 'index']);
        Route::post('list', [ArtikelController::class, 'list']);
        Route::get('/create_ajax', [ArtikelController::class, 'create_ajax']);
        Route::post('/ajax', [ArtikelController::class, 'store_ajax']);
        Route::get('/{id}/show_ajax', [ArtikelController::class, 'show_ajax']); // route untuk detail
        Route::get('/{id}/edit_ajax', [ArtikelController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [ArtikelController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [ArtikelController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [ArtikelController::class, 'delete_ajax']);
    });

    // Route::group(['prefix' => 'admin/agenda'], function () {
    //     Route::get('/', [AgendaController::class, 'index'])->name('admin.agenda.index');
    //     Route::get('/create', [AgendaController::class, 'create'])->name('admin.agenda.create');
    //     Route::post('/', [AgendaController::class, 'store'])->name('admin.agenda.store');
    //     Route::get('/create_ajax', [AgendaController::class, 'create_ajax'])->name('admin.agenda.create_ajax');
    //     Route::get('/{id}', [AgendaController::class, 'show'])->name('admin.agenda.detail');
    //     Route::get('/{id}/edit', [AgendaController::class, 'edit'])->name('admin.agenda.edit');
    //     Route::put('/{id}', [AgendaController::class, 'update'])->name('admin.agenda.update');
    //     Route::delete('/{id}', [AgendaController::class, 'destroy'])->name('admin.agenda.destroy');
    //     Route::get('/{id}/show_ajax', [AgendaController::class, 'show_ajax'])->name('admin.agenda.show_ajax');
    //     Route::get('/{id}/edit_ajax', [AgendaController::class, 'edit_ajax'])->name('admin.agenda.edit_ajax');
    //     Route::get('/{id}/confirm', [AgendaController::class, 'confirm'])->name('admin.agenda.confirm');
    // });

    // // versi 1
    // Route::group(['prefix' => '/admin/promosi'], function () {
    //     Route::get('/', [PromosiController::class, 'index']);
    //     Route::post('list', [PromosiController::class, 'list']);
    //     Route::get('/create_ajax', [PromosiController::class, 'create_ajax']);
    //     Route::post('/ajax', [PromosiController::class, 'store_ajax']);
    //     Route::get('/{id}/show_ajax', [PromosiController::class, 'show_ajax']); // route untuk detail
    //     Route::get('/{id}/edit_ajax', [PromosiController::class, 'edit_ajax']);
    //     Route::put('/{id}/update_ajax', [PromosiController::class, 'update_ajax']);
    //     Route::get('/{id}/delete_ajax', [PromosiController::class, 'confirm_ajax']);
    //     Route::delete('/{id}/delete_ajax', [PromosiController::class, 'delete_ajax']);
    // });

    // //Versi 2
    // // Route::prefix('admin/promosi')->name('admin.promosi.')->group(function () {
    // //     Route::get('/', [PromosiController::class, 'index'])->name('index');
    // //     Route::get('/create', [PromosiController::class, 'create'])->name('create');
    // //     Route::post('/', [PromosiController::class, 'store'])->name('store');
    // //     Route::get('/{id}/edit', [PromosiController::class, 'edit'])->name('edit');
    // //     Route::put('/{id}', [PromosiController::class, 'update'])->name('update');
    // //     Route::delete('/{id}', [PromosiController::class, 'destroy'])->name('destroy');
    // // });

    // Route::group(['prefix' => 'admin/data_pengguna'], function () {
    //     Route::get('/', [DataPenggunaController::class, 'index'])->name('admin.data_pengguna.index');
    //     Route::get('/{id}/show_ajax', [DataPenggunaController::class, 'show_ajax'])->name('admin.data_pengguna.show_ajax');
    //     Route::put('/{id}/update_status', [DataPenggunaController::class, 'updateStatus'])->name('admin.data_pengguna.update_status');
    //     Route::get('/setuju_ajax/{id}', [DataPenggunaController::class, 'setujuAjax'])->name('admin.data_pengguna.setuju_ajax');
    //     Route::put('/setuju/{id}', [DataPenggunaController::class, 'setuju'])->name('admin.data_pengguna.setuju');
    //     Route::get('/tolak_ajax/{id}', [DataPenggunaController::class, 'tolakAjax'])->name('admin.data_pengguna.tolak_ajax');
    //     Route::put('data_pengguna/tolak/{id}', [DataPenggunaController::class, 'tolak'])->name('admin.data_pengguna.tolak');
    // });

    // Route::group(['prefix' => '/admin/profil_kantor'], function () {
    //     Route::get('/', [ProfilKantorController::class, 'index']);
    //     Route::get('/{id}/edit_ajax', [ProfilKantorController::class, 'edit_ajax']);
    //     Route::put('/{id}/update_ajax', [ProfilKantorController::class, 'update_ajax']);
    // });

// });

// USER //

// Landing Page
// Route::get('/user', [HomeController::class, 'index'])->name('user.index');

// Formulir Pendaftaran
// Route::get('/user/form_daftar', [HomeController::class, 'form_daftar'])->name('user.form_daftar');
// Route::post('/user/form_daftar/simpan', [HomeController::class, 'form_simpan'])->name('user.form_simpan');

// Cek Status
// Route::get('/user/cek_status', [HomeController::class, 'cek_status'])->name('user.cek_status');

// Upload Surat
// Route::get('user/upload_surat/{id}', [HomeController::class, 'form_upload_surat'])->name('user.upload_surat');
// Route::post('user/upload_surat/{id}', [HomeController::class, 'upload_surat'])->name('user.upload_surat.simpan');
