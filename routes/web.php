<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return redirect('/login');
    });


    
    Route::get('/dashboard', function () {
        return view('dashboard');
        
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


        Route::get('/dashboard', [PdfController::class, 'index'])->name('dashboard');
        Route::post('/pdf/upload', [PdfController::class, 'uploadPDF'])->name('pdf.upload');
        Route::get('/pdfs/{filename}', [PdfController::class, 'show'])->name(name: 'pdfs.show');
        Route::get('/pdfs/download/{filename}', [PdfController::class, 'download'])->name('pdfs.download');

    });
});

// Requerendo rotas de autenticação adicionais
require __DIR__ . '/auth.php';
