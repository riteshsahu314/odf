<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Online Discussion Forum</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .header {
                display: flex;
                padding: 1rem 2rem;
                align-items: center;
                justify-content: space-between;
            }

            .content {
                padding: 3rem;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .title {
                font-size: 5rem;
                margin: 1rem 0;
            }

            .links {
                display: flex;
                align-items: center;
            }

            .links > a   {
                color: #636b6f;
                padding: 0 8px;
                font-size: 1.1rem;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .intro-image {
                width: 50vh;
                margin: auto;
            }

            .intro-image img{
                width: 100%;
            }

            .btn-intro {
                height: 48px;
                line-height: 48px;
                font-size: 18px;
                padding: 0 65px 0 65px;
                font-weight: 600;
                background: #0069FF;
                color: #FFFFFF;
                text-align: center;
                cursor: pointer;
                display: inline-block;
                border-radius: 4px !important;
                text-decoration: none;
            }

            .btn-intro:hover {
                background: #0040ff;
            }

            .logo-img {
                height: 2.4rem;
                margin-right: 1rem;
            }

            .logo-text {
                text-decoration: none;
                font-weight: 600;
                font-size: 1rem;
                color: rgb(111, 35, 115) !important;
            }
        </style>
    </head>
    <body>
        <header class="header">
            <div class="links">
                <a href="{{ url('/') }}">
                    <img src="{{ Storage::url('images/logo.svg') }}" alt="Logo" class="logo-img">
                </a>
                <a href="{{ url('/') }}" class="logo-text">ODF</a>
            </div>

            @if (Route::has('login'))
                <div class="links">
                    @auth
                        <a href="{{ url('/threads') }}">Forum</a>
                        {{--                        <a href="{{ url('/home') }}">Home</a>--}}
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </header>

        <div class="content">
            <div class="intro-image">
                <img src="{{ Storage::url('images/discussion.png') }}" alt="Discussion">
            </div>

            <h1 class="title">
                Online Discussion Forum
            </h1>

            <div>
                <a href="/threads" class="btn-intro">
                    Go to Forum
                </a>
            </div>
        </div>
    </body>
</html>
