<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

Route::get('/tickets/create', [TicketController::class, 'index'])->name('ticket.create');

Route::post('/tickets', [TicketController::class, 'store'])->name('ticket.store');

Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('ticket.edit');

Route::patch('/tickets/{ticket}', [TicketController::class, 'update'])->name('ticket.update');

Route::patch('/tickets/{ticket}/status', [TicketController::class, 'status'])->name('tickets.status');

Route::delete('/tickets/{ticket}', [TicketController::class, 'delete'])->name('tickets.destroy');

    