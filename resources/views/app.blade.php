<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Smart Edu du học hàn quốc.">
    <meta name="google-site-verification" content="yj1x6SGJRnxEqoaHXndBbDlvseWoVRMAzxteRSuu23U" />
    <!-- Meta Description -->
    <meta name="description" content="SMART EDU - Cổng thông tin du học Hàn Quốc. Khám phá các trường đại học hàng đầu, tìm kiếm học bổng và nhận hướng dẫn từ chuyên gia. Bắt đầu hành trình du học của bạn ngay hôm nay với SMART EDU.">

    <!-- Other Meta Tags -->
    <meta name="keywords" content="du học Hàn Quốc, SMART EDU, học bổng, hướng dẫn du học, trường đại học Hàn Quốc">
    <meta name="author" content="SMART EDU">

    <!-- Open Graph Meta Tags for social media -->
    <meta property="og:title" content="SMART EDU - Du Học Hàn Quốc">
    <meta property="og:description" content="SMART EDU - Cổng thông tin du học Hàn Quốc. Khám phá các trường đại học hàng đầu, tìm kiếm học bổng và nhận hướng dẫn từ chuyên gia. Bắt đầu hành trình du học của bạn ngay hôm nay với SMART EDU.">
    <meta property="og:image" content="https://smartedu.com.vn/storage/uploads/images/ZEAtvCQmGrHS2fzmDHTifv7AF3rxdg4sjZ69ZePF.png">
    <meta property="og:url" content="https://smartedu.com.vn">
    <meta property="og:type" content="website">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="SMART EDU - Du Học Hàn Quốc">
    <meta name="twitter:description" content="SMART EDU - Cổng thông tin du học Hàn Quốc. Khám phá các trường đại học hàng đầu, tìm kiếm học bổng và nhận hướng dẫn từ chuyên gia. Bắt đầu hành trình du học của bạn ngay hôm nay với SMART EDU.">
    <meta name="twitter:image" content="https://smartedu.com.vn/storage/uploads/images/ZEAtvCQmGrHS2fzmDHTifv7AF3rxdg4sjZ69ZePF.png">

    <!-- Canonical Link -->
    <link rel="canonical" href="https://smartedu.com.vn">


    <!-- Favicon -->
    @vite('resources/js/app.js')
    <!-- favicon -->
    {{--    <link rel="apple-touch-icon" href="apple-touch-icon.html">--}}

    {{--admin--}}
    <!-- Custom fonts for this template -->
    <link href="{{asset('assets/admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{asset('assets/admin/css/sb-admin-2.min.css')}}" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="{{asset('assets/admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    {{--admin--}}


    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/logo.png')}}">
    <!-- Bootstrap v4.4.1 css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}">
    <!-- font-awesome css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/font-awesome.min.css')}}">
    <!-- flaticon css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/fonts/flaticon.css')}}">
    <!-- animate css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/animate.css')}}">
    <!-- owl.carousel css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/owl.carousel.css')}}">
    <!-- off canvas css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/off-canvas.css')}}">
    <!-- magnific popup css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/magnific-popup.css')}}">
    <!-- Main Menu css -->
    <link rel="stylesheet" href="{{asset('assets/css/rsmenu-main.css')}}">
    <!-- spacing css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/rs-spacing.css')}}">
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/style.css')}}">
    <!-- responsive css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/responsive.css')}}">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

    <title>SMART EDU</title>
</head>
<body>
<div id="app"></div>
<!-- Messenger Plugin chat Code -->
<div id="fb-root"></div>

{{--<!-- Your Plugin chat code -->--}}
{{--<div id="fb-customer-chat" class="fb-customerchat">--}}
{{--</div>--}}

{{--<script>--}}
{{--    var chatbox = document.getElementById('fb-customer-chat');--}}
{{--    chatbox.setAttribute("page_id", "101712082566367");--}}
{{--    chatbox.setAttribute("attribution", "biz_inbox");--}}
{{--</script>--}}

{{--<!-- Your SDK code -->--}}
{{--<script>--}}
{{--    window.fbAsyncInit = function() {--}}
{{--        FB.init({--}}
{{--            xfbml            : true,--}}
{{--            version          : 'v17.0'--}}
{{--        });--}}
{{--    };--}}
{{--    (function(d, s, id) {--}}
{{--        var js, fjs = d.getElementsByTagName(s)[0];--}}
{{--        if (d.getElementById(id)) return;--}}
{{--        js = d.createElement(s); js.id = id;--}}
{{--        js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';--}}
{{--        fjs.parentNode.insertBefore(js, fjs);--}}
{{--    }(document, 'script', 'facebook-jssdk'));--}}
{{--</script>--}}

<script src="{{ asset('assets/js/modernizr-2.8.3.min.js') }}"></script>
<!-- jquery latest version -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<!-- Bootstrap v4.4.1 js -->
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<!-- op nav js -->
<script src="{{ asset('assets/js/jquery.nav.js') }}"></script>
<!-- isotope.pkgd.min js -->
<script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
<!-- owl.carousel js -->
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<!-- wow js -->
<script src="{{ asset('assets/js/wow.min.js') }}"></script>
<!-- Skill bar js -->
<script src="{{ asset('assets/js/skill.bars.jquery.js') }}"></script>
<!-- imagesloaded js -->
<script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
<!-- counter top js -->
<script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
<!-- magnific popup js -->
<script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
<!-- contact form js -->
<script src="{{ asset('assets/js/contact.form.js') }}"></script>
<!-- main js -->
<script src="{{ asset('assets/js/main.js') }}"></script>

{{--admin--}}
<!-- Bootstrap core JavaScript-->
<script src="{{asset('assets/admin/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('assets/admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset('assets/admin/js/sb-admin-2.min.js')}}"></script>

<!-- Page level plugins -->
<script src="{{asset('assets/admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/admin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<!-- Page level custom scripts -->
<script src="{{asset('assets/admin/js/demo/datatables-demo.js')}}"></script>
{{--admin--}}
</body>
</html>
