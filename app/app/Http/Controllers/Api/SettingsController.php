<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSettingRequest;
use App\Services\SettingService;
use Illuminate\Http\JsonResponse;

class SettingsController extends Controller
{
    public function __construct(
        public SettingService $settingService
    ) {}

    public function update(UpdateSettingRequest $request): JsonResponse
    {
        $user = $request->user();
        $key = $request->input('key');
        $value = $request->input('value');
        $method = $request->input('method');

        $this->settingService->requestUpdate($user, $key, $value, $method);

        return response()->json(['message' => 'Verification code sent']);
    }
}
