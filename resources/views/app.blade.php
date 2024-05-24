<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/js/app.js')
    <!-- favicon -->
    {{--    <link rel="apple-touch-icon" href="apple-touch-icon.html">--}}
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



    {{--admin--}}
    <!-- third party css -->
    <link href="{{asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/datatables.net-select-bs5/css//select.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <!-- App css -->

    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- icons -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    {{--admin--}}

    <title>Document</title>
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
<!-- Vendor -->
<script src="{{asset('admin/assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/node-waves/waves.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/waypoints/lib/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/jquery.counterup/jquery.counterup.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/feather-icons/feather.min.js')}}"></script>

<!-- third party js -->
<script src="{{asset('admin/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/datatables.net-select/js/dataTables.select.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
<!-- third party js ends -->

<!-- Datatables init -->
<script src="{{asset('admin/assets/js/pages/datatables.init.js')}}"></script>

<!-- App js -->
<script src="{{asset('admin/assets/js/app.min.js')}}"></script>
{{--admin--}}

</body>
</html>
