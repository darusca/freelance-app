<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();

        if (request()->wantsJson()) {
            return $projects;
        }

        return view('projects.index', [
            'projects' => $projects
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*request()->validate([
            'client_id' => 'required',
            'name' => 'required|max:255',
            'description' => 'max:255'
        ]);*/

        $project = Project::create([
            'client_id' => $request->clientId,
            'name' => $request['name'],
            'description' => $request['description']
        ]);

        return response()->json(['data' => $project]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proj = Project::findOrFail($id);

        if (request()->wantsJson()) {
            return $proj;
        }

        return view('projects.edit', ['proj' => $proj]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proj = Project::findOrFail($id);

        return view('projects.edit', ['proj' => $proj]);

        //return $proj;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $proj = Project::findOrFail($id);
        $proj->update($request->all());

        return response('Ok', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proj = Project::findOrFail($id);
        $proj->delete();

        return response()->json(['data' => $proj]);
    }
}
