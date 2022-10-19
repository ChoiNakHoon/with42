<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment("유저 이름");
            $table->string('nickname')->nullable()->comment("유저 아이디");
            $table->string('email')->comment('유저 계정 아이디');
            $table->timestamp('email_verified_at')->nullable()->comment('유저 계정 인증 시간');
            $table->string('profile_url')->nullable()->comment('유저 계정 이미지');
            $table->string('password')->comment('유저 계정 비밀번호');
            $table->string('login_method')->nullable()->comment('소셜 로그인');
            $table->string('phone_number', 20)->nullable()->comment('유저 핸드폰번호');
            $table->string('kakao_token')->nullable()->comment('카카오 API 회원 가입 토큰');
            $table->string('naver_token')->nullable()->comment('네이버 API 회원 가입 토큰');
            $table->string('facebook_token')->nullable()->comment('페이스북 API 회원 가입 토큰');
            $table->string('google_token')->nullable()->comment('구글 API 회원 가입 토큰');
            $table->integer('receive_push')->default(1)->comment('모든 푸신 수신 여부, 0: 미수신, 1: 수신');
            $table->integer('is_active')->default(0)->comment('유저 정지 여부, 0: 정지, 1:미정지');
            $table->dateTime('stop_start_at')->nullable()->comment('유저 정지 시각 시간');
            $table->dateTime('stop_end_at')->nullable()->comment('유저 정지 종료 시간');
            $table->dateTime('last_login_at')->nullable()->comment('최종 로그인 시간');
            $table->string('device_type')->nullable()->comment('디바이스 종류, android:안드로이드, ios:아이폰, console:콘솔, pc:피시, other:기타');
            $table->string('user_level')->nullable()->comment('유저 레벨 user, admin, partner');
            $table->json('character_info')->nullable()->comment('캐릭터 아바타 정보');
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
