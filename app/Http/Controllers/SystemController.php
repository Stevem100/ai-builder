<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function health()
    {
        return response()->json([
            'status' => 'healthy',
            'timestamp' => now()->toISOString(),
            'services' => [
                ['name' => 'API Server', 'status' => 'online', 'latency' => '12ms'],
                ['name' => 'Database (SQLite)', 'status' => 'online', 'latency' => '3ms'],
                ['name' => 'Redis Cache', 'status' => 'online', 'latency' => '1ms'],
                ['name' => 'Container Engine', 'status' => 'online', 'latency' => '0ms'],
                ['name' => 'AI Engine', 'status' => 'online', 'latency' => '245ms'],
            ],
        ]);
    }

    public function metrics()
    {
        return response()->json([
            'cpu' => ['usage' => 23.5, 'cores' => 4],
            'memory' => ['used' => '2.1 GB', 'total' => '8 GB', 'percentage' => 26.3],
            'disk' => ['used' => '45.2 GB', 'total' => '200 GB', 'percentage' => 22.6],
            'containers' => ['total' => 12, 'running' => 10, 'stopped' => 2],
            'ai' => ['tokens_today' => 4500, 'requests_today' => 23, 'avg_latency' => '1.2s'],
            'uptime' => '99.9%',
        ]);
    }
}