<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content=""/>
    <meta property="og:title" content="툰빌 메타버스">
    <meta name="robots" content="all, index, follow"/>
    <meta name="googlebot" content="all, index, follow"/>
    <meta name="NaverBot" content="All"/>
    <meta name="NaverBot" content="index,follow"/>
    <meta name="Yeti" content="All"/>
    <meta name="Yeti" content="index,follow"/>
    <link rel="canonical" href="{{ url(Request::url()) }}"/>
    <title>@yield('title', '피플앤스토리')</title>   <!--  타이틀 자리에 아무것도 안넣을 시 기본값으로 '스마트한 꽃 주문 플디!'를 띄움 -->

    <!-- CSS -->
    {{-- common--}}
    <link rel="stylesheet" type="text/css" href="/css/common.css">
    {{-- main --}}
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    {{-- flatpickr  --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_green.css">
    {{-- tailwind --}}
    <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet" type="text/css">

    <!--Font awesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">

    {{-- starRating--}}
    <link href="{{ URL::asset('css/star-rating-svg.css')}}?v=0.1" rel="stylesheet" type="text/css">

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <!--Javascript-->

    {{-- starRating--}}
    <script src="{{ URL::asset('js/jquery.star-rating-svg.js')}}"></script>
    {{-- flatpickr  --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/ko.js"></script>
    {{-- ionicons --}}
    <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>

    {{-- cookie.js --}}
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>

    {{-- Swiper--}}
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

    <!--daum Api-->
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=d696e8e0fb97a5250c4a74acf624a05c&libraries=services"></script>

    <!--SweetAlert-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body class="overflow-y overflow-x-hidden">
<div class="lg:w-1/3 mx-auto overflow-x-hidden relative">
    @yield('content')
</div>
@stack('js')
@yield('js')
</body>
</html>
