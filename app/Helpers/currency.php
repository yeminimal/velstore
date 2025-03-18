<?php

use Illuminate\Support\Facades\Cache;
use App\Models\Currency;

if (!function_exists('convert_price')) {
    function convert_price($amount, $currencyCode = null) {
        $currencyCode = $currencyCode ?: session('currency', 'USD'); // Default to USD
        $exchangeRate = Cache::rememberForever("currency_{$currencyCode}", function () use ($currencyCode) {
            return Currency::where('code', $currencyCode)->value('exchange_rate') ?: 1.0;
        });

        return round($amount * $exchangeRate, 2);
    }
}
