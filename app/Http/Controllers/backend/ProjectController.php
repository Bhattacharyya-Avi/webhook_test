<?php

namespace App\Http\Controllers\backend;

use App\Models\Package;
use Illuminate\Support\Str;
use App\Models\ChildProject;
use Illuminate\Http\Request;
use App\Jobs\UpdateChildConfigJob;
use App\Http\Controllers\Controller;
use Devrabiul\ToastMagic\Facades\ToastMagic;


class ProjectController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        $projects = ChildProject::with('package')->get();
        return view('project.index',compact('projects','packages'));
    }

    public function generateToken()
    {
        $token = Str::random(64);
        return response()->json(['token' => $token]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'projectName' => 'required',
                'projectUrl' => 'required|url',
                'webhookToken' => 'required',
                'package_id' => 'required',
            ]);

            ChildProject::create([
                'name' => $request->projectName,
                'project_url' => $request->projectUrl,
                'webhook_token' => $request->webhookToken,
                'package_id' => $request->package_id,
            ]);

            ToastMagic::success("Success!", "Project created!");
            return redirect()->back();
        } catch (\Throwable $th) {
            ToastMagic::error("Error!", $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $projectId)
    {
        try {
            $request->validate([
                'projectName' => 'required',
                'projectUrl' => 'required|url',
                'webhookToken' => 'required',
                'package_id' => 'required',
            ]);

            ChildProject::where('id', $projectId)->update([
                'name' => $request->projectName,
                'project_url' => $request->projectUrl,
                'webhook_token' => $request->webhookToken,
                'package_id' => $request->package_id,
            ]);

            ToastMagic::success("Success!", "Project updated!");
            return redirect()->back();
        } catch (\Throwable $th) {
            ToastMagic::error("Error!", $th->getMessage());
            return redirect()->back();
        }
    }

    public function delete($projectId)
    {
        try {
            ChildProject::where('id', $projectId)->delete();
            ToastMagic::success("Success!", "Project deleted!");
            return redirect()->back();
        } catch (\Throwable $th) {
            ToastMagic::error("Error!", $th->getMessage());
            return redirect()->back();
        }
    }

    public function syncConfig($projectId)
    {
        $project = ChildProject::with('package')->findOrFail($projectId); 
        if (empty($project)) {
            ToastMagic::error("Error!", "Project not found!");
            return redirect()->back();
        }
        // $project->update(['package_id' => 1]);

        // Dispatch queue job to update child via webhook
        UpdateChildConfigJob::dispatch($project);

        ToastMagic::success("Success!", "Project config dispatched!");
        return redirect()->back();
        // return response()->json(['message' => 'Package updated and update dispatched.']);
    }
}
