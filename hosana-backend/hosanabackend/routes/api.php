<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\UnitPendidikanController;
use App\Http\Controllers\GuruStaffController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\TanggapanController;


Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('auth:sanctum')->get('/user-profile', [AuthController::class, 'getUserProfile']);
    Route::middleware('auth:sanctum')->put('/user-profile', [AuthController::class, 'updateUserProfile']);

});

Route::prefix('v1')->group(function () {

    Route::get('/banner', [BannerController::class, 'index']);
    Route::post('/banner', [BannerController::class, 'store']);
    Route::get('/banner/{id}', [BannerController::class, 'show']);
    Route::put('/banner/{id}', [BannerController::class, 'update']);
    Route::delete('/banner/{id}', [BannerController::class, 'destroy']);


    Route::get('/statistic', [StatisticController::class, 'index']);
    Route::post('/statistic', [StatisticController::class, 'store']);
    Route::get('/statistic/{id}', [StatisticController::class, 'show']);
    Route::put('/statistic/{id}', [StatisticController::class, 'update']);

    Route::get('/berita/pdf', [BeritaController::class, 'downloadPDF']);

    Route::get('/berita/all', [BeritaController::class, 'all']);
    Route::get('/berita', [BeritaController::class, 'index']);
    Route::get('/berita/{id}', [BeritaController::class, 'show']);
    Route::post('/berita', [BeritaController::class, 'store']);
    Route::put('/berita/{id}', [BeritaController::class, 'update']);
    Route::delete('/berita/{id}', [BeritaController::class, 'destroy']);
    Route::post('/berita/{id}/restore', [BeritaController::class, 'restore']);


    Route::get('/kategori', [KategoriController::class, 'index']);
    Route::get('/kategori/{id}', [KategoriController::class, 'show']);
    Route::post('/kategori', [KategoriController::class, 'store']);
    Route::put('/kategori/{id}', [KategoriController::class, 'update']);
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']);
    // Route::post('/kategori/{id}/restore', [KategoriController::class, 'restore']);


    Route::get('/users', [AuthController::class, 'index']);
    Route::get('/users/{id}', [AuthController::class, 'show']);

    Route::get('/alumni', [AlumniController::class, 'index']);
    Route::post('/alumni', [AlumniController::class, 'store']);
    Route::put('/alumni/{id}', [AlumniController::class, 'update']);
    Route::delete('/alumni/{id}', [AlumniController::class, 'destroy']);
    Route::get('/alumni/{id}', [AlumniController::class, 'show']);
    

    Route::get('/unit', [UnitPendidikanController::class, 'index']);

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('gurustaff/all', [GuruStaffController::class, 'all']);
    Route::get('/gurustaff', [GuruStaffController::class, 'index']);
    Route::post('/gurustaff', [GuruStaffController::class, 'store']);
    Route::put('/gurustaff/{staffID}', [GuruStaffController::class, 'update']);
    Route::delete('/gurustaff/{staffID}', [GuruStaffController::class, 'destroy']);
    Route::get('/gurustaff/{staffID}', [GuruStaffController::class, 'show']);

    Route::get('fasilitas/all', [FasilitasController::class, 'all']);
    Route::get('/fasilitas', [FasilitasController::class, 'index']);
    Route::post('/fasilitas', [FasilitasController::class, 'store']);
    Route::put('/fasilitas/{id}', [FasilitasController::class, 'update']);
    Route::delete('/fasilitas/{id}', [FasilitasController::class, 'destroy']);
    Route::get('/fasilitas/{id}', [FasilitasController::class, 'show']);

    Route::get('kegiatan/all', [KegiatanController::class, 'all']);
    Route::get('/kegiatan', [KegiatanController::class, 'index']);
    Route::post('/kegiatan', [KegiatanController::class, 'store']);
    Route::put('/kegiatan/{id}', [KegiatanController::class, 'update']);
    Route::delete('/kegiatan/{id}', [KegiatanController::class, 'destroy']);
    Route::get('/kegiatan/{id}', [KegiatanController::class, 'show']);


    Route::get('/kontak', [KontakController::class, 'index']);
    Route::post('/kontak', [KontakController::class, 'store']);
    Route::get('/kontak/{id}', [KontakController::class, 'show']);
    Route::put('/kontak/{id}', [KontakController::class, 'update']);

    Route::get('komentar/{beritaId}', [KomentarController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('komentar', [KomentarController::class, 'store']);
        Route::delete('komentar/{id}', [KomentarController::class, 'destroy']);
    });

    Route::patch('komentar/{id}/approve', [KomentarController::class, 'approve'])
    ->middleware('auth:sanctum');



    Route::get('berita-dengan-komentar', [BeritaController::class, 'withKomentar']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/tanggapan', [TanggapanController::class, 'store']);
        Route::get('/tanggapan/{komentarId}', [TanggapanController::class, 'index']);
            Route::delete('/tanggapan/{id}', [TanggapanController::class, 'destroy']);

    });
    


});

