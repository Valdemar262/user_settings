<?php

namespace App\Services;

use App\Models\User;
use App\Services\Verification\VerificationService;

class SettingService
{
    public function __construct(
        public VerificationService $verificationService
    ) {}

    /**
     * @throws \Exception
     */
    public function requestUpdate(User $user, string $key, $value, string $method): void
    {
        session(["pending_setting_{$key}" => $value]);

        $this->verificationService->sendCode($user, $method, $key);
    }

    public function applyUpdate(User $user, string $key): void
    {
        $value = session("pending_setting_{$key}");
        if ($value !== null) {
            $settings = $user->settings ?? [];
            $settings[$key] = $value;
            $user->settings = $settings;
            $user->save();
            session()->forget("pending_setting_{$key}");
        }
    }
}
