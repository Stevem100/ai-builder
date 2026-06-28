<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }
        $user = Auth::user();
        $unreadCount = Notification::where('user_id', Auth::id())->where('read', false)->count();

        $envVars = [
            ['key' => 'APP_ENV', 'value' => 'production'],
            ['key' => 'DB_DATABASE', 'value' => 'database.sqlite'],
            ['key' => 'CACHE_DRIVER', 'value' => 'file'],
            ['key' => 'SESSION_DRIVER', 'value' => 'database'],
            ['key' => 'MAIL_MAILER', 'value' => 'smtp'],
        ];

        return view('settings.index', compact('user', 'unreadCount', 'envVars'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
        ]);

        if (Auth::user()) {
            Auth::user()->update($validated);
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}