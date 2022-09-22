<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\{Auth, Http};
use Laravel\Passport\Client;

class AuthController extends Controller
{
    // 로그인
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
                [
                    'message' => $vaild->errors()->all()
                ],
                \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST
            );
        }

        $data = request()->only('email', 'password');

        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        Auth::login($user, true);

        return response()->json(
            [
                'user' => $user,
            ],
            \Symfony\Component\HttpFoundation\Response::HTTP_CREATED
        );
    }



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
                Response::HTTP_UNAUTHORIZED
            );
        }

        $data = request()->only('email', 'password');

        return response()->json(
            [
                'user' => Auth::user(),
            ],
            Response::HTTP_CREATED
        );
    }



    public function createToken()
    {

        $user = Auth::user();

        $tokenResponse = $user->createToken('with42.kr');
        //유저 데이터가 없다면
        if ($user == null) {
            return response()->json(
                [
                    'message' => 'User not found'
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json(
            [
                'message' => '토큰 생성 성공',
                'user' => Auth::user(),
                'token' => $tokenResponse->accessToken,
                'expires_at' => Carbon::parse(
                    $tokenResponse->token->expires_at
                )->toDateTimeString()
            ],
            Response::HTTP_OK
        );
    }
}
