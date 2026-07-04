<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Deployment;
use App\Models\Notification;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeploymentController extends Controller
{
    public function index(Request $request)
    {
        $deployments = Deployment::with('project')->latest()->get();
        $unreadCount = Notification::where('user_id', Auth::id())->where('read', false)->count();

        return view('deployments.index', compact('deployments', 'unreadCount'));
    }

    public function deploy(Request $request, Project $project)
    {
        $latestVersion = Deployment::where('project_id', $project->id)->count();
        $version = 'v' . (1 + $latestVersion) . '.0.0';

        $deployment = Deployment::create([
            'project_id' => $project->id,
            'status' => 'pending',
            'version' => $version,
            'log' => "[{$version}] Starting deployment...\nInstalling dependencies...\nRunning build...\nOptimizing assets...\nDeploying to production...",
            'started_at' => now(),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'project_id' => $project->id,
            'action' => 'deployment_started',
            'description' => "Deployment {$version} started for {$project->name}",
        ]);

        Notification::create([
            'user_id' => Auth::id(),
            'title' => 'Deployment Started',
            'message' => "Deployment {$version} for \"{$project->name}\" is in progress.",
            'type' => 'info',
        ]);

        // Simulate deployment completing after a moment (update status in DB)
        $deployment->update([
            'status' => 'live',
            'completed_at' => now()->addMinutes(2),
            'duration' => 120,
            'log' => "[{$version}] Starting deployment...\n[{$version}] Installing dependencies... ✓\n[{$version}] Running build... ✓\n[{$version}] Optimizing assets... ✓\n[{$version}] Deploying to production... ✓\n[{$version}] Deployment complete! Live at {$project->name}.aibuilder.dev",
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'project_id' => $project->id,
            'action' => 'deployment_completed',
            'description' => "Deployment {$version} completed successfully for {$project->name}",
        ]);

        Notification::create([
            'user_id' => Auth::id(),
            'title' => 'Deployment Live',
            'message' => "\"{$project->name}\" version {$version} is now live!",
            'type' => 'success',
        ]);

        return back()->with('success', "Deployment {$version} completed successfully!");
    }

    public function apiIndex()
    {
        return response()->json(Deployment::with('project')->latest()->get());
    }
}