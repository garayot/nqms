<?php

use App\Http\Controllers\Admin\DrafManagementController;
use App\Http\Controllers\Admin\DocumentTypeController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\WhitelistController;
use App\Http\Controllers\Approver\DrafApprovalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DrafController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/links', [HomeController::class, 'links'])->name('links');
Route::get('/organization', [HomeController::class, 'organization'])->name('organization');
Route::get('/forms-templates', [DocumentController::class, 'publicIndex'])->name('forms.index');

Route::middleware('guest')->group(function () {
    Route::get('/login/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/login/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('login.google.callback');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [GoogleAuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('draf', DrafController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update']);
    Route::post('/draf/{draf}/submit', [DrafController::class, 'submit'])->name('draf.submit');

    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/drafs', [DrafManagementController::class, 'index'])->name('drafs.index');
    Route::get('/drafs/{draf}', [DrafManagementController::class, 'show'])->name('drafs.show');
    Route::post('/drafs/{draf}/review', [DrafManagementController::class, 'review'])->name('drafs.review');

    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/role', [UserManagementController::class, 'updateRole'])->name('users.role');

    Route::get('/whitelist', [WhitelistController::class, 'index'])->name('whitelist.index');
    Route::post('/whitelist', [WhitelistController::class, 'store'])->name('whitelist.store');
    Route::put('/whitelist/{whitelistedUser}', [WhitelistController::class, 'update'])->name('whitelist.update');

    Route::get('/document-types', [DocumentTypeController::class, 'index'])->name('document-types.index');
    Route::post('/document-types', [DocumentTypeController::class, 'store'])->name('document-types.store');
    Route::put('/document-types/{documentType}', [DocumentTypeController::class, 'update'])->name('document-types.update');
});

Route::middleware(['auth', 'role:approver'])->prefix('approver')->name('approver.')->group(function () {
    Route::get('/drafs', [DrafApprovalController::class, 'index'])->name('drafs.index');
    Route::post('/drafs/{draf}/approve', [DrafApprovalController::class, 'approve'])->name('drafs.approve');
});
