<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="https://kit.fontawesome.com/3723f06c66.js" crossorigin="anonymous"></script>
    <!-- trix -->
    <script src="{{ asset('js/trix.js') }}" ></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <!-- trix -->
    <link href="{{ asset('css/trix.css')}}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/original.css')}}" rel="stylesheet">
    <!-- multiselect CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
 
    <!-- datepicker -->
    <!-- Tempus Dominus CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0/css/tempusdominus-bootstrap-4.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />


</head>
<body>
    <div id="app">
        @component('components.dashboard.header')
        @endcomponent
        <div class="row">
            @if(Auth::guard('admins')->check())
            <div class="col-3 mt-3">
               @component('components.dashboard.sidebar')
               @endcomponent
           </div>
           @endauth
            <div class="col">
                <main class="py-4 mb-5">
                    <script>
                        $(function() {
                            $('.loadbtn').on('click', function() {
                                $('.loadbtn').hide();
                                $('#loading').show();
                            });
                        });            
                    </script>
                    <!-- ローディング画面 -->
                    <div id="loading">
                        <div class="spinner"></div>
                    </div>
                    @yield('content')
                </main>
                @component('components.footer')
                @endcomponent
            </div>
        </div>
    </div>
</body>
</html>