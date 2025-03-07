<?php

namespace App\Services\Verification\Channels;

use App\Services\Verification\Contracts\VerificationChannel;

class TelegramChannel implements VerificationChannel
{
    public function send(string $destination, string $code): void
    {
        // Здесь логика отправки в Telegram
    }

    public function isAvailable($user): bool
    {
        return !empty($user->telegram_id);
    }
}
