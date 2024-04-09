<?php

use App\Http\Controllers\PeopleController;
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
Route::get('/people', [PeopleController::class, 'index'])->name('people.index');
Route::get('/people/create', [PeopleController::class, 'create'])->name('people.create');
Route::post('/people', [PeopleController::class, 'store'])->name('people.store')->middleware([HandlePrecognitiveRequests::class]);
Route::get('/people/{id}', [PeopleController::class, 'show'])->name('people.show');
Route::put('/people/{id}', [PeopleController::class, 'update'])->name('people.update')->middleware([HandlePrecognitiveRequests::class]);
Route::delete('people/{id}', [PeopleController::class, 'destroy'])->name('photos.destroy')->middleware([HandlePrecognitiveRequests::class]);