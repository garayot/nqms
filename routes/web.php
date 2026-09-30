<?php

use App\Http\Controllers\Admin\DocumentTypeController;
use App\Http\Controllers\Admin\DrafManagementController;
use App\Http\Controllers\Admin\FormTemplateController;
use App\Http\Controllers\Admin\FunctionalDivController;
use App\Http\Controllers\Admin\PlanningDocController;
use App\Http\Controllers\Admin\ProcessController;
use App\Http\Controllers\Admin\ProcessGroupController;
use App\Http\Controllers\Admin\SubProcessController;
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
Route::get('/operations-manual', [HomeController::class, 'operationsManual'])->name('operations-manual');
Route::get('/planning-docs', [HomeController::class, 'planningDocs'])->name('planning-docs');
Route::get('/forms-templates', [DocumentController::class, 'publicIndex'])->name('forms.index');

Route::middleware('guest')->group(function () {
    Route::get('/login/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/login/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('login.google.callback');

    // Google callback path used by the configured OAuth redirect URI.
    Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [GoogleAuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('draf', DrafController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update']);
    Route::get('/draf/{draf}/print', [DrafController::class, 'print'])->name('draf.print');
    Route::post('/draf/{draf}/submit', [DrafController::class, 'submit'])->name('draf.submit');

    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/drafs', [DrafManagementController::class, 'index'])->name('drafs.index');
    Route::get('/drafs/{draf}', [DrafManagementController::class, 'show'])->name('drafs.show');
    Route::get('/drafs/{draf}/print', [DrafManagementController::class, 'print'])->name('drafs.print');
    Route::post('/drafs/{draf}/review', [DrafManagementController::class, 'review'])->name('drafs.review');

    Route::get('/form-templates', [FormTemplateController::class, 'index'])->name('form-templates.index');
    Route::get('/form-templates/csv-template', [FormTemplateController::class, 'downloadCsvTemplate'])->name('form-templates.csv-template');
    Route::post('/form-templates', [FormTemplateController::class, 'store'])->name('form-templates.store');
    Route::post('/form-templates/import-csv', [FormTemplateController::class, 'importCsv'])->name('form-templates.import-csv');
    Route::post('/form-templates/import/{document}', [FormTemplateController::class, 'importFromDocument'])->name('form-templates.import');

    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/role', [UserManagementController::class, 'updateRole'])->name('users.role');

    Route::get('/whitelist', [WhitelistController::class, 'index'])->name('whitelist.index');
    Route::post('/whitelist', [WhitelistController::class, 'store'])->name('whitelist.store');
    Route::put('/whitelist/{whitelistedUser}', [WhitelistController::class, 'update'])->name('whitelist.update');

    Route::get('/document-types', [DocumentTypeController::class, 'index'])->name('document-types.index');
    Route::post('/document-types', [DocumentTypeController::class, 'store'])->name('document-types.store');
    Route::put('/document-types/{documentType}', [DocumentTypeController::class, 'update'])->name('document-types.update');

    Route::get('/planning-docs', [FunctionalDivController::class, 'index'])->name('planning-docs.index');
    Route::get('/planning-docs/functional-divisions/create', [FunctionalDivController::class, 'create'])->name('planning-docs.functional-divisions.create');
    Route::post('/planning-docs/functional-divisions', [FunctionalDivController::class, 'store'])->name('planning-docs.functional-divisions.store');
    Route::get('/planning-docs/functional-divisions/{functionalDiv}/edit', [FunctionalDivController::class, 'edit'])->name('planning-docs.functional-divisions.edit');
    Route::put('/planning-docs/functional-divisions/{functionalDiv}', [FunctionalDivController::class, 'update'])->name('planning-docs.functional-divisions.update');
    Route::delete('/planning-docs/functional-divisions/{functionalDiv}', [FunctionalDivController::class, 'destroy'])->name('planning-docs.functional-divisions.destroy');

    Route::get('/planning-docs/functional-divisions/{functionalDiv}/planning-docs/create', [PlanningDocController::class, 'create'])->name('planning-docs.documents.create');
    Route::post('/planning-docs/functional-divisions/{functionalDiv}/planning-docs', [PlanningDocController::class, 'store'])->name('planning-docs.documents.store');
    Route::get('/planning-docs/functional-divisions/{functionalDiv}/planning-docs/{planningDoc}/edit', [PlanningDocController::class, 'edit'])->name('planning-docs.documents.edit');
    Route::put('/planning-docs/functional-divisions/{functionalDiv}/planning-docs/{planningDoc}', [PlanningDocController::class, 'update'])->name('planning-docs.documents.update');
    Route::delete('/planning-docs/functional-divisions/{functionalDiv}/planning-docs/{planningDoc}', [PlanningDocController::class, 'destroy'])->name('planning-docs.documents.destroy');

    Route::get('/operations-manual', [ProcessGroupController::class, 'index'])->name('operations-manual.index');
    Route::get('/operations-manual/process-groups/create', [ProcessGroupController::class, 'create'])->name('operations-manual.process-groups.create');
    Route::post('/operations-manual/process-groups', [ProcessGroupController::class, 'store'])->name('operations-manual.process-groups.store');
    Route::get('/operations-manual/process-groups/{processGroup}/edit', [ProcessGroupController::class, 'edit'])->name('operations-manual.process-groups.edit');
    Route::put('/operations-manual/process-groups/{processGroup}', [ProcessGroupController::class, 'update'])->name('operations-manual.process-groups.update');
    Route::delete('/operations-manual/process-groups/{processGroup}', [ProcessGroupController::class, 'destroy'])->name('operations-manual.process-groups.destroy');

    Route::get('/operations-manual/process-groups/{processGroup}/processes', [ProcessController::class, 'index'])->name('operations-manual.processes.index');
    Route::get('/operations-manual/process-groups/{processGroup}/processes/create', [ProcessController::class, 'create'])->name('operations-manual.processes.create');
    Route::post('/operations-manual/process-groups/{processGroup}/processes', [ProcessController::class, 'store'])->name('operations-manual.processes.store');
    Route::get('/operations-manual/process-groups/{processGroup}/processes/{process}/edit', [ProcessController::class, 'edit'])->name('operations-manual.processes.edit');
    Route::put('/operations-manual/process-groups/{processGroup}/processes/{process}', [ProcessController::class, 'update'])->name('operations-manual.processes.update');
    Route::delete('/operations-manual/process-groups/{processGroup}/processes/{process}', [ProcessController::class, 'destroy'])->name('operations-manual.processes.destroy');

    Route::get('/operations-manual/process-groups/{processGroup}/processes/{process}/sub-processes', [SubProcessController::class, 'index'])->name('operations-manual.sub-processes.index');
    Route::get('/operations-manual/process-groups/{processGroup}/processes/{process}/sub-processes/create', [SubProcessController::class, 'create'])->name('operations-manual.sub-processes.create');
    Route::post('/operations-manual/process-groups/{processGroup}/processes/{process}/sub-processes', [SubProcessController::class, 'store'])->name('operations-manual.sub-processes.store');
    Route::get('/operations-manual/process-groups/{processGroup}/processes/{process}/sub-processes/{subProcess}/edit', [SubProcessController::class, 'edit'])->name('operations-manual.sub-processes.edit');
    Route::put('/operations-manual/process-groups/{processGroup}/processes/{process}/sub-processes/{subProcess}', [SubProcessController::class, 'update'])->name('operations-manual.sub-processes.update');
    Route::delete('/operations-manual/process-groups/{processGroup}/processes/{process}/sub-processes/{subProcess}', [SubProcessController::class, 'destroy'])->name('operations-manual.sub-processes.destroy');
});

Route::middleware(['auth', 'role:admin,reviewer'])->prefix('reviewer')->name('reviewer.')->group(function () {
    Route::get('/drafs', [DrafManagementController::class, 'index'])->name('drafs.index');
    Route::get('/drafs/{draf}', [DrafManagementController::class, 'show'])->name('drafs.show');
    Route::get('/drafs/{draf}/print', [DrafManagementController::class, 'print'])->name('drafs.print');
    Route::post('/drafs/{draf}/review', [DrafManagementController::class, 'review'])->name('drafs.review');
});

Route::middleware(['auth', 'role:admin,approver'])->prefix('approver')->name('approver.')->group(function () {
    Route::get('/drafs', [DrafApprovalController::class, 'index'])->name('drafs.index');
    Route::get('/drafs/{draf}', [DrafApprovalController::class, 'show'])->name('drafs.show');
    Route::get('/drafs/{draf}/print', [DrafApprovalController::class, 'print'])->name('drafs.print');
    Route::post('/drafs/{draf}/approve', [DrafApprovalController::class, 'approve'])->name('drafs.approve');
});
