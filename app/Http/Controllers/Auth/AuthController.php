<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\{Auth, Http};
use Laravel\Passport\Client;
use GuzzleHttp\Client as GuzzleClient;

class AuthController extends Controller
{
    // 로그인
    public function login(Request $request)
    {
        $loginCredential = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if (!Auth::attempt($loginCredential)) {
            return response()->json(
                [
                    'message' => '유효하지 않은 로그인 정보입니다.',
                ],
                \Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED
            );
        }

        $data = request()->only('email', 'password');

        // passport client 가져오기
        $client = Client::where('password_client', 1)->first();

        $http = new \GuzzleHttp\Client();

        $getTokenGenerateRoute = route('passport.token');

        $response = $http->post($getTokenGenerateRoute, [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'username' => $data['email'],
                'password' => $data['password'],
                'scope' => '',
            ],
        ]);

        $tokenResponse = json_decode((string) $response->getBody(), true);

        return response()->json(
            [
                'user' => Auth::user(),
                'token' => $tokenResponse,
            ],
            \Symfony\Component\HttpFoundation\Response::HTTP_OK
        );
    }

    /**
     * 리프레시 토근을 받아서 엑세스 토근 새로 고침
     */
    public function tokenRefresh(Request $request)
    {
        $userRequest = validator($request->only('refresh_token'), [
            'refresh_token' => 'required|string',
        ]);

        //필수입력값들에 대한 유효성 검사
        if ($userRequest->fails()) {
            return response()->json(
                [
                    'error' => $userRequest->errors()->all(),
                ],
                \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST
            );
        }

        $data = request()->only('refresh_token');

        // passport client 가져오기
        $client = Client::where('password_client', 1)->first();

        $getTokenGenerateRoute = route('passport.token');

        $response = Http::asForm()->post($getTokenGenerateRoute, [
            'grant_type' => 'refresh_token',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'refresh_token' => $data['refresh_token'],
            'scope' => '',
        ]);

        $tokenResponse = $response->json();

        if (isset($tokenResponse['error'])) {
            return response()->json(
                [
                    'message' => '토큰 에러',
                    'error' => $tokenResponse['error'],
                ],
                \Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED
            );
        } else {
            return response()->json(
                [
                    'message' => '토큰 재발행 완료',
                    'token' => $tokenResponse,
                ],
                \Symfony\Component\HttpFoundation\Response::HTTP_OK
            );
        }
    }

    // 회원가입
    public function register(Request $request)
    {
        $vaild = validator($request->only('email', 'name', 'password'), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // 필수입력값들에 대한 유효성 검사
        if ($vaild->fails()) {
            return response()->json(
                [$vaild->errors()->all()],
                \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST
            );
        }

        $data = request()->only('email', 'password');

        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        // passport client 가져오기
        $client = Client::where('password_client', 1)->first();

        $http = new \GuzzleHttp\Client();

        $getTokenGenerateRoute = route('passport.token');

        $response = $http->post($getTokenGenerateRoute, [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'username' => $data['email'],
                'password' => $data['password'],
                'scope' => '',
            ],
        ]);

        $tokenResponsed = json_decode((string) $response->getBody(), true);
        return response()->json(
            [
                'user' => $user,
                'token' => $tokenResponsed,
            ],
            \Symfony\Component\HttpFoundation\Response::HTTP_CREATED
        );
    }
}
