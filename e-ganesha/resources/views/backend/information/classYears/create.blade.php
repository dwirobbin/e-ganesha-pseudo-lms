@extends('backend.core.main')

@section('title')
    {{ $title }}
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('class_years_create') }}
@endsection

@section('content')
    <div class="col-lg-13 my-3">
        <form action="{{ url('dashboard/admin/class-years/store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="inputYear" class="form-label">Tahun</label>
                <input type="text" id="inputYear" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <a href="{{ url('dashboard/admin/class-years') }}" class="btn btn-info" role="button">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">Tambah Angkatan Baru</button>
        </form>
    </div>
@endsection
