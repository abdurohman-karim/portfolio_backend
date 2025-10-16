<?php

use App\Http\Controllers\Blade\AboutController;
use App\Http\Controllers\Blade\InformationController;
use App\Http\Controllers\Blade\ProfileController;
use App\Http\Controllers\Blade\ProjectController;
use App\Http\Controllers\Blade\SkillController;
use App\Http\Controllers\Blade\StatisticController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('app')->group(function () {
    Route::get('/{any?}', function () {
        return view('welcome');
    })->where('any', '.*');
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

    // Projects
    Route::get('/projects', [ProjectController::class, 'index'])->name('project');
    Route::post('/projects', [ProjectController::class, 'store'])->name('project.store');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('project.destroy');

    Route::get('/applications', [\App\Http\Controllers\Api\ApplicationController::class, 'index'])->name('applications.index');
    Route::delete('/applications/delete/{application}', [\App\Http\Controllers\Api\ApplicationController::class, 'destroy'])->name('applications.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
