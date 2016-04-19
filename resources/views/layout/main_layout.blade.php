<!DOCTYPE html>
<html>
    <head>
        <title>GoC GoD</title>

        <!-- css -->
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
        <!-- glyphicon -->
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/bootstrap.css') }}">
        <!-- fontawesomecss -->
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/font-awesome.min.css') }}">
        <!-- style css -->
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/style.css') }}">


        <!-- fonts -->
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="header_top">
            @include('include.navigation')
        </div>
        <div class="content">
            <div class="container">
                @yield('content')
            </div>
        </div>
        <footer>
            @include('include.footer')
        </footer>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </body>
</html>