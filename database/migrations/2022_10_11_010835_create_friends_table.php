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
        Schema::create('friends', function (Blueprint $table) {
            $table->id();
            $table->integer('player_id')->comment('플레이어 아이디');
            $table->integer('friend_id')->comment('플레이어와 연동된 아이디');
            $table->string('status', 10)->comment('친구 상태값 add - 친구 추가, delete - 친구 삭제, accept - 친구 수락, reject - 친구 거절');
            $table->softDeletes();
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
        Schema::dropIfExists('friends');
    }
};
