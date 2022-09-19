<?php

namespace App\SocialiteProviders\Kakao;

use SocialiteProviders\Kakao\KakaoProvider as BaseKakaoProvider;

class KakaoProvider extends BaseKakaoProvider
{
    /**
     * Get the POST fields for the token request.
     *
     * @param string $code
     *
     * @return array
     */
    protected function getTokenFields($code): array
    {
        return [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUrl,
            'code' => $code,
        ];
    }
}
