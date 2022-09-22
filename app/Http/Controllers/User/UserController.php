<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * @OA\Post(
     *   path="/user/me/",
     *   summary="Show a Product from his Id",
     *   description="Show a Product from his Id",
     *   operationId="showProduct",
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
     *   @OA\Response(response="404",description="Product not found"),
     * )
     *
     * @param Product $Product
     * @return JsonResponse
     */
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
}
