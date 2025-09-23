<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Models\Statistic;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $information = Information::all();
        $statistics = Statistic::all();

        return view('pages.about.index', compact('information', 'statistics'));
    }
}
