<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Stat;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        // TASK: Currently this statement fails. Fix the underlying issue.
        Project::create([
            'name' => $request->name
        ]);

        return redirect('/')->with('success', 'Project created');
    }

    public function mass_update(Request $request)
    {
        // TASK: Transform this SQL query into Eloquent
        // update projects
        //   set name = $request->new_name
        //   where name = $request->old_name

        // Insert Eloquent statement below

        $projects = Project::where('name', $request->old_name)
        ->update(['name' => $request->new_name]);

        if ($projects == 0) {
            return redirect('/')->with('error', 'Project not found');
        }
        return redirect('/')->with('success', 'Projects updated');
    }

    public function destroy($projectId)
    {
        Project::withTrashed()->destroy($projectId);

        // TASK: change this Eloquent statement to include the soft-deletes records
        $projects = Project::all();

        return view('projects.index', compact('projects'));
    }

    public function store_with_stats(Request $request)
    {
        // TASK: on creating a new project, create an Observer event to run SQL
        //   update stats set projects_count = projects_count + 1
        $project = new Project();
        $project->name = $request->name;
        $project->save();

        return redirect('/')->with('success', 'Project created');
    }

}
