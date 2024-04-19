<?php

use App\Http\Controllers\PeopleController;
use App\Http\Controllers\ProtocolsController;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/home', function () {
        return Inertia::render('Home');
    })->name('home');
});

//People
Route::get('/pessoas', [PeopleController::class, 'index'])->name('people.index');
Route::get('/pessoas/cadastro', [PeopleController::class, 'create'])->name('people.create');
Route::post('/pessoas', [PeopleController::class, 'store'])->name('people.store')->middleware([HandlePrecognitiveRequests::class]);
Route::get('/pessoas/pessoa-{id}', [PeopleController::class, 'edit'])->name('people.edit');
Route::put('/pessoas/pessoa-{id}', [PeopleController::class, 'update'])->name('people.update')->middleware([HandlePrecognitiveRequests::class]);
Route::delete('pessoas/pessoa-{id}', [PeopleController::class, 'destroy'])->name('people.destroy')->middleware([HandlePrecognitiveRequests::class]);

//Protocols
Route::get('/protocolos', [ProtocolsController::class, 'index'])->name('protocols.index');
Route::get('/protocolos/cadastro', [ProtocolsController::class, 'create'])->name('protocols.create');
Route::post('/protocolos', [ProtocolsController::class, 'store'])->name('protocols.store')->middleware([HandlePrecognitiveRequests::class]);
Route::get('/protocolos/protocolo-{id}', [ProtocolsController::class, 'edit'])->name('protocols.edit');
Route::put('/protocolos/protocolo-{id}', [ProtocolsController::class, 'update'])->name('protocols.update')->middleware([HandlePrecognitiveRequests::class]);
Route::delete('protocolos/protocolo-{id}', [ProtocolsController::class, 'destroy'])->name('protocols.destroy')->middleware([HandlePrecognitiveRequests::class]);
Route::delete('protocolos/arquivo-{id}', [ProtocolsController::class, 'destroyFile'])->name('protocols.destroyFile');
Route::get('/protocolos/download/arquivo-{id}', [ProtocolsController::class, 'downloadFile'])->name('protocols.downloadFile');