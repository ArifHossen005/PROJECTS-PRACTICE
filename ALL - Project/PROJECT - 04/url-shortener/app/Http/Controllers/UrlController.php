<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class ShortUrlController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $urls = $request->user()
            ->shortUrls()
            ->latest()
            ->paginate(10);

        return response()->json([
            'message' => 'URLs retrieved successfully',
            'data'    => $urls,
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'original_url' => 'required|url|max:2048',
            'expires_at'   => 'nullable|date|after:now',
        ]);

        $shortCode = $this->generateUniqueShortCode();

        $shortUrl = ShortUrl::create([
            'user_id'      => $request->user()->id,
            'original_url' => $validated['original_url'],
            'short_code'   => $shortCode,
            'clicks'       => 0,
            'expires_at'   => $validated['expires_at'] ?? null,
        ]);

        return response()->json([
            'message'   => 'Short URL created successfully',
            'data'      => $shortUrl,
            'short_url' => url('/' . $shortCode),
        ], 201);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $shortUrl = ShortUrl::findOrFail($id);

        Gate::authorize('view', $shortUrl);

        return response()->json([
            'message' => 'URL retrieved successfully',
            'data'    => $shortUrl,
        ], 200);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $shortUrl = ShortUrl::findOrFail($id);

        Gate::authorize('update', $shortUrl);

        $validated = $request->validate([
            'original_url' => 'sometimes|required|url|max:2048',
            'expires_at'   => 'nullable|date|after:now',
        ]);

        $shortUrl->update($validated);

        return response()->json([
            'message' => 'URL updated successfully',
            'data'    => $shortUrl->fresh(),
        ], 200);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $shortUrl = ShortUrl::findOrFail($id);

        Gate::authorize('delete', $shortUrl);

        $shortUrl->delete();

        return response()->json([
            'message' => 'URL deleted successfully',
        ], 200);
    }

    private function generateUniqueShortCode(): string
    {
        do {
            $code = Str::random(6);
        } while (ShortUrl::where('short_code', $code)->exists());

        return $code;
    }
}
