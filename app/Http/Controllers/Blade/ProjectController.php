<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::paginate(8);
        return view('pages.project.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'nullable|url',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $project = new Project();
        $project->title = $request->title;
        $project->link = $request->link;
        $project->image = $request->file('image')->store('projects', 'public');
        $project->save();

        return redirect()->route('project')->with('success', 'Проект успешно добавлен');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('project')->with('success', 'Проект успешно удален');
    }
}
