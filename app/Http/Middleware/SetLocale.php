<?php
// app/Http/Middleware/SetLocale.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request; // This was missing
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log; // Add this line


class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            
            if (in_array($locale, ['en', 'ar'])) {
                App::setLocale($locale);
                // Add this line to override config setting
                config(['app.locale' => $locale]); 
                Log::debug("SetLocale middleware: Setting locale to $locale");
            }
        } else {
            // Default locale from config
            $locale = config('app.locale');
            Session::put('locale', $locale);
            Log::debug("SetLocale middleware: Using default locale $locale");
        }

        return $next($request);
    }
}