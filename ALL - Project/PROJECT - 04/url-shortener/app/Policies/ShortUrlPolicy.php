<?php

namespace App\Policies;

use App\Models\ShortUrl;
use App\Models\User;

class ShortUrlPolicy
{
    public function view(User $user, ShortUrl $shortUrl): bool
    {
        return $user->id === $shortUrl->user_id;
    }

    public function update(User $user, ShortUrl $shortUrl): bool
    {
        return $user->id === $shortUrl->user_id;
    }

    public function delete(User $user, ShortUrl $shortUrl): bool
    {
        return $user->id === $shortUrl->user_id;
    }
}
