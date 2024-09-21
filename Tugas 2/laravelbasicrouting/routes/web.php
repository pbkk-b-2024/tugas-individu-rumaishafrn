<?php

use App\Http\Controllers\BilanganController;
use Illuminate\Support\Facades\Route;

// halaman awal
Route::get('/', function () {
    return view('home');
})->name('home');

// Route Basic
Route::get('/route/basic', function () {
    return response()->view('app.layout', [
        'content' => '<h1>Ini adalah basic routing</h1>'
    ]);
})->name('routing.basic');

// Route Parameter
Route::get('/route/parameter/{id}', function ($id) {
    return response()->view('app.layout', [
        'content' => '<h1>Parameter yang dimasukkan adalah ' . $id . '</h1>'
    ]);
})->name('routing.parameter');

// Named Route
Route::get('/route/named', function () {
    return response()->view('app.layout', [
        'content' => '<h1>{{ route("routing.named") }}</h1>'
    ]);
})->name('routing.named');

// Route Prefix
Route::prefix('route-prefix')->group(function () {
    // Pemilihan Prefix
    Route::get('/', function () {
        return response()->view('app.layout', [
            'content' => '<a href="' . route('routing.prefix.1') . '" class="btn btn-primary">Route Prefix 1</a> <a href="' . route('routing.prefix.2') . '" class="btn btn-secondary">Route Prefix 2</a>'
        ]);
    })->name('routing.prefix');

    // Prefix 1
    Route::get('/route-1', function () {
        return response()->view('app.layout', [
            'content' => '<h1>Ini adalah route prefix 1</h1>'
        ]);
    })->name('routing.prefix.1');

    // Prefix 2
    Route::get('/route-2', function () {
        return response()->view('app.layout', [
            'content' => '<h1>Ini adalah route prefix 2</h1>'
        ]);
    })->name('routing.prefix.2');
});

// Jika route tidak ditemukan
Route::fallback(function () {
    return view('404');
});

Route::prefix('pertemuan1')->group(function () {
    Route::get('/ganjilgenap', [BilanganController::class, 'ganjilgenap'])->name('pertemuan1.ganjilgenap');
    Route::post('/ganjilgenap', [BilanganController::class, 'ganjilgenap'])->name('pertemuan1.ganjilgenap.cari');

    Route::get('/fibonacci', [BilanganController::class, 'fibonacci'])->name('pertemuan1.fibonacci');
    Route::post('/fibonacci', [BilanganController::class, 'fibonacci'])->name('pertemuan1.fibonacci.cari');

    Route::get('/prima', [BilanganController::class, 'prima'])->name('pertemuan1.prima');
    Route::post('/prima', [BilanganController::class, 'prima'])->name('pertemuan1.prima.cari');
});
