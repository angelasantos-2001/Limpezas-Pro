<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\ProfileController;

// Rota principal do site
Route::get('/', function () {
    return view('welcome'); // Landing page
});

// Rota para processar o formulário (apenas utilizadores logados)
Route::post('/reservar', [BookingController::class, 'store'])
    ->middleware(['auth'])
    ->name('bookings.store');

Route::get('/agendamento', function () {
   return view('agendamento'); // Nova página com login e calendário
})->name('bookings.create');

// Exemplo de como a rota deve ficar:
Route::get('/agendamento', [BookingController::class, 'index'])->name('agendamento');
// O importante aqui é o -------------------------------------> ^^^^^^^^^^^^^^^^^^^
require __DIR__.'/auth.php';

Route::get('/admin/reservas', [BookingController::class, 'adminIndex'])->name('admin.reservas');
Route::delete('/agendamento/{id}', [BookingController::class, 'destroy'])->name('agendamento.destroy');

Route::get('/admin/reservas', [BookingController::class, 'gerir']);

Route::get('/test-email', function () {
    try {
        Mail::raw('Este é um teste de envio de email.', function ($message) {
            $message->to('limpezas@limpezas-500314.iam.gserviceaccount.com') 
                    ->subject('Teste de Email Laravel');
        });
        return "Email enviado com sucesso!";
    } catch (\Exception $e) {
        return "Erro ao enviar: " . $e->getMessage();
    }
});

Route::middleware(['auth', 'admin'])
    ->prefix('admin')   // Todas as URLs vão começar por /admin/...
    ->name('admin.')    // Os nomes das rotas vão começar por admin.
    ->group(function () {
        
        // Página principal do painel (Lista de marcações)
        Route::get('/reservas', [AdminBookingController::class, 'index'])->name('bookings.index');
        
        // Rota para apagar a marcação
        Route::delete('/reservas/{id}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');
        
});

// Rota para o painel do administrador
Route::get('/admin/calendario', [BookingController::class, 'adminIndex'])
    ->middleware(['auth', 'admin']) // Garante que está logado e é admin
    ->name('admin.calendario');

Route::get('/dashboard', function () {
    return redirect()->route('agendamento'); // Ou o nome correto da tua rota do calendário
})->middleware(['auth'])->name('dashboard');

// Altera para isto (Correção):
Route::get('/admin/calendario', [BookingController::class, 'adminCalendar'])->name('admin.calendario');

// Lista de Texto (Abre o teu ficheiro admin/reservas.blade.php)
Route::get('/admin/reservas', [AdminBookingController::class, 'index'])->name('admin.reservas');

// Edição (Abre o teu admin/bookings/edit.blade.php)

Route::put('/admin/bookings/{id}', [AdminBookingController::class, 'update'])->name('admin.bookings.update');

// Eliminação (Abre o teu admin/bookings/destroy.blade.php e depois executa)
Route::delete('/admin/bookings/{id}/delete', [BookingController::class, 'deleteConfirm'])->name('admin.bookings.delete_confirm');
// Esta rota tem de ser DELETE porque o teu formulário envia @method('DELETE')
Route::delete('/admin/bookings/{id}', [BookingController::class, 'destroy'])->name('admin.bookings.destroy');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // ... outras rotas ...
    Route::get('/reservas', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
});

Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::name('admin.')->prefix('admin')->group(function () {
    Route::resource('bookings', BookingController::class); 
    // This automatically creates 'admin.bookings.edit'
});

Route::get('/confirmar-reserva/{token}', [BookingController::class, 'confirm'])->name('booking.confirm');