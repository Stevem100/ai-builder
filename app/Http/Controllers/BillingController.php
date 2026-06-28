<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        $subscription = Subscription::firstOrCreate(
            ['user_id' => Auth::id()],
            ['plan' => 'free', 'status' => 'active', 'ai_tokens_used' => 24500, 'ai_tokens_limit' => 100000, 'current_period_start' => now(), 'current_period_end' => now()->addMonth()]
        );

        $unreadCount = Notification::where('user_id', Auth::id())->where('read', false)->count();

        $usage = [
            'projects' => ['used' => 3, 'limit' => $subscription->plan === 'enterprise' ? 999 : ($subscription->plan === 'pro' ? 25 : 3)],
            'deployments' => ['used' => 8, 'limit' => $subscription->plan === 'enterprise' ? 999 : ($subscription->plan === 'pro' ? 200 : 50)],
            'storage' => ['used' => 2.4, 'limit' => $subscription->plan === 'enterprise' ? 100 : ($subscription->plan === 'pro' ? 25 : 5)],
            'ai_tokens' => ['used' => $subscription->ai_tokens_used, 'limit' => $subscription->ai_tokens_limit],
        ];

        $invoices = [
            ['id' => 'INV-001', 'date' => '2026-06-01', 'amount' => $subscription->plan === 'pro' ? 29.00 : 0.00, 'status' => 'paid'],
            ['id' => 'INV-002', 'date' => '2026-05-01', 'amount' => $subscription->plan === 'pro' ? 29.00 : 0.00, 'status' => 'paid'],
            ['id' => 'INV-003', 'date' => '2026-04-01', 'amount' => 0.00, 'status' => 'paid'],
        ];

        return view('billing.index', compact('subscription', 'usage', 'invoices', 'unreadCount'));
    }

    public function plans(Request $request)
    {
        $subscription = Subscription::where('user_id', Auth::id())->first();
        $unreadCount = Notification::where('user_id', Auth::id())->where('read', false)->count();
        return view('billing.plans', compact('subscription', 'unreadCount'));
    }

    public function subscribe(Request $request)
    {
        $request->validate(['plan' => 'required|in:free,pro,enterprise']);

        $limits = ['free' => 10000, 'pro' => 100000, 'enterprise' => 1000000];

        Subscription::updateOrCreate(
            ['user_id' => Auth::id()],
            ['plan' => $request->plan, 'status' => 'active', 'ai_tokens_limit' => $limits[$request->plan], 'current_period_start' => now(), 'current_period_end' => now()->addMonth()]
        );

        return redirect()->route('billing.index')->with('success', "Subscribed to " . ucfirst($request->plan) . " plan!");
    }

    public function apiUsage()
    {
        $sub = Subscription::where('user_id', Auth::id())->first();
        return response()->json([
            'ai_tokens_used' => $sub?->ai_tokens_used ?? 0,
            'ai_tokens_limit' => $sub?->ai_tokens_limit ?? 10000,
        ]);
    }
}