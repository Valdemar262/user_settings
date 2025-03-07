<?php

namespace App\Services\Verification\Channels;

use App\Services\Verification\Contracts\VerificationChannel;

class EmailChannel implements VerificationChannel
{
    public function send(string $destination, string $code): void
    {
        // Здесь логика отправки email
    }

    public function isAvailable($user): bool
    {
        return !empty($user->email);
    }
}
