<?php

namespace App\TokenStore;

use App\Providers\OAuthClientProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

class TokenCache {
  public function storeTokens($accessToken, $user) {
    session([
      'accessToken' => $accessToken->getToken(),
      'refreshToken' => $accessToken->getRefreshToken(),
      'tokenExpires' => $accessToken->getExpires(),
      'userName' => $user["displayName"],
      'userEmail' => null !== $user["email"] ? $user["email"] : $user["principalName"]
    ]);
  }

  public function clearTokens() {
    session()->forget('accessToken');
    session()->forget('refreshToken');
    session()->forget('tokenExpires');
    session()->forget('userName');
    session()->forget('userEmail');
  }

  public function getAccessToken() {
    if (
      empty(session('accessToken')) ||
      empty(session('refreshToken')) ||
      empty(session('tokenExpires'))
    ) {
      return '';
    }

    $now = time() + 300;
    if (session('tokenExpires') <= $now) {
      $oauthClient = new OAuthClientProvider();

      try {
        $newToken = $oauthClient->getAccessToken('refresh_token', [
          'refresh_token' => session('refreshToken')
        ]);

        $this->updateTokens($newToken);

        return $newToken->getToken();
      } catch (IdentityProviderException $e) {
        return '';
      }
    }

    return session('accessToken');
  }

  public function updateTokens($accessToken) {
    session([
      'accessToken' => $accessToken->getToken(),
      'refreshToken' => $accessToken->getRefreshToken(),
      'tokenExpires' => $accessToken->getExpires()
    ]);
  }
}
