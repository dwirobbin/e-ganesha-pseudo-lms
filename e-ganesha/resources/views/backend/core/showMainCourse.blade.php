<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') . ' | ' . $title }}</title>

    {{-- homePage --}}
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/homepage.css') }}" />

    <link rel="stylesheet" href="{{ asset('frontend/css/dashboard-siswa.css') }}">
    <script src="https://kit.fontawesome.com/d47afdaaec.js" crossorigin="anonymous"></script>

    {{-- authentication --}}
    <link rel="stylesheet" href="{{ asset('frontend/css/reglog.css') }}">

    {{-- sidebar --}}
    <link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    {{-- Font Link --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous">
    </script>
</head>

<body class="d-flex flex-column min-vh-100">

    @include('frontend.partials.header')

    {{-- @yield('content') --}}

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            @include('backend.partials.showSidebar')
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    {{-- <h2 class="mt-2">
                        @yield('title')
                    </h2>
                    <nav style="--bs-breadcrumb-divider: '>';">
                        @yield('breadcrumbs')
                    </nav> --}}
                    @yield('content')
                </div>
            </main>
            {{-- @include('frontend.partials.footer') --}}
        </div>
    </div>

    @include('frontend.partials.footer')

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    {{-- jquery CDN --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- My Js --}}
    <script src="{{ asset('backend/js/scripts.js') }}"></script>

    @stack('scripts')
</body>

</html>
