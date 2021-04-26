<?php

use Illuminate\Support\Facades\Route;


Route::get('/Agenda/Publico/{id}', function ($id) {
    return \App\Http\Controllers\PublicoController::agenda_publico($id);
});
Route::post('/Agenda/Publico/AvanzarFase2',[\App\Http\Controllers\PublicoController::class,'agenda_fase_2']);

Route::post('/Agenda/Publico/TomarHoraOnline', [\App\Http\Controllers\PublicoController::class, 'agendar_hora']);

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/Agenda/Ver', [App\Http\Controllers\AgendaController::class, 'ver']);

Route::get('/Agenda/Contactos', [App\Http\Controllers\AgendaController::class, 'contactos']);
Route::post('/Agenda/CrearContacto', [App\Http\Controllers\AgendaController::class, 'crear_contactos']);


Route::get('/Agenda/Crear', [App\Http\Controllers\AgendaController::class, 'crear']);
Route::post('/Agenda/CrearDisponibilidad', [App\Http\Controllers\AgendaController::class, 'crear_disponibilidad']);
Route::post('/Agenda/Deshabilitar', [App\Http\Controllers\AgendaController::class, 'deshabilitar']);
Route::post('/Agenda/Habilitar', [App\Http\Controllers\AgendaController::class, 'habilitar']);
Route::post('/Agenda/Cancelar', [App\Http\Controllers\AgendaController::class, 'cancelar']);

Route::get('/Agenda/Modificar', [App\Http\Controllers\AgendaController::class, 'modificar']);

Route::get('/Secretaria/CrearDisponibilidad', [App\Http\Controllers\SecretariaController::class, 'crear']);
