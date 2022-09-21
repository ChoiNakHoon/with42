<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Laravel\Passport\Client;
use Illuminate\Http\{RedirectResponse, Request};
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialUser;

class SocialController extends Controller
{
    /**
     * 주어진 Provider에 대하여 소셜 응답을 처리합니다.
     */
    public function execute(Request $request, string $provider)
    {
        if (!array_key_exists($provider, config('services'))) {
            $status = \Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED;
            return view('login.result', [
                'status' => $status,
            ]);
        }

        // url parameter에 code인자가 포함되어 있다면
        if (!$request->has('code')) {
            // 소셜에서 인증됨
            info('소셜로그인', ['code 여부' => $request->code]);
            return $this->redirectToProvider($provider);
        }
        return $this->handleProviderCallback($request, $provider);
    }

    /**
     * 사용자를 주어진 공급자의 OAuth 서비스로 리디렉션합니다.
     */
    protected function redirectToProvider(string $provider): RedirectResponse
    {
        info('소셜로그인', ['소셜로그인 종류' => $provider]);
        return Socialite::driver($provider)->redirect();
    }

    /**
     * 소셜에서 인증을 받은 후 응답입니다.
     */
    protected function handleProviderCallback(Request $request, string $provider)
    {
        info('소셜 로그인', ['소셜로그인 PROVIDER' => $provider]);
        $socialUser = Socialite::driver($provider)
            ->stateless()
            ->user();
        info('소셜 로그인', ['유저정보' => $socialUser]);

        if ($user = User::where('email', $socialUser->getEmail())->first()) {
            Auth::login($user, true);
<<<<<<< Updated upstream

=======
>>>>>>> Stashed changes
            $status = \Symfony\Component\HttpFoundation\Response::HTTP_OK;
            return view('login.result', [
                'status' => $status,
            ]);
        }
        return $this->register($socialUser, $provider);
    }

    /**
     * 주어진 소셜 회원을 응용 프로그램에 등록합니다.
     */
    protected function register(
        SocialUser $socialUser,
<<<<<<< Updated upstream
        string $provider
=======
        string $provider,
>>>>>>> Stashed changes
    ) {

        // socialUser 객체를 등록하고, Registered 이벤트를 발생시킵니다.
        event(
            new Registered(
                ($user = User::create([
                    'login_method' => $provider,
                    'name' => $socialUser->name,
                    'email' => empty($socialUser->email) ? null : $socialUser->email,
                    'password' => bcrypt($socialUser->id),
                ]))
            )
        );

        switch ($provider) {
            case 'naver':
                $user->naver_token  = $socialUser->id;
                break;
            case 'kakao':
                $user->kakao_token  = $socialUser->id;
                break;
            case 'google':
                $user->google_token  = $socialUser->id;
                break;
            case 'apple':
                $user->apple_token = $socialUser->id;
                break;
        }

        $user->email_verified_at = $user->freshTimestamp();
        $user->remember_token = Str::random(60);
        $user->save();

        Auth::login($user, true);
        $status = Symfony\Component\HttpFoundation\Response::HTTP_CREATED;
        return view('login.result', [
            'status' => $status,
        ]);
    }
}
