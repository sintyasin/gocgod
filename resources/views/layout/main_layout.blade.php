<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GoC GoD</title>

    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
    <!-- fontawesomecss -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/font-awesome.min.css') }}">
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/style.css') }}">
    <!-- revolution banner css settings -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/settings.css') }}">
    <!-- mobilemenu css -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/meanmenu.css') }}">
    <!-- responsive css -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/responsive.css') }}">
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.png') }}">

    <!-- fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,500' rel='stylesheet' type='text/css'>
</head>
<body>

    @include('include.navigation')

    <div class="content">
        <div class="container">
            @yield('content')
        </div>
    </div>
    <footer>
        @include('include.footer')
    </footer>
    
    <!-- All js Files Here -->
    <!-- jquery-1.11.3 -->
    <script src="{{ URL::asset('assets/js/jquery-1.11.3.min.js') }}"></script>
    <!-- bootstrap js -->
    <script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
    <!-- revolution js -->
    <script type="text/javascript" src="{{ URL::asset('assets/lib/rs-plugin/js/jquery.themepunch.tools.min.js') }}"></script>   
    <script type="text/javascript" src="{{ URL::asset('assets/lib/rs-plugin/js/jquery.themepunch.revolution.min.js') }}"></script>
    <script src="{{ URL::asset('assets/lib/rs-plugin/rs.home.js') }}"></script>
    <!-- search-box js -->
    <script src="{{ URL::asset('assets/js/search-box.js') }}"></script>
    <!-- scrollUp js -->
    <script src="{{ URL::asset('assets/js/jquery.scrollUp.js') }}"></script>
    <!-- mobilemenu js -->
    <script src="{{ URL::asset('assets/js/jquery.meanmenu.js') }}"></script>
    <!-- main js -->
    <script src="{{ URL::asset('assets/js/main.js') }}"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>