<?php

namespace App\Providers;

use \League\OAuth2\Client\Provider\GenericProvider;
use GuzzleHttp\Client;

class OAuthClientProvider extends GenericProvider {

  public function __construct() {
    $tenant_id = env("MICROSOFT_TENANT_ID");
    $redirect_uri = url()->route("ms-login-callback");

    parent::__construct([
      "clientId"                => env("MICROSOFT_CLIENT_ID"),
      "clientSecret"            => env("MICROSOFT_CLIENT_SECRET"),
      "redirectUri"             => $redirect_uri,
      "urlAuthorize"            => "https://login.microsoftonline.com/" . $tenant_id . "/oauth2/v2.0/authorize",
      "urlAccessToken"          => "https://login.microsoftonline.com/" . $tenant_id . "/oauth2/v2.0/token",
      "urlResourceOwnerDetails" => "",
      "scopes"                  => env("MICROSOFT_SCOPES")
    ]);
  }

  public function getUserInfo($accessToken) {
    $token = $accessToken->getToken();
    $client = new Client();

    $response = $client->get("https://graph.microsoft.com/v1.0/me", [
      "headers" => [
        "Authorization" => $token
      ]
    ]);

    $result = json_decode($response->getBody(), true);

    return [
      "displayName" => $result["displayName"],
      "email" => $result["mail"],
      "firstname" => $result["givenName"],
      "lastname" => $result["surname"],
      "principalName" => $result["userPrincipalName"]
    ];
  }
}
