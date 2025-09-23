<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Models\Statistic;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);

        Statistic::create($data);

        return redirect()->route('about')->with('success', 'Статистика добавлена');
    }

    public function destroy(Statistic $statistic)
    {
        $statistic->delete();

        return redirect()->route('about')->with('success', 'Статистика удалена');
    }
}
