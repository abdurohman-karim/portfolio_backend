<?php

use App\Http\Controllers\Api\ApplicationController;
use App\Models\Information;
use App\Models\Project;
use App\Models\Question;
use App\Models\Skill;
use App\Models\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/about', fn () => [
    'stats' => Statistic::all(),
    'infos' => Information::all(),
]);

Route::get('/skills', fn () => Skill::all());
Route::get('/projects', fn () => Project::paginate(6));
Route::get('/questions', fn () => Question::all());
Route::post('/applications', [ApplicationController::class, 'apply'])->name('applications.apply');
