<?php

use App\Http\Controllers\Blade\AboutController;
use App\Http\Controllers\Blade\InformationController;
use App\Http\Controllers\Blade\ProfileController;
use App\Http\Controllers\Blade\SkillController;
use App\Http\Controllers\Blade\StatisticController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/about', [AboutController::class, 'index'])->name('about');
    // crud
    Route::post('/statistics', [StatisticController::class, 'store'])->name('statistics.store');
    Route::delete('/statistics/{statistic}', [StatisticController::class, 'destroy'])->name('statistics.destroy');

    Route::resource('informations', InformationController::class)->except(['show']);

    Route::get('/skills', [SkillController::class, 'index'])->name('skill');
    Route::post('/skills', [SkillController::class, 'store'])->name('skill.store');
    Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])->name('skill.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
