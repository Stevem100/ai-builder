<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Deployment;
use App\Models\Notification;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::withCount('deployments')->latest()->get();
        $unreadCount = Notification::where('user_id', Auth::id())->where('read', false)->count();

        return view('projects.index', compact('projects', 'unreadCount'));
    }

    public function create()
    {
        $unreadCount = Notification::where('user_id', Auth::id())->where('read', false)->count();
        return view('projects.create', compact('unreadCount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:frontend,backend,fullstack',
            'framework' => 'nullable|string|max:255',
        ]);

        $project = Project::create([
            ...$validated,
            'user_id' => Auth::id(),
            'status' => 'active',
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'project_id' => $project->id,
            'action' => 'project_created',
            'description' => "Project \"{$project->name}\" created",
        ]);

        Notification::create([
            'user_id' => Auth::id(),
            'title' => 'Project Created',
            'message' => "Your project \"{$project->name}\" has been created successfully.",
            'type' => 'success',
        ]);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        $project->load(['deployments' => fn($q) => $q->latest()->take(5), 'domains']);
        $unreadCount = Notification::where('user_id', Auth::id())->where('read', false)->count();
        $files = $this->getFileTree($project);

        return view('projects.show', compact('project', 'unreadCount', 'files'));
    }

    public function edit(Project $project)
    {
        return redirect()->route('projects.show', $project);
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:frontend,backend,fullstack',
            'framework' => 'nullable|string|max:255',
        ]);

        $project->update($validated);

        return redirect()->route('projects.show', $project)->with('success', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        $name = $project->name;
        $project->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'project_deleted',
            'description' => "Project \"{$name}\" deleted",
        ]);

        return redirect()->route('projects.index')->with('success', 'Project deleted.');
    }

    public function editor(Project $project)
    {
        $files = $this->getFileTree($project);
        $unreadCount = Notification::where('user_id', Auth::id())->where('read', false)->count();
        return view('projects.editor', compact('project', 'files', 'unreadCount'));
    }

    public function terminal(Project $project)
    {
        $unreadCount = Notification::where('user_id', Auth::id())->where('read', false)->count();
        return view('projects.terminal', compact('project', 'unreadCount'));
    }

    public function preview(Project $project)
    {
        $unreadCount = Notification::where('user_id', Auth::id())->where('read', false)->count();
        return view('projects.preview', compact('project', 'unreadCount'));
    }

    // API endpoints
    public function apiIndex()
    {
        return response()->json(Project::withCount('deployments')->latest()->get());
    }

    public function apiStore(Request $request)
    {
        $project = Project::create([
            ...$request->validate(['name' => 'required', 'description' => 'nullable', 'type' => 'required', 'framework' => 'nullable']),
            'user_id' => Auth::id(),
        ]);
        return response()->json($project, 201);
    }

    public function apiShow(Project $project)
    {
        $project->load('deployments', 'domains');
        $project->files = $this->getFileTree($project);
        return response()->json($project);
    }

    public function apiDestroy(Project $project)
    {
        $project->delete();
        return response()->json(['message' => 'Deleted']);
    }

    private function getFileTree(Project $project): array
    {
        $name = $project->name;
        $desc = $project->description ?? 'A modern web application';
        $type = $project->type;
        $fw = $project->framework ?? 'Custom';

        return [
            ['name' => 'index.html', 'type' => 'file', 'lang' => 'html', 'content' => "<!DOCTYPE html>\n<html lang=\"en\">\n<head>\n  <meta charset=\"UTF-8\">\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n  <title>{$name}</title>\n  <link rel=\"stylesheet\" href=\"styles.css\">\n</head>\n<body>\n  <div id=\"app\">\n    <header>\n      <nav>\n        <h1>{$name}</h1>\n        <ul>\n          <li><a href=\"#\">Home</a></li>\n          <li><a href=\"#\">About</a></li>\n          <li><a href=\"#\">Contact</a></li>\n        </ul>\n      </nav>\n    </header>\n    <main>\n      <section class=\"hero\">\n        <h2>Welcome to {$name}</h2>\n        <p>{$desc}</p>\n        <button class=\"cta-btn\">Get Started</button>\n      </section>\n    </main>\n  </div>\n  <script src=\"app.js\"></script>\n</body>\n</html>"],
            ['name' => 'styles.css', 'type' => 'file', 'lang' => 'css', 'content' => "* {\n  box-sizing: border-box;\n  margin: 0;\n  padding: 0;\n}\n\nbody {\n  font-family: 'Inter', system-ui, sans-serif;\n  background: #0f172a;\n  color: #e2e8f0;\n  line-height: 1.6;\n}\n\nheader {\n  background: #1e293b;\n  padding: 1rem 2rem;\n  border-bottom: 1px solid #334155;\n}\n\nnav {\n  display: flex;\n  justify-content: space-between;\n  align-items: center;\n  max-width: 1200px;\n  margin: 0 auto;\n}\n\nnav h1 { color: #3b82f6; }\nnav ul { list-style: none; display: flex; gap: 2rem; }\nnav a { color: #94a3b8; text-decoration: none; }\nnav a:hover { color: #e2e8f0; }\n\n.hero {\n  max-width: 800px;\n  margin: 4rem auto;\n  text-align: center;\n  padding: 0 2rem;\n}\n\n.hero h2 { font-size: 2.5rem; margin-bottom: 1rem; }\n.hero p { color: #94a3b8; font-size: 1.125rem; margin-bottom: 2rem; }\n\n.cta-btn {\n  background: #3b82f6;\n  color: white;\n  border: none;\n  padding: 0.75rem 2rem;\n  border-radius: 0.5rem;\n  font-size: 1rem;\n  cursor: pointer;\n}\n\n.cta-btn:hover { background: #2563eb; }"],
            ['name' => 'app.js', 'type' => 'file', 'lang' => 'javascript', 'content' => "// {$name} - Main Application\n\ndocument.addEventListener('DOMContentLoaded', () => {\n  console.log('{$name} initialized');\n\n  const app = {\n    init() {\n      this.bindEvents();\n      this.loadContent();\n    },\n\n    bindEvents() {\n      document.querySelector('.cta-btn')?.addEventListener('click', () => {\n        alert('Welcome to {$name}!');\n      });\n    },\n\n    async loadContent() {\n      console.log('Content loaded');\n    }\n  };\n\n  app.init();\n});"],
            ['name' => 'package.json', 'type' => 'file', 'lang' => 'json', 'content' => "{\n  \"name\": \"{$name}\",\n  \"version\": \"1.0.0\",\n  \"description\": \"{$desc}\",\n  \"main\": \"app.js\",\n  \"scripts\": {\n    \"dev\": \"vite\",\n    \"build\": \"vite build\",\n    \"preview\": \"vite preview\"\n  },\n  \"dependencies\": {},\n  \"devDependencies\": {\n    \"vite\": \"^5.0.0\"\n  }\n}"],
            ['name' => 'README.md', 'type' => 'file', 'lang' => 'markdown', 'content' => "# {$name}\n\n{$desc}\n\n## Getting Started\n\nnpm install\nnpm run dev\n\n## Project Type\n{$type}\n\n## Framework\n{$fw}\n\nBuilt with AI Builder"],
        ];
    }
}