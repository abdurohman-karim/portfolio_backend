<?php

use App\Models\Project;
use App\Models\Question;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/about', function () {
    return [
        'stats' => [
            ['id' => 1, 'value' => '20+', 'label' => 'Projects'],
            ['id' => 2, 'value' => '100+', 'label' => 'Clients'],
            ['id' => 3, 'value' => '50+', 'label' => 'Skills'],
            ['id' => 4, 'value' => '100+', 'label' => 'Questions'],
        ],
        'infos' => [
            ['id' => 1, 'title' => 'Why do you never see elephants hiding in trees?', 'text' => "Because they're so good at it..."],
            ['id' => 2, 'title' => 'Why do you never see elephants hiding in trees?', 'text' => "Because they're so good at it..."],
        ],
    ];
});

Route::get('/skills', fn () => Skill::all());
Route::get('/projects', fn () => Project::paginate(6));
Route::get('/questions', fn () => Question::all());
