<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>


  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="all,follow">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <!--     'http://aac-project.herokuapp.com/ -->
  <!--   Custom font -->
<!--   HackerTimer js S-->

  <script src="{{ asset('/js/HackTimer.js') }}"></script>
  <!--   HackerTimer js E-->
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <!-- Bootstrap CSS-->
  <link rel="stylesheet" href="{{ asset('/distribution/vendor/bootstrap/css/bootstrap.min.css') }}">
  <!-- <link href="{{ asset("/bower_components/bootstrap/dist/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" /> -->
  <!-- Font Awesome CSS-->
  <link rel="stylesheet" href="{{ asset('/distribution/vendor/font-awesome/css/font-awesome.min.css') }}">
  <!-- Bootstrap Select-->
  <link rel="stylesheet" href="{{ asset('/distribution/vendor/bootstrap-select/css/bootstrap-select.min.css') }}">
  <!-- Price Slider Stylesheets -->
  <link rel="stylesheet" href="{{ asset('/distribution/vendor/nouislider/nouislider.css') }}">
  <!-- Custom font icons-->
  <link rel="stylesheet" href="{{ asset('/distribution/css/custom-fonticons.css') }}">
  <!-- Google fonts - Poppins-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700">
  <!-- owl carousel-->
  <link rel="stylesheet" href="{{ asset('/distribution/vendor/owl.carousel/assets/owl.carousel.css') }}">
  <link rel="stylesheet" href="{{ asset('/distribution/vendor/owl.carousel/assets/owl.theme.default.css') }}">
  <!-- theme stylesheet-->
  <link rel="stylesheet" href="{{ asset('/distribution/css/style.default.css') }}" id="theme-stylesheet">
  <!-- Custom stylesheet - for your changes-->
  <link rel="stylesheet" href="{{ asset('/distribution/css/custom.css') }}">
  <!-- Favicon-->
  <link rel="{{ asset('/distribution/shortcut icon" href="img/favicon.ico') }}">
  <!-- Modernizr-->
  <script src="{{ asset('/distribution/js/modernizr.custom.79639.js') }}"></script>
  <!-- Tweaks for older IEs--><!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->




  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">













</head>
<body>



  @include('layouts/header')
  @yield('content')
  @include('layouts/footer')





  <script src="{{ asset('/distribution/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('/distribution/vendor/popper.js/umd/popper.min.js') }}"> </script>
  <script src="{{ asset('/distribution/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('/distribution/vendor/jquery.cookie/jquery.cookie.js') }}"> </script>
  <script src="{{ asset('/distribution/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('/distribution/vendor/owl.carousel2.thumbs/owl.carousel2.thumbs.min.js') }}"></script>
  <script src="{{ asset('/distribution/vendor/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
  <script src="{{ asset('/distribution/vendor/nouislider/nouislider.min.js') }}"></script>
  <script src="{{ asset('/distribution/js/front.js') }}"></script>

  <!--     Custom Js start-->


  <script src="{{ asset('/js/application_global.js') }}"></script>











<!-- typeahead -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('/js/typehead/bootstrap3-typeahead.min.js') }}"></script>
<!-- typeahead -->
<!--     Custom Js end-->

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>




@yield('page-script')
</body>
</html>
