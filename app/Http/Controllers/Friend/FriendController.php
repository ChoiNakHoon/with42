<?php

namespace App\Http\Controllers\Friend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{

    /* 친구 리스트 */
    public function list()
    {

        if (!Auth::user()) {
            return response()->json(
                [
                    'message' => '유효하지 않은 로그인 정보입니다.',
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }

        $player_id = Auth::user()->id;

        $friend_list = Friend::where(
            [
                ['player_id', $player_id],
                ['status', '<>', 'delete']
            ]
        )->orWhere('friend_id', $player_id)->get();

        if ($friend_list->isEmpty()) {
            return response()->json(
                [
                    'message' => '친구 목록이 없습니다.'
                ],
                Response::HTTP_NOT_FOUND
            );
        } else {
            return response()->json(
                [
                    'friend_list' => $friend_list
                ],
                Response::HTTP_OK
            );
        }
    }

    /* 친구 추가 */
    public function add(Request $request)
    {
        if (!Auth::user()) {
            return response()->json(
                [
                    'message' => '유효하지 않은 로그인 정보입니다.',
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }

        $player_id = Auth::user()->id;
        $friend_id = $request->friend_id;

        if ($player_id != null and $friend_id != null) {
            $friend = new Friend;
            $friend->player_id = $player_id;
            $friend->friend_id = $friend_id;
            $friend->status = "add";
            $friend->save();


            $friend_info = User::where('id', $friend_id)->first();
            $friend_name = $friend_info->nickname;

            return response()->json(
                [
                    'friend' => $friend,
                    'message' => "{$friend_name}에게 친구 요청을 보냈습니다.",
                ],
                Response::HTTP_OK
            );
        } else {
            return response()->json(
                [
                    'message' => '유저 아이디 또는 친구 아이디를 찾을 수 없습니다.',
                ],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /* 친구 수락 */
    public function accept(Request $request)
    {
        if (!Auth::user()) {
            return response()->json(
                [
                    'message' => '유효하지 않은 로그인 정보입니다.',
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }

        $requested_user_id = $request->requested_user_id;
        $my_user_id = Auth::user()->id;

        if ($friend = Friend::where(
            [
                ['player_id', $requested_user_id],
                ['friend_id', $my_user_id]
            ])->first()) {

            $friend_info = User::where('id', $requested_user_id)->first();
            $friend_name = $friend_info->nickname;

            if ($friend->status == 'accept') {
                return response()->json(
                    [
                        'friend' => $friend,
                        'message' => "{$friend_name}님의 친구 요청을 이미 수락하였습니다.",
                    ],
                    Response::HTTP_ACCEPTED
                );
            }

            $friend->status = 'accept';
            $friend->save();

            return response()->json(
                [
                    'friend' => $friend,
                    'message' => "{$friend_name}님의 친구 요청을 수락하였습니다.",
                ],
                Response::HTTP_OK
            );
        } else {
            return response()->json(
                [
                    'message' => '유저 아이디 또는 친구 아이디를 찾을 수 없습니다.',
                ],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /* 친구 수락 */
    public function reject(Request $request)
    {
        if (!Auth::user()) {
            return response()->json(
                [
                    'message' => '유효하지 않은 로그인 정보입니다.',
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }

        $requested_user_id = $request->requested_user_id;

        $my_user_id = Auth::user()->id;

        if ($friend = Friend::where(
            [
                ['player_id', $requested_user_id],
                ['friend_id', $my_user_id]
            ])->first()) {

            $friend_info = User::where('id', $requested_user_id)->first();
            $friend_name = $friend_info->nickname;

            if ($friend->status == 'reject') {
                return response()->json(
                    [
                        'friend' => $friend,
                        'message' => "{$friend_name}님의 친구 요청을 이미 거절한 상태입니다..",
                    ],
                    Response::HTTP_ACCEPTED
                );
            }

            $friend->status = 'reject';
            $friend->save();

            return response()->json(
                [
                    'friend' => $friend,
                    'message' => "{$friend_name}님의 친구 요청을 거절하였습니다.",
                ],
                Response::HTTP_OK
            );
        } else {
            return response()->json(
                [
                    'message' => '유저 아이디 또는 친구 아이디를 찾을 수 없습니다.',
                ],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /* 친구 삭제 */
    public function del(Request $request)
    {
        if (!Auth::user()) {
            return response()->json(
                [
                    'message' => '유효하지 않은 로그인 정보입니다.',
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }

        $player_id = Auth::user()->id;

        $friend_id = $request->friend_id;

        if ($friend = Friend::where(
            [
                ['player_id', $player_id],
                ['friend_id', $friend_id]
            ])->first()) {
            $friend_info = User::where('id', $friend_id)->first();
            $friend_name = $friend_info->nickname;

            if ($friend_info->status == 'delete') {
                return response()->json(
                    [
                        'friend' => $friend,
                        'message' => "이미 친구가 삭제 되었습니다.",
                    ],
                    Response::HTTP_ACCEPTED
                );
            } else {
                $friend->status = 'delete';
                $friend->save();

                return response()->json(
                    [
                        'friend' => $friend,
                        'message' => "{$friend_name}님의 삭제하였습니다.",
                    ],
                    Response::HTTP_OK
                );
            }
        } else {
            return response()->json(
                [
                    'message' => '유저 아이디 또는 친구 아이디를 찾을 수 없습니다.',
                ],
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
