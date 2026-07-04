<?php

namespace App\Services;

use CodeIgniter\HTTP\CURLRequest;

class GoogleAuthService
{
    protected string $clientId;
    protected string $clientSecret;
    protected string $callbackUrl;

    protected const AUTH_URL    = 'https://accounts.google.com/o/oauth2/v2/auth';
    protected const TOKEN_URL   = 'https://oauth2.googleapis.com/token';
    protected const USERINFO_URL = 'https://www.googleapis.com/oauth2/v2/userinfo';

    public function __construct()
    {
        $this->clientId     = env('GOOGLE_CLIENT_ID', '');
        $this->clientSecret = env('GOOGLE_CLIENT_SECRET', '');
        $this->callbackUrl  = env('GOOGLE_CALLBACK_URL', '');
    }

    /**
     * Get the Google OAuth authorization URL.
     */
    public function getAuthUrl(): string
    {
        $params = [
            'client_id'     => $this->clientId,
            'redirect_uri'  => $this->callbackUrl,
            'response_type' => 'code',
            'scope'         => 'openid email profile',
            'access_type'   => 'online',
            'prompt'        => 'consent',
        ];

        return self::AUTH_URL . '?' . http_build_query($params);
    }

    /**
     * Exchange authorization code for access token.
     */
    public function authenticate(string $code): ?array
    {
        $client = \Config\Services::curlrequest();

        $response = $client->post(self::TOKEN_URL, [
            'form_params' => [
                'code'          => $code,
                'client_id'     => $this->clientId,
                'client_secret' => $this->clientSecret,
                'redirect_uri'  => $this->callbackUrl,
                'grant_type'    => 'authorization_code',
            ],
            'http_errors' => false,
        ]);

        $body = json_decode($response->getBody(), true);

        if (isset($body['access_token'])) {
            return $body;
        }

        return null;
    }

    /**
     * Get user info from Google using access token.
     */
    public function getUserInfo(string $accessToken): ?array
    {
        $client = \Config\Services::curlrequest();

        $response = $client->get(self::USERINFO_URL, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ],
            'http_errors' => false,
        ]);

        $body = json_decode($response->getBody(), true);

        if (isset($body['id'])) {
            return $body;
        }

        return null;
    }
}
