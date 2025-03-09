<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Language;

class LanguageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->share('activeLanguages', Language::where('active', true)->get());
    }
}
