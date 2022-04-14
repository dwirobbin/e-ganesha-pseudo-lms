<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') . ' | ' . $title }}</title>

    {{-- title icon --}}
    <link rel="shortcut icon" href="{{ asset('backend/img/icons/icon-48x48.png') }}" />

    {{-- homePage --}}
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/homepage.css') }}" />

    <link rel="stylesheet" href="{{ asset('frontend/css/dashboard-siswa.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/profil-siswa.css') }}">
    <script src="https://kit.fontawesome.com/d47afdaaec.js" crossorigin="anonymous"></script>

    {{-- authentication --}}
    <link rel="stylesheet" href="{{ asset('frontend/css/reglog.css') }}">

    {{-- sidebar --}}
    <link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    {{-- Summernote --}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100">

    @include('frontend.partials.header')

    @yield('content')

    @include('frontend.partials.footer')

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    {{-- SweetAlert --}}
    @include('sweetalert::alert')

    @stack('scripts')
</body>

</html>
