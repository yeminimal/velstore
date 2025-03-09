<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request)
    {
        $lang = $request->input('lang');
        
        // Validate if the language is supported (you can extend this)
        if (!in_array($lang, ['en', 'es', 'de', 'ar', 'fa', 'it', 'nl', 'pl', 'pt', 'tr','zh', 'fr', 'ru', 'ja', 'ko', 'th', 'vi','hi','id'])) {
            return response()->json(['error' => 'Unsupported language'], 400);
        }

        // Change language using Laravel's localization system
       /* session()->put('locale', $lang);
        app()->setLocale($lang); */

        session(['locale' => $lang]);
        app()->setLocale($lang);  

        return response()->json(['message' => 'Language changed successfully']);
    }
}
