<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\DemoMail;

class MailController extends Controller
{
    // TODO 유저 설정에서 이메일 인증 시 유저 인증
    public function index()
    {
        $mailData = [
            'title' => '이메일 인증',
            'body' => '인증번호를 입력해주세요.',
            'authentication_number' => '1234',
        ];
    }
}
