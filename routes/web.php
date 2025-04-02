<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MembriController;
use App\Http\Controllers\AntrenoriController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\AbonamentController;
use App\Http\Controllers\EchipamenteController;
use App\Http\Controllers\SaliController;
use App\Http\Controllers\StatisticiController;

// Rute publice
Route::get('/', function () {
    return view('welcome');
});

// Autentificare și Înregistrare
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/register/trainer', [AuthController::class, 'showTrainerRegisterForm'])->name('antrenor.register');
Route::post('/register/trainer', [AuthController::class, 'registerTrainer'])->name('antrenor.register.submit');

// Rute protejate
Route::middleware(['auth'])->group(function () {
    // Dashboard principal
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    
    // Rute pentru membri
    Route::prefix('membri')->group(function () {
        Route::post('/clase/{id}/feedback', [MembriController::class, 'adaugaFeedback'])->name('membri.feedback');
    });

    // Rute pentru abonamente
    Route::prefix('abonamente')->group(function () {
        Route::get('/', [AbonamentController::class, 'index'])->name('abonamente.index');
        Route::post('/cumpara', [AbonamentController::class, 'cumpara'])->name('abonamente.cumpara');
        Route::delete('/abonamente/{id}', [AbonamentController::class, 'anulare'])->name('abonamente.anulare');
    });

    // Rute pentru clase
    Route::prefix('clase')->group(function () {
        Route::get('/', [ClaseController::class, 'index'])->name('clase.index');
        Route::post('/inscriere/{id}', [ClaseController::class, 'inscriere'])->name('clase.inscriere');
        Route::delete('/anulare/{id}', [ClaseController::class, 'anulareInscriere'])->name('clase.anulare');
    });

    // Rute pentru antrenori
    Route::middleware(['antrenor'])->prefix('antrenor')->group(function () {
        Route::get('/dashboard', [AntrenoriController::class, 'dashboard'])->name('antrenor.dashboard');
        Route::get('/clase', [ClaseController::class, 'claseleAntrenorului'])->name('clase.antrenor');
        Route::get('/clase/create', [ClaseController::class, 'create'])->name('clase.create');
        Route::post('/clase', [ClaseController::class, 'store'])->name('clase.store');
        Route::put('/clase/{id}', [ClaseController::class, 'update'])->name('clase.update');
        Route::delete('/clase/{id}', [ClaseController::class, 'destroy'])->name('clase.destroy');
        Route::get('/membri', [AntrenoriController::class, 'membriAntrenati'])->name('antrenor.membri');
    });

    // Rute pentru admin
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::delete('/membri/{id}', [AdminController::class, 'deleteMembru'])->name('admin.membri.delete');
        Route::delete('/antrenori/{id}', [AdminController::class, 'deleteAntrenor'])->name('admin.antrenori.delete');
        
        // Rute pentru săli și echipamente
        Route::resource('sali', SaliController::class);
        Route::resource('echipamente', EchipamenteController::class);
        
        // Rute pentru rapoarte

        // Rute pentru rapoarte
        // Rute pentru rapoarte
        // Rute pentru rapoarte
        Route::prefix('rapoarte')->group(function () {
            Route::post('/clase-populate/update', [StatisticiController::class, 'updateClasePopulate'])->name('clase-populate.update');
            Route::post('/echipamente-sali/update', [StatisticiController::class, 'updateEchipamentePeSali'])->name('echipamente-sali.update');
            Route::post('/membri-antrenori/update', [StatisticiController::class, 'updateMembriCuAntrenori'])->name('membri-antrenori.update');
            Route::post('/abonamente-active/update', [StatisticiController::class, 'updateAbonamenteActive'])->name('abonamente-active.update');
            Route::post('/statistici-antrenori/update', [StatisticiController::class, 'updateStatisticiAntrenori'])->name('statistici-antrenori.update');
            Route::post('/top-membri/update', [StatisticiController::class, 'updateTopMembri'])->name('top-membri.update');
            Route::post('/sali-utilizare/update', [StatisticiController::class, 'updateSaliUtilizare'])->name('sali-utilizare.update');
            Route::post('/statistici-abonamente/update', [StatisticiController::class, 'updateStatisticiAbonamente'])->name('statistici-abonamente.update');

            Route::get('/clase-populate', [StatisticiController::class, 'getClasePopulate'])->name('admin.rapoarte.clase');
            Route::get('/echipamente', [StatisticiController::class, 'getEchipamentePeSali'])->name('admin.rapoarte.echipamente');
            Route::get('/membri', [StatisticiController::class, 'getMembriCuAntrenori'])->name('admin.rapoarte.membri');
            Route::get('/abonamente', [StatisticiController::class, 'getAbonamenteActive'])->name('admin.rapoarte.abonamente');
            Route::get('/statistici-antrenori', [StatisticiController::class, 'getStatisticiAntrenori'])->name('admin.rapoarte.antrenori');
            Route::get('/top-membri', [StatisticiController::class, 'getTopMembri'])->name('admin.rapoarte.top-membri');
            Route::get('/sali', [StatisticiController::class, 'getSaliUtilizare'])->name('admin.rapoarte.sali');
            Route::get('/statistici-abonamente', [StatisticiController::class, 'getStatisticiAbonamente'])->name('admin.rapoarte.statistici-abonamente');
            Route::get('/venituri-antrenori', [StatisticiController::class, 'getVenituriPeAntrenor'])->name('admin.rapoarte.venituri-antrenori');
            Route::get('/participare-membri-clase', [StatisticiController::class, 'getParticipareMembriClase'])->name('admin.rapoarte.participare-membri-clase');
        });
    });
});