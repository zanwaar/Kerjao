<?php

use App\Http\Controllers\AiWritingAssistantController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BuktiAktivitasController;
use App\Http\Controllers\DailyScrumController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GithubActivityController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProgramKerjaController;
use App\Http\Controllers\TodoListController;
use App\Http\Controllers\WakatimeActivityController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('pegawai', PegawaiController::class);

    Route::resource('program-kerja', ProgramKerjaController::class);

    Route::resource('kegiatan', KegiatanController::class);

    Route::get('task/saya', [TodoListController::class, 'saya'])->name('task.saya');
    Route::resource('task', TodoListController::class);

    Route::resource('daily-scrum', DailyScrumController::class);
    Route::post('ai-writing-assist/improve', [AiWritingAssistantController::class, 'improve'])->name('ai-writing-assist.improve');

    Route::resource('bukti-aktivitas', BuktiAktivitasController::class);

    Route::resource('github-activity', GithubActivityController::class);

    Route::resource('wakatime-activity', WakatimeActivityController::class);

    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/export', [LaporanController::class, 'export'])->name('laporan.export');

    Route::view('panduan', 'panduan')->name('panduan');
});
