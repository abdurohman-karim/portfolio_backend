<?php

use App\Models\Project;
use App\Models\Question;

Route::get('/about', fn() => [
    'stats' => [
        ['id'=>1,'value'=>'20+','label'=>'Projects'],
        ['id'=>2,'value'=>'100+','label'=>'Clients']
    ],
    'infos' => [
        ['id'=>1,'title'=>'Why do you never see elephants hiding in trees?', 'text'=>'Because they\'re so good at it...']
    ]
]);

Route::get('/skills', fn() => \App\Models\Skill::all());
Route::get('/projects', fn() => Project::paginate(6));
Route::get('/questions', fn() => Question::all());
