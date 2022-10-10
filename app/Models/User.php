<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/** @OA\Schema(
 *     schema="User",
 *     required={"email", "password"},
 *     @OA\Property(property="id",type="integer",format="int32"),
 *     @OA\Property(property="name",type="string"),
 *     @OA\Property(property="nickname",type="string",format="string"),
 *     @OA\Property(property="email",type="string"),
 *     @OA\Property(property="email_verified_at",type="string",format="date-time"),
 *     @OA\Property(property="profile_url",type="string"),
 *     @OA\Property(property="password",type="string"),
 *     @OA\Property(property="login_method",type="string"),
 *     @OA\Property(property="phone_number",type="string"),
 *     @OA\Property(property="kakao_token",type="string"),
 *     @OA\Property(property="naver_token",type="string"),
 *     @OA\Property(property="facebook_token",type="string"),
 *     @OA\Property(property="google_token",type="string"),
 *     @OA\Property(property="receive_push",type="int"),
 *     @OA\Property(property="is_active",type="int"),
 *     @OA\Property(property="stop_start_at",type="string",format="date-time"),
 *     @OA\Property(property="stop_end_at",type="string",format="date-time"),
 *     @OA\Property(property="last_login_at",type="string",format="date-time"),
 *     @OA\Property(property="device_type",type="string"),
 *     @OA\Property(property="user_level",type="string"),
 *     @OA\Property(property="character_info",type="string",format="json"),
 *     @OA\Property(property="remember_token",type="string"),
 *     @OA\Property(property="created_at",type="string",format="date-time"),
 *     @OA\Property(property="updated_at",type="string",format="date-time"),
 *     @OA\Property(property="deleted_at",type="string",format="date-time"),
 * )
 *
 * @OA\Schema(
 *   schema="Users",
 *   title="Users",
 *   @OA\Property(title="data",property="data",type="array",
 *     @OA\Items(type="object",ref="#/components/schemas/User"),
 *   )
 * )
 * @OA\Parameter(
 *      parameter="User--id",
 *      in="path",
 *      name="User_id",
 *      required=true,
 *      description="Id of User",
 *      @OA\Schema(
 *          type="integer",
 *          example="1",
 *      )
 * ),
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'naver_id',
        'kakao_id',
        'facebook_id',
        'google_id',
        'profile_url',
        'login_method',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
