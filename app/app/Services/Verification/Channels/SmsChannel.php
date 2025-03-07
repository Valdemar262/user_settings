<?php

namespace App\Services\Verification\Channels;

use App\Services\Verification\Contracts\VerificationChannel;

class SmsChannel implements VerificationChannel
{
    public function send(string $destination, string $code): void
    {
        // Здесь логика отправки SMS
    }

    public function isAvailable($user): bool
    {
        return !empty($user->phone);
    }
}
