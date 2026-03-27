<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SilentLoginController extends Controller
{
    public function handle(Request $request)
    {
        $initData = $request->input('initData');

        if (! $initData) {
            return response()->json(['success' => false, 'message' => 'No initData provided.'], 400);
        }

        if (! $this->validateInitData($initData)) {
            return response()->json(['success' => false, 'message' => 'Invalid initData.'], 401);
        }

        $data = [];
        parse_str($initData, $data);
        $telegramUser = json_decode($data['user'], true);

        if (! $telegramUser || ! isset($telegramUser['id'])) {
            return response()->json(['success' => false, 'message' => 'Invalid user data.'], 400);
        }

        $user = User::updateOrCreate(
            ['telegram_id' => $telegramUser['id']],
            [
                'name' => ($telegramUser['first_name'] ?? '').(isset($telegramUser['last_name']) ? ' '.$telegramUser['last_name'] : ''),
                'telegram_username' => $telegramUser['username'] ?? null,
                'email' => $telegramUser['id'].'@telegram.user',
            ]
        );

        Auth::login($user);

        return response()->json([
            'success' => true,
            'redirect' => url('/admin'),
        ]);
    }

    protected function validateInitData(string $initData): bool
    {
        $data = [];
        parse_str($initData, $data);
        $hash = $data['hash'] ?? null;
        unset($data['hash']);

        $dataCheckArr = [];
        foreach ($data as $key => $value) {
            $dataCheckArr[] = $key.'='.$value;
        }
        sort($dataCheckArr);
        $dataCheckString = implode("\n", $dataCheckArr);

        $botToken = config('services.telegram.token');
        $secretKey = hash_hmac('sha256', $botToken, 'WebAppData', true);
        $calculatedHash = hash_hmac('sha256', $dataCheckString, $secretKey);

        return hash_equals((string) $hash, $calculatedHash);
    }
}
