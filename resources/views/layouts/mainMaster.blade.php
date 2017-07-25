<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>
            @yield('title') :: Pendo Admin - Your financial convenience home
        </title>
        <meta name="description" content="Quick Loans enables you get your loan quickly." />
        <meta name="keywords" content="loans, kenya" />
        <meta name="author" content="Nikk"/>
        
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon -->
        <link rel="shortcut icon" href="/favicon.ico">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        
    </head>
    
    <body>
        
        <!-- Preloader -->
        <div class="preloader-it">
           <div class="la-anim-1"></div>
        </div>
        <!-- /Preloader -->


        @yield('css_header')


        @include('layouts.scriptsHeader')


        <div id="app">

            @yield('main_content')

        </div>
        

        @include('layouts.scriptsFooter')


        @yield('page_scripts')
        

    </body>

</html>
