<?php

namespace App\Jobs;

use App\Services\Verification\Channels\EmailChannel;
use App\Services\Verification\Channels\SmsChannel;
use App\Services\Verification\Channels\TelegramChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class SendVerificationCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    protected string $destination;

    protected string $code;

    protected string $method;

    public function __construct(
        string $destination,
        string $code,
        string $method
    ) {
        $this->destination = $destination;
        $this->code = $code;
        $this->method = $method;
    }

    public function handle(): void
    {
        $channelClass = [
            'email' => EmailChannel::class,
            'sms' => SmsChannel::class,
            'telegram' => TelegramChannel::class,
        ][$this->method];

        $channel = app($channelClass);
        $channel->send($this->destination, $this->code);
    }
}
