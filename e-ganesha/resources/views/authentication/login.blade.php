@extends('frontend.core.main')

@section('content')
    <div class="container col-lg-5">

        @if (Session::has('loginError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ Session::get('loginError') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="bungkus">
            <div class="luar-log">
                <h2>Login</h2>
                <form action="{{ url('login') }}" method="POST">
                    @csrf
                    <div class="email-input">
                        <h4>Email</h4>
                        <input class="placeholder-email @error('email') is-invalid @enderror" id="email" type="email"
                            placeholder="Masukkan Email Anda" name="email" value="{{ old('email') }}" autofocus />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="password-input">
                        <h4>Password</h4>
                        <input class="placeholder-pw @error('password') is-invalid @enderror" id="password" type="password"
                            placeholder="Masukkan Password Anda" name="password" />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="tombol-submit">
                        <button class="btn btn-submit" type="submit">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
