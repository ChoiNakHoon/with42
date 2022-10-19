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

    /**
     * @OA\Post(
     *   path="/user/register",
     *   summary="회원가입",
     *   description="회원가입",
     *   tags={"Users"},
     *  @OA\RequestBody(
     *    required=true,
     *    @OA\MediaType(
     *      mediaType="application/json",
     *      @OA\Schema(
     *          @OA\Property(
     *              property="email",
     *              type="string",
     *              ),
     *          @OA\Property(
     *              property="password",
     *              type="string",
     *              )
     *      )
     *    )
     *  ),
     *   @OA\Response(
     *     response=201,
     *     description="Succeeded",
     *       @OA\JsonContent(
     *       @OA\Property(
     *       title="user",
     *       property="user",
     *       type="object",
     *       ref="#/components/schemas/User"
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="User not found",
     *      @OA\JsonContent(
     *      @OA\Property(
     *          property="message",
     *          type="error message",
     *      ),
     *    ),
     * ),
     * )
     *
     * @param User $User
     * @return JsonResponse
     **/

    // 로그인
    // 회원가입
    public function register(Request $request)
    {
        $singUpData = $request->segments();
        info("AuthConroller", ["request" => $request]);
        info("AuthConroller", ["singUpData" => $singUpData]);
        info("AuthConroller", ["email" => $request->email, "password" => $request->password ]);
        $vaild = validator($request->only('email', 'password'), [
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
            'login_method' => 'email'
        ]);

        Auth::login($user, true);

        return response()->json(
            [
                'user' => $user,
            ],
            \Symfony\Component\HttpFoundation\Response::HTTP_CREATED
        );
    }

    /**
     * @OA\Post(
     *   path="/user/login",
     *   summary="로그인",
     *   description="로그인",
     *   tags={"Users"},
     *  @OA\RequestBody(
     *    required=true,
     *    @OA\MediaType(
     *      mediaType="application/json",
     *      @OA\Schema(
     *          @OA\Property(
     *              property="email",
     *              type="string",
     *              ),
     *          @OA\Property(
     *              property="password",
     *              type="string",
     *              )
     *      )
     *    )
     *  ),
     *   @OA\Response(
     *     response=201,
     *     description="Succeeded",
     *       @OA\JsonContent(
     *       @OA\Property(
     *       title="user",
     *       property="user",
     *       type="object",
     *       ref="#/components/schemas/User"
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="User not found",
     *      @OA\JsonContent(
     *      @OA\Property(
     *          property="message",
     *          type="string",
     *          example="유효하지 않은 로그인 정보입니다.",
     *      ),
     *    ),
     * ),
     * )
     *
     * @param User $User
     * @return JsonResponse
     **/

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

    /**
     * @OA\Get (
     *   path="/auth/token",
     *   summary="토큰 요청",
     *   description="로그인 이후 토큰 요청",
     *   tags={"Auth"},
     *      @OA\Response(
     *          response=200,
     *          description="응답성공",
     *      @OA\JsonContent(
     *          @OA\Property(
     *              property="message",
     *              type="string",
     *              example="토큰 생성 성공",
     *          ),
     *          @OA\Property(
     *              title="user",
     *              property="user",
     *              type="object",
     *              ref="#/components/schemas/User"
     *           ),
     *          @OA\Property(
     *              property="token",
     *              type="string",
     *              example="6d8a83ac57a3c392e1094335ff9eb2ad",
     *           ),
     *          @OA\Property(
     *              property="expires_at",
     *              type="string",
     *              example="2022-09-21 23:55:52",
     *           ),
     *      ),
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="User not found",
     *      @OA\JsonContent(
     *          @OA\Property(
     *              property="message",
     *              type="string",
     *              example="User not found",
     *          ),
     *      ),
     *    ),
     * )
     *
     **/

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


    /**
     * @OA\Get (
     *   path="/user/logout",
     *   summary="유저 로그아웃",
     *   description="로그인 이후 로그아웃 요청",
     *   tags={"Users"},
     *      @OA\Response(
     *          response=200,
     *          description="응답성공",
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="User not found",
     *      @OA\JsonContent(
     *          @OA\Property(
     *              property="message",
     *              type="string",
     *              example="User not found",
     *          ),
     *      ),
     *    ),
     * security={{ "apiAuth": {} }}
     * )
     *
     **/
    public function logout() {
        $user = Auth::User();

        if ($user == null) {
            return response()->json(
                [
                    'message' => 'User not found'
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        Auth::logout();

        return response()->json(
            [
                'message' => '로그 아웃',
            ],
            Response::HTTP_OK
        );
    }
}
