<?php

namespace App\Services\Verification;

use App\Jobs\SendVerificationCodeJob;
use App\Models\User;
use App\Models\VerificationCode;
use App\Services\Verification\Channels\EmailChannel;
use App\Services\Verification\Channels\SmsChannel;
use App\Services\Verification\Channels\TelegramChannel;

class VerificationService
{
    protected array $channels = [
        'email' => EmailChannel::class,
        'sms' => SmsChannel::class,
        'telegram' => TelegramChannel::class,
    ];

    public function getAvailableMethods(User $user): array
    {
        $available = [];
        foreach ($this->channels as $method => $channelClass) {
            $channel = app($channelClass);
            if ($channel->isAvailable($user)) {
                $available[] = $method;
            }
        }
        return $available;
    }

    /**
     * @throws \Exception
     */
    public function sendCode(User $user, string $method, string $settingKey = null): void
    {
        if (!isset($this->channels[$method])) {
            throw new \Exception("Invalid verification method: $method");
        }

        $code = $this->generateCode();
        $destination = $this->getDestination($user, $method);

        VerificationCode::create([
            'user_id' => $user->id,
            'code' => $code,
            'setting_key' => $settingKey,
            'method' => $method,
            'expires_at' => now()->addMinutes(15),
        ]);

        SendVerificationCodeJob::dispatch($destination, $code, $method);
    }

    public function verifyCode(User $user, string $code): bool
    {
        $verification = VerificationCode::where('user_id', $user->id)
            ->where('code', $code)
            ->latest()
            ->first();

        if ($verification && !$verification->isExpired()) {
            $settingKey = $verification->setting_key;
            if ($settingKey) {
                app(SettingService::class)->applyUpdate($user, $settingKey);
            }
            $verification->delete();
            return true;
        }

        return false;
    }

    protected function generateCode(): string
    {
        return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * @throws \Exception
     */
    protected function getDestination(User $user, string $method): string
    {
        return match ($method) {
            'email' => $user->email,
            'sms' => $user->phone ?? '',
            'telegram' => $user->telegram_id ?? '',
            default => throw new \Exception("Unknown method: $method"),
        };
    }
}
