<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    /**
     * @OA\Post(
     *   path="/user/me",
     *   summary="유저 정보가져오기",
     *   description="유저 정보를 가져옵니다.",
     *   operationId="token",
     *   tags={"Users"},
     *   @OA\Response(
     *     response=200,
     *     description="Successful operation",
     *       @OA\JsonContent(
     *       @OA\Property(
     *       title="data",
     *       property="data",
     *       type="object",
     *       ref="#/components/schemas/User"
     *       ),
     *     ),
     *   ),
     *   @OA\Response(response="404",description="User not found"),
     *   security={{ "apiAuth": {} }}
     * )
     *
     * @param User $User
     * @return JsonResponse
     **/

    public function me()
    {
        if (Auth::user() == null) {
            return response()->json(
                [
                    'message' => 'User not found'
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json([
            'user' => Auth::user()
        ], Response::HTTP_OK);
    }

    /* 유저 아바타 정보 저장 */
    public function avatar(Request $request)
    {
        $character_info = $request->json()->all();
        Log::info("UserController::avatar" ,['character_info' => $character_info]);
        if (Auth::user() == null) {
            return response()->json(
                [
                    'message' => 'User not found'
                ],
                Response::HTTP_NOT_FOUND
            );
        }
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        $user->character_info = $character_info;
        $user->save();

        return response()->json([
            'message' => "유저 아바타 정보가 저장되었습니다."
        ], Response::HTTP_OK);
    }
}
