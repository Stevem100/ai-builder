<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DeploymentController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/login', [DashboardController::class, 'showLogin'])->name('login');
Route::post('/login', [DashboardController::class, 'login']);
Route::get('/register', [DashboardController::class, 'showRegister'])->name('register');
Route::post('/register', [DashboardController::class, 'register']);
Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');

// Authenticated app routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('projects', ProjectController::class);
    Route::get('/projects/{project}/editor', [ProjectController::class, 'editor'])->name('projects.editor');
    Route::get('/projects/{project}/terminal', [ProjectController::class, 'terminal'])->name('projects.terminal');
    Route::get('/projects/{project}/preview', [ProjectController::class, 'preview'])->name('projects.preview');

    Route::get('/deployments', [DeploymentController::class, 'index'])->name('deployments.index');
    Route::post('/projects/{project}/deploy', [DeploymentController::class, 'deploy'])->name('deployments.deploy');

    Route::get('/domains', [DomainController::class, 'index'])->name('domains.index');
    Route::post('/domains', [DomainController::class, 'store'])->name('domains.store');
    Route::delete('/domains/{domain}', [DomainController::class, 'destroy'])->name('domains.destroy');

    Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
    Route::get('/billing/plans', [BillingController::class, 'plans'])->name('billing.plans');
    Route::post('/billing/subscribe', [BillingController::class, 'subscribe'])->name('billing.subscribe');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});

// API (some public, some auth)
Route::post('/api/ai/chat', [AIController::class, 'chat'])->name('api.ai.chat');
Route::get('/api/system/health', [SystemController::class, 'health']);
Route::get('/api/system/metrics', [SystemController::class, 'metrics']);

Route::middleware(['auth'])->group(function () {
    Route::get('/api/projects', [ProjectController::class, 'apiIndex']);
    Route::post('/api/projects', [ProjectController::class, 'apiStore']);
    Route::get('/api/projects/{project}', [ProjectController::class, 'apiShow']);
    Route::delete('/api/projects/{project}', [ProjectController::class, 'apiDestroy']);
    Route::get('/api/deployments', [DeploymentController::class, 'apiIndex']);
    Route::get('/api/notifications', [NotificationController::class, 'apiIndex']);
    Route::post('/api/notifications/{notification}/read', [NotificationController::class, 'markRead']);
    Route::get('/api/billing/usage', [BillingController::class, 'apiUsage']);
});