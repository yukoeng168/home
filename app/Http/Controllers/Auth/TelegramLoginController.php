<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Ai\AnonymousAgent;

class TelegramLoginController extends Controller
{
    public function handleCallback(Request $request)
    {
        $authData = $request->all();
        
        if (!$this->checkTelegramAuthorization($authData)) {
            return redirect('/login')->withErrors(['telegram' => 'Telegram authorization failed.']);
        }

        $user = User::updateOrCreate(
            ['telegram_id' => $authData['id']],
            [
                'name' => $authData['first_name'] . (isset($authData['last_name']) ? ' ' . $authData['last_name'] : ''),
                'telegram_username' => $authData['username'] ?? null,
                'email' => $authData['id'] . '@telegram.user',
            ]
        );

        Auth::login($user);

        // Generate AI Welcome Message
        $agent = new AnonymousAgent(
            'You are a friendly property manager for a rental system. Generate a very short, warm welcome back message.',
            [],
            []
        );
        
        $welcomeMessage = $agent->prompt("The tenant {$user->name} just logged in via Telegram. Say something nice.")->text();

        return redirect()->intended('/admin')->with('status', $welcomeMessage);
    }

    protected function checkTelegramAuthorization(array $authData): bool
    {
        if (!isset($authData['hash'])) {
            return false;
        }

        $checkHash = $authData['hash'];
        unset($authData['hash']);

        $dataCheckArr = [];
        foreach ($authData as $key => $value) {
            $dataCheckArr[] = $key . '=' . $value;
        }
        sort($dataCheckArr);
        $dataCheckString = implode("\n", $dataCheckArr);

        $botToken = config('services.telegram.token');
        $secretKey = hash('sha256', $botToken, true);
        $hash = hash_hmac('sha256', $dataCheckString, $secretKey);

        if (strcmp($hash, $checkHash) !== 0) {
            return false;
        }

        if ((time() - $authData['auth_date']) > 86400) {
            return false;
        }

        return true;
    }
}
