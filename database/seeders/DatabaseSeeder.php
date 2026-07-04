<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Deployment;
use App\Models\Domain;
use App\Models\Notification;
use App\Models\Project;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo user
        $user = User::firstOrCreate(
            ['email' => 'admin@ai-builder.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        // Subscription
        Subscription::firstOrCreate(
            ['user_id' => $user->id],
            [
                'plan' => 'pro',
                'status' => 'active',
                'current_period_start' => now(),
                'current_period_end' => now()->addMonth(),
                'ai_tokens_used' => 24500,
                'ai_tokens_limit' => 100000,
            ]
        );

        // Projects
        $projects = [
            ['name' => 'E-Commerce Platform', 'description' => 'Full-featured online store with product catalog, cart, checkout, and admin panel', 'type' => 'fullstack', 'framework' => 'Next.js', 'status' => 'active', 'storage_used' => 845000],
            ['name' => 'SaaS Dashboard', 'description' => 'Analytics dashboard with real-time charts, user management, and billing integration', 'type' => 'frontend', 'framework' => 'React / Next.js', 'status' => 'active', 'storage_used' => 520000],
            ['name' => 'Portfolio Website', 'description' => 'Modern portfolio with blog, projects showcase, and contact form', 'type' => 'frontend', 'framework' => 'Vue / Nuxt', 'status' => 'active', 'storage_used' => 180000],
        ];

        $createdProjects = [];
        foreach ($projects as $p) {
            $createdProjects[] = Project::firstOrCreate(
                ['name' => $p['name']],
                array_merge($p, ['user_id' => $user->id])
            );
        }

        // Deployments
        $deployments = [
            ['project_id' => $createdProjects[0]->id, 'status' => 'live', 'version' => 'v1.3.0', 'duration' => 95, 'started_at' => now()->subHours(2)],
            ['project_id' => $createdProjects[0]->id, 'status' => 'live', 'version' => 'v1.2.0', 'duration' => 120, 'started_at' => now()->subDays(1)],
            ['project_id' => $createdProjects[1]->id, 'status' => 'live', 'version' => 'v2.0.1', 'duration' => 88, 'started_at' => now()->subHours(5)],
            ['project_id' => $createdProjects[1]->id, 'status' => 'failed', 'version' => 'v2.0.0', 'duration' => 45, 'started_at' => now()->subDays(2)],
            ['project_id' => $createdProjects[2]->id, 'status' => 'live', 'version' => 'v1.0.0', 'duration' => 60, 'started_at' => now()->subDays(3)],
        ];

        foreach ($deployments as $d) {
            Deployment::firstOrCreate(
                ['project_id' => $d['project_id'], 'version' => $d['version']],
                array_merge($d, [
                    'log' => "[{$d['version']}] Starting deployment...\n[{$d['version']}] Installing dependencies... ✓\n[{$d['version']}] Running tests... ✓\n[{$d['version']}] Building assets... ✓\n[{$d['version']}] Deploying to production... " . ($d['status'] === 'live' ? '✓' : '✗'),
                    'completed_at' => (clone $d['started_at'])->addSeconds($d['duration']),
                ])
            );
        }

        // Domains
        Domain::firstOrCreate(
            ['domain' => 'store.aibuilder.dev'],
            ['project_id' => $createdProjects[0]->id, 'ssl_enabled' => true, 'verified' => true, 'dns_status' => 'verified']
        );
        Domain::firstOrCreate(
            ['domain' => 'dashboard.aibuilder.dev'],
            ['project_id' => $createdProjects[1]->id, 'ssl_enabled' => true, 'verified' => true, 'dns_status' => 'verified']
        );

        // Notifications
        $notifications = [
            ['title' => 'Deployment Live', 'message' => 'E-Commerce Platform v1.3.0 is now live at store.aibuilder.dev', 'type' => 'success', 'read' => false],
            ['title' => 'AI Code Generated', 'message' => 'AI generated a new product catalog component with filtering and search', 'type' => 'info', 'read' => false],
            ['title' => 'SSL Certificate Renewed', 'message' => 'SSL certificate for store.aibuilder.dev has been renewed successfully', 'type' => 'success', 'read' => false],
            ['title' => 'Deployment Failed', 'message' => 'SaaS Dashboard v2.0.0 deployment failed. Check logs for details.', 'type' => 'error', 'read' => true],
            ['title' => 'New Project Created', 'message' => 'Portfolio Website has been created and is ready for development.', 'type' => 'info', 'read' => true],
            ['title' => 'Scheduled Maintenance', 'message' => 'System maintenance scheduled in 2 hours. Expected downtime: 5 minutes.', 'type' => 'warning', 'read' => false],
        ];

        foreach ($notifications as $n) {
            Notification::firstOrCreate(
                ['title' => $n['title'], 'user_id' => $user->id],
                array_merge($n, ['user_id' => $user->id])
            );
        }

        // Activity logs
        $activities = [
            ['action' => 'deployment_completed', 'description' => 'E-Commerce Platform deployed v1.3.0 successfully', 'project_id' => $createdProjects[0]->id],
            ['action' => 'ai_generated', 'description' => 'AI generated product catalog component', 'project_id' => $createdProjects[0]->id],
            ['action' => 'project_created', 'description' => 'New project "Portfolio Website" created', 'project_id' => $createdProjects[2]->id],
            ['action' => 'domain_verified', 'description' => 'SSL certificate renewed for store.aibuilder.dev', 'project_id' => $createdProjects[0]->id],
            ['action' => 'deployment_failed', 'description' => 'Deployment failed for SaaS Dashboard v2.0.0', 'project_id' => $createdProjects[1]->id],
            ['action' => 'ssl_renewed', 'description' => 'SSL certificate renewed for dashboard.aibuilder.dev', 'project_id' => $createdProjects[1]->id],
        ];

        foreach ($activities as $a) {
            ActivityLog::create(array_merge($a, ['user_id' => $user->id]));
        }
    }
}