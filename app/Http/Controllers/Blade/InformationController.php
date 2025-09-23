<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
        ]);

        Information::create($data);

        return redirect()->route('about')->with('success', 'Информация добавлена');
    }

    public function edit(Information $information)
    {
        return view('pages.about.edit', compact('information'));
    }

    public function update(Request $request, Information $information)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'nullable|string',
        ]);

        $information->update($data);

        return redirect()->route('about')->with('success', 'Информация обновлена');
    }

    public function destroy(Information $information)
    {
        $information->delete();

        return redirect()->route('about')->with('success', 'Информация удалена');
    }
}
