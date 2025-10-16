<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::orderByDesc('created_at')->with('files')->paginate(15);

        return view('pages.application.index', compact('applications'));
    }
    public function apply(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'project_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'budget' => 'required|numeric',
            'budget_type' => 'required|string',
            'deadline' => 'required|date',
            'files' => 'nullable|array|max:5',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $application = Application::create($request->all());

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $application->files()->create([
                    'file' => $file->store('applications', 'public'),
                    'type' => $file->getClientOriginalExtension(),
                ]);
            }
        }

        return response()->json([
            'message' => 'Application sent successfully',
            'application' => $application,
        ]);
    }

    public function destroy(Application $application)
    {
        $application->delete();

        // delete application files
        foreach ($application->files as $file) {
            $file->delete();
        }

        return redirect()->back()->with('success', 'Application deleted successfully');
    }
}
