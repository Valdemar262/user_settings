<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyCodeRequest;
use App\Services\Verification\VerificationService;
use Illuminate\Http\JsonResponse;

class VerificationController extends Controller
{
    public function __construct(
        public VerificationService $verificationService
    ) {}

    public function getMethods(): JsonResponse
    {
        $methods = $this->verificationService->getAvailableMethods(auth()->user());
        return response()->json(['methods' => $methods]);
    }

    /**
     * @throws \Exception
     */
    public function requestCode(): JsonResponse
    {
        $user = auth()->user();
        $method = request('method');
        $this->verificationService->sendCode($user, $method);
        return response()->json(['message' => 'Code sent']);
    }

    public function verify(VerifyCodeRequest $request): JsonResponse
    {
        $user = $request->user();
        $code = $request->input('code');

        if ($this->verificationService->verifyCode($user, $code)) {
            return response()->json(['message' => 'Setting updated']);
        }
        return response()->json(['error' => 'Invalid or expired code'], 400);
    }
}
