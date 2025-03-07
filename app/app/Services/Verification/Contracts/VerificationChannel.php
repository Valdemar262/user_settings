<?php

namespace App\Services\Verification\Contracts;

interface VerificationChannel
{
    public function send(string $destination, string $code): void;

    public function isAvailable($user): bool;
}
