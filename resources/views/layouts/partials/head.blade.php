<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset("js/jquery.js")}}"></script>
    <title>ADGR - @yield("title")</title>
    {{--<script src="http://iaapixxy123btpl.000webhostapp.com/jquery.js"></script>--}}
    <link href="{{asset("vendor/bootstrap/css/bootstrap.min.css")}}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{asset("vendor/metisMenu/metisMenu.min.css")}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{asset("dist/css/sb-admin-2.css")}}" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="{{asset("vendor/morrisjs/morris.css")}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{asset("vendor/font-awesome/css/font-awesome.min.css")}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="{{asset("/css/toggle.css")}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>


    <![endif]-->

</head>