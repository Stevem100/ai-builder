<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Auto-run migrations if tables are missing
        try {
            $connection = $this->app['db']->connection();
            if (!Schema::hasTable('migrations') || !Schema::hasTable('sessions')) {
                Artisan::call('migrate', ['--force' => true]);
            }
        } catch (\Throwable $e) {
            // If database doesn't exist yet, create it then migrate
            try {
                $dbPath = database_path('database.sqlite');
                if (!file_exists($dbPath)) {
                    touch($dbPath);
                }
                Artisan::call('migrate', ['--force' => true]);
            } catch (\Throwable $e2) {
                // Silent fail - will show error page if critical
            }
        }
    }
}