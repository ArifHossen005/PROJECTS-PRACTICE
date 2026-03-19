<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class RedirectController extends Controller
{
    public function redirect(string $shortCode)
    {
        $shortUrl = ShortUrl::where('short_code', $shortCode)->first();

        if (!$shortUrl) {
            return response()->json([
                'message' => 'Short URL not found.',
            ], 404);
        }

        if ($shortUrl->isExpired()) {
            return response()->json([
                'message' => 'This short URL has expired.',
            ], 410);
        }

        $shortUrl->increment('clicks');

        return redirect()->away($shortUrl->original_url, 302);
    }
}
