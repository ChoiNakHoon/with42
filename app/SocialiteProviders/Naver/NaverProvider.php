<?php

namespace App\SocialiteProviders\Naver;

use SocialiteProviders\Manager\OAuth2\User;
use SocialiteProviders\Naver\Provider as BaseNaverProvider;

class NaverProvider extends BaseNaverProvider
{
    /**
     * Map the raw user array to a Socialite User instance.
     *
     * @param array $user
     * @return User
     */
    protected function mapUserToObject(array $user): User
    {
        info('소셜로그인', ['유저정보 가져오기 시작']);
        info('소셜로그인', ['유저 정보' => $user]);
        return (new User())->setRaw($user)->map([
            'id' => $user['response']['id'],
            'name' => $user['response']['name'],
            'email' => $user['response']['email'],
        ]);
    }
}
