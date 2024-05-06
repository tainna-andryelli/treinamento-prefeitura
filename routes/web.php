<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\AccompanimentController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\ProtocolsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        //'canRegister' => Route::has('register'),
    ]);
})->name('welcome');
 
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/home', function () {
        $userProfile = Auth::user()->profile;
        return Inertia::render('Home', [
            'userProfile' => $userProfile,
        ]);
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
Route::delete('/protocolos/arquivo-{id}', [ProtocolsController::class, 'destroyFile'])->name('protocols.destroyFile');
Route::post('/protocolos/protocolo-{id}/upload', [ProtocolsController::class, 'uploadFile'])->name('protocols.uploadFile')->middleware([HandlePrecognitiveRequests::class]);
Route::get('/protocolos/download/arquivo-{id}', [ProtocolsController::class, 'downloadFile'])->name('protocols.downloadFile');

//Users
Route::get('/usuarios', [UserController::class, 'index'])->name('user.index');
Route::get('/usuarios/registro', [UserController::class, 'create'])->name('user.create');
Route::post('/usuarios', [UserController::class, 'store'])->name('user.store')->middleware([HandlePrecognitiveRequests::class]);
Route::get('/usuarios/usuario-{id}', [UserController::class, 'edit'])->name('user.edit');
Route::put('/usuarios/usuario-{id}', [UserController::class, 'update'])->name('user.update')->middleware([HandlePrecognitiveRequests::class]);

//Departments
Route::get('/departamentos', [DepartmentsController::class, 'index'])->name('departments.index');
Route::get('/departamentos/cadastro', [DepartmentsController::class, 'create'])->name('departments.create');
Route::post('/departamentos', [DepartmentsController::class, 'store'])->name('departments.store')->middleware([HandlePrecognitiveRequests::class]);
Route::get('/departamentos/departamento-{id}', [DepartmentsController::class, 'edit'])->name('departments.edit');
Route::put('/departamentos/departamento-{id}', [DepartmentsController::class, 'update'])->name('departments.update')->middleware([HandlePrecognitiveRequests::class]);

//Access
Route::post('/departamentos/departamento-{id}', [AccessController::class, 'store'])->name('access.store')->middleware([HandlePrecognitiveRequests::class]);
Route::delete('/departamentos/departamento-{departmentId}/usuario-{userId}', [AccessController::class, 'destroy'])->name('access.destroy')->middleware([HandlePrecognitiveRequests::class]);

//Accompaniments
Route::post('/protocolos/protocolo-{number}/acompanhamento', [AccompanimentController::class, 'store'])->name('accompaniment.store')->middleware([HandlePrecognitiveRequests::class]);

//PDFs
Route::get('/pdf/protocolos', [PdfController::class, 'generateAllProtocolsPdf'])->name('pdf.protocols');
Route::get('/pdf/protocolos/{number}', [PdfController::class, 'generateSpecificProtocolPdf'])->name('pdf.protocol');

//Audits
Route::get('/auditoria', [AuditsController::class, 'index'])->name('audits.index');
Route::get('/auditoria/audit-{id}', [AuditsController::class, 'show'])->name('audits.show');
