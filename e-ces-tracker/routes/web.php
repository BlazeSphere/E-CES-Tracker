<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\ReportController;

use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\ProjectController;

Route::get('/', [AuthenticatedSessionController::class, 'create']);

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/account-locked', function () { 
    return view('errors.account-locked'); 
})->name('account.locked');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'role:0'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/school', [SettingsController::class, 'storeSchool'])->name('settings.school.store');
    Route::delete('/settings/school/{school}', [SettingsController::class, 'destroySchool'])->name('settings.school.destroy');
    Route::post('/settings/community', [SettingsController::class, 'storeCommunity'])->name('settings.community.store');
    Route::delete('/settings/community/{community}', [SettingsController::class, 'destroyCommunity'])->name('settings.community.destroy');

    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/excel', [ReportController::class, 'downloadExcel'])->name('reports.excel');
    Route::get('/reports/export/pdf', [ReportController::class, 'downloadPDF'])->name('reports.pdf');
});

Route::resource('surveys', SurveyController::class);

Route::middleware(['auth'])->group(function () {
    Route::post('projects/{id}/restore', [ProjectController::class, 'restore'])->name('projects.restore');
    Route::resource('projects', ProjectController::class);
});
