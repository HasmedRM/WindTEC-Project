<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\GdtController;
use App\Models\Guindaste;
use App\Models\Equipamento;
use App\Http\Controllers\EquipamentoController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

Route::middleware(['auth'])->group(function () {

    Route::get('dashboard', function () {
        $equipamentosCount = Equipamento::count();
        $windCount = Guindaste::count();
        return Inertia::render('dashboard', [
            'equipamentos_count' => $equipamentosCount,
            'wind_count' => $windCount,
        ]);
    })->name('dashboard');

    Route::get('WindConfig', function () {
        $guindastes = Guindaste::orderBy('id', 'desc')->get();
        return Inertia::render('WindConfig', [
            'guindastes' => $guindastes,
        ]);
    })->name('wind-config');

    Route::get('EquipamentoConfig', function () {
        $equipamentos = Equipamento::orderBy('id', 'desc')->get();
        return Inertia::render('EquipamentoConfig', [
            'equipamentos' => $equipamentos,
        ]);
    })->name('equipamento-config');

    // Equipamentos resource routes
    Route::middleware(['auth'])
        ->prefix('equipamentos')
        ->name('equipamentos.')
        ->controller(EquipamentoController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/criar', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{equipamento}/editar', 'edit')->name('edit');
            Route::put('/{equipamento}', 'update')->name('update');
            Route::delete('/{equipamento}', 'destroy')->name('destroy');
        });

    Route::get('ChatBot', function () {
        return Inertia::render('ChatBot');
    })->name('chat-bot');

    Route::get('/cadastro-guin', function () {
    return Inertia::render('CadastroGuin');
    })->name('cadastro.guin');
});

Route::middleware(['auth'])
    ->prefix('guindastes')
    ->name('guindastes.')
    ->controller(GdtController::class)
    ->group(function () {

        Route::get('/', 'index')->name('index');
        // rota adicional para compatibilidade com link antigo
        Route::get('/cadastro', function () {
            return Inertia::render('CadastroGuin');
        })->name('cadastro');
        Route::get('/criar', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{guindaste}/editar', 'edit')->name('edit');
        Route::put('/{guindaste}', 'update')->name('update');
        Route::delete('/{guindaste}', 'destroy')->name('destroy');

    });

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
