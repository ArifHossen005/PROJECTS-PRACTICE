<?php

use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'URL Shortener API is running!',
        'version' => '1.0.0',
    ], 200);
});

Route::get('/{short_code}', [RedirectController::class, 'redirect'])
    ->where('short_code', '^(?!api|up)[a-zA-Z0-9]+$');
