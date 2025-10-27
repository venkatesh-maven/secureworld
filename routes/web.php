<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\SpareController;
use App\Http\Controllers\SystemLogController;
use App\Http\Controllers\ProcurementController;
 use App\Exports\TicketsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\CategoryMappingController;
// Default redirect
Route::get('/', fn() => redirect()->route('login.page'));

// Auth routes
Route::get('/login', [AuthController::class, 'loginpage'])->name('login.page');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard (protected)
Route::get('/dashboard', [AuthController::class, 'dashboard'])
    ->name('dashboard')
    ->middleware('auth');

// Users routes (only logged-in users, role checked in controller)
Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('auth');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

// Tickets routes (role checked in controller)


Route::middleware(['auth'])->group(function () {
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{id}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    
Route::get('tickets/serviceTickets', [TicketController::class, 'serviceTickets'])->name('tickets.serviceTickets');

    
Route::get('tickets/serviceTicketsimport', [TicketController::class, 'serviceTicketsimport'])->name('tickets.serviceTicketsimport');

    Route::post('tickets/importServiceMonitor',[TicketController::class,'importServiceMonitor'])->name('tickets.importServiceMonitor');
    Route::post('tickets/importServiceOrder',[TicketController::class,'importServiceOrder'])->name('tickets.importServiceOrder');
    
  Route::delete('/servicetickets/{id}/delete', [TicketController::class, 'serviceticketsdestroy'])
    ->name('servicetickets.destroy');

Route::get('/tickets/export', [App\Http\Controllers\TicketController::class, 'export'])->name('tickets.export');


Route::get('/servicetickets/{ticket}/edit', [TicketController::class, 'serviceedit'])->name('tickets.serviceedit');
Route::put('/servicetickets/{ticket}', [TicketController::class, 'serviceupdate'])->name('tickets.serviceupdate');


});





Route::middleware(['auth'])->group(function () {
    Route::get('/logs', [SystemLogController::class, 'index'])->name('logs.index');
});




Route::prefix('admin/category-mapping')->group(function () {
    Route::get('/', [CategoryMappingController::class, 'index'])->name('category-mapping.index');
    Route::get('/create', [CategoryMappingController::class, 'create'])->name('category-mapping.create');
    Route::post('/store', [CategoryMappingController::class, 'store'])->name('category-mapping.store');
    Route::get('/{id}/edit', [CategoryMappingController::class, 'edit'])->name('category-mapping.edit');
    Route::put('/{id}', [CategoryMappingController::class, 'update'])->name('category-mapping.update');
    Route::delete('/{id}', [CategoryMappingController::class, 'destroy'])->name('category-mapping.destroy');
});




Route::middleware(['auth'])->group(function() {
    Route::get('/spares', [SpareController::class, 'index'])->name('spares.index');
    Route::get('/spares/create', [SpareController::class, 'create'])->name('spares.create');
    Route::post('/spares', [SpareController::class, 'store'])->name('spares.store');
    Route::get('/spares/{id}', [SpareController::class, 'show'])->name('spares.show');
    Route::get('/spares/{id}/edit', [SpareController::class, 'edit'])->name('spares.edit');
    Route::put('/spares/{id}', [SpareController::class, 'update'])->name('spares.update');
    Route::delete('/spares/{id}', [SpareController::class, 'destroy'])->name('spares.destroy');
});



Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('password.update');

Route::middleware(['auth'])->group(function () {
    Route::resource('service-statuses', App\Http\Controllers\ServiceStatusController::class);
});


Route::resource('procurements', ProcurementController::class)->middleware('auth');