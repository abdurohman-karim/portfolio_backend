<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::all();
        return view('pages.skill.index', compact('skills'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|url|max:255',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        if ($request->hasFile('icon')) {
            $filename = time() . '.' . $request->icon->getClientOriginalExtension();
            $request->icon->storeAs('public/icons', $filename);
            $validated['icon'] = $filename;
        }

        Skill::create($validated);

        return redirect()->route('skill')->with('success', 'Навык успешно добавлен');
    }

    public function destroy(Request $request, $id)
    {
        $skill = Skill::findOrFail($id);
        $skill->delete();
        return redirect()->route('skill')->with('success', 'Навык успешно удален');
    }
}
