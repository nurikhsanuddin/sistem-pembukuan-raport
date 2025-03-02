<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register DomPDF configuration
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/dompdf.php',
            'dompdf'
        );

        // Make sure the file exists before requiring it
        $helperPath = app_path('Helpers/DateHelper.php');
        if (file_exists($helperPath)) {
            require_once $helperPath;
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
