@extends('layout')

@section('content')
    <div class="flex flex-col w-full bg-gray-100 h-screen mb-20">
        <div class="w-full px-4 pb-4 h-20 bg-white">
            <div class="header text-center w-full h-16 pt-4 bg-white font-semibold">
                <p class="text-lg">계정을 등록해주시거나 로그인해주세요.</p>
            </div>
        </div>
        <div class="w-full px-4 mt-4 pb-4 h-full bg-white">
            <div class="flex flex-wrap w-full justify-center mx-auto mt-4 bg-white h-auto">
                <div class="flex items-center justify-center h-20 w-2/3">
                    <a href="/social/naver" class="flex px-2 w-full justify-center items-center w-full h-12 rounded-lg btnkakao no-animation">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                            <path fill="#050101" fill-rule="evenodd" d="M10 2C5.03 2 1 5.13 1 8.989c0 2.4 1.558 4.516 3.932 5.775l-.999 3.667c-.088.324.28.582.564.394l4.376-2.904c.37.036.745.057 1.127.057 4.97 0 9-3.13 9-6.989 0-3.86-4.03-6.99-9-6.99"/>
                        </svg>
                        <span class="pl-2"> 네이버로 시작하기</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="w-full px-4 mt-4 pb-4 h-full bg-white">
            <div class="flex flex-wrap w-full justify-center mx-auto mt-4 bg-white h-auto">
                <div class="flex items-center justify-center h-20 w-2/3">
                    <a href="/social/kakao" class="flex px-2 w-full justify-center items-center w-full h-12 rounded-lg btnkakao no-animation">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                            <path fill="#050101" fill-rule="evenodd" d="M10 2C5.03 2 1 5.13 1 8.989c0 2.4 1.558 4.516 3.932 5.775l-.999 3.667c-.088.324.28.582.564.394l4.376-2.904c.37.036.745.057 1.127.057 4.97 0 9-3.13 9-6.989 0-3.86-4.03-6.99-9-6.99"/>
                        </svg>
                        <span class="pl-2"> 카카오로 시작하기</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
{{--    @include('component.bottom_navigation')--}}
@endsection
