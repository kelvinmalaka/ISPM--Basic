<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\TokenStore\TokenCache;
use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use App\Providers\OAuthClientProvider;
use App\Models\User;

class LoginMicrosoftController extends Controller {

    public function login() {
        $oauthClient = new OAuthClientProvider();

        session(['oauthState' => $oauthClient->getState()]);
        $authUrl = $oauthClient->getAuthorizationUrl();

        return redirect()->away($authUrl);
    }

    public function callback(Request $request) {
        $expectedState = session('oauthState');
        $request->session()->forget('oauthState');
        $providedState = $request->query('state');

        if (!isset($expectedState)) {
            return redirect()->route("home");
        }

        if (!isset($providedState) || $expectedState != $providedState) {
            return redirect()->route("login")
                ->with('error', 'Invalid auth state')
                ->with('errorDetail', 'The provided auth state did not match the expected value');
        }

        $authCode = $request->query('code');
        if (isset($authCode)) {
            $oauthClient = new OAuthClientProvider();

            try {
                $accessToken = $oauthClient->getAccessToken('authorization_code', ['code' => $authCode]);
                $user = $oauthClient->getUserInfo($accessToken);
                $email = $user["email"];

                // Check user registration in database
                $registered_user = User::query()->where("email", "==", $email)->first();
                if ($registered_user) {
                    $tokenCache = new TokenCache();
                    $tokenCache->storeTokens($accessToken, $user);

                    // Auth in laravel
                    $uid = $registered_user["id"];
                    auth()->loginUsingId($uid, true);

                    return redirect()->route("application");
                }

                return redirect()->route("login")
                    ->with("error", "Unregistered user")
                    ->with("errorDetail", "Your account is not registered in Microsoft. Try using email login instead.");
            } catch (IdentityProviderException $e) {
                return redirect()->route("login")
                    ->with('error', 'Error requesting access token')
                    ->with('errorDetail', json_encode($e->getResponseBody()));
            }
        }

        return redirect()->route("login")
            ->with('error', $request->query('error'))
            ->with('errorDetail', $request->query('error_description'));
    }

    public function logout() {
        $tokenCache = new TokenCache();
        $tokenCache->clearTokens();

        return redirect()->route("home");
    }
}
