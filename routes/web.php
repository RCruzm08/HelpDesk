<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

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