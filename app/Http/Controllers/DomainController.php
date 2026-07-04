<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Domain;
use App\Models\Notification;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    public function index(Request $request)
    {
        $domains = Domain::with('project')->latest()->get();
        $projects = Project::all();
        $unreadCount = Notification::where('user_id', Auth::id())->where('read', false)->count();

        return view('domains.index', compact('domains', 'projects', 'unreadCount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'domain' => 'required|string|unique:domains,domain',
        ]);

        $project = Project::find($validated['project_id']);

        Domain::create([
            ...$validated,
            'ssl_enabled' => false,
            'verified' => false,
            'dns_status' => 'pending',
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'project_id' => $validated['project_id'],
            'action' => 'domain_added',
            'description' => "Domain {$validated['domain']} added to {$project->name}",
        ]);

        return back()->with('success', 'Domain added successfully.');
    }

    public function destroy(Domain $domain)
    {
        $domain->delete();
        return back()->with('success', 'Domain removed.');
    }
}