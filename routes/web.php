<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return redirect()->route('tickets.index');
});

Route::get('/tickets', [TicketController::class, 'index'])
    ->name('tickets.index');

Route::get('/tickets/create', [TicketController::class, 'create'])
    ->name('tickets.create');

Route::post('/tickets', [TicketController::class, 'store'])
    ->name('tickets.store');

Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])
    ->name('tickets.edit');

Route::match(['put', 'patch'], '/tickets/{ticket}', [TicketController::class, 'update'])
    ->name('tickets.update');

Route::patch('/tickets/{ticket}/status', [TicketController::class, 'toggleStatus'])
    ->name('tickets.status');

Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])
    ->name('tickets.destroy');
Route::get('/tickets/create', [TicketController::class, 'index'])->name('ticket.create');

Route::post('/tickets', [TicketController::class, 'store'])->name('ticket.store');

Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('ticket.edit');

Route::patch('/tickets/{ticket}', [TicketController::class, 'update'])->name('ticket.update');

Route::patch('/tickets/{ticket}/status', [TicketController::class, 'status'])->name('tickets.status');

Route::delete('/tickets/{ticket}', [TicketController::class, 'delete'])->name('tickets.destroy');

    
