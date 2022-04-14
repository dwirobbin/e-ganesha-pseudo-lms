@extends('backend.core.main')

@section('title')
    {{ $title }}
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('student_create') }}
@endsection

@section('content')
    <div class="col-lg-13 my-3">
        <form action="{{ route('students.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="inputName" class="form-label">Nama</label>
                <input type="text" id="inputName" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputTtl" class="form-label">Tempat, Tgl Lahir</label>
                <input type="text" id="inputTtl" name="ttl" class="form-control @error('ttl') is-invalid @enderror"
                    value="{{ old('ttl') }}">
                @error('ttl')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputAddress" class="form-label">Alamat</label>
                <input type="text" id="inputAddress" name="address"
                    class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}">
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputTlpNumber" class="form-label">Nomor Hp</label>
                <input type="number" id="inputTlpNumber" name="telephone_number"
                    class="form-control @error('telephone_number') is-invalid @enderror"
                    value="{{ old('telephone_number') }}">
                @error('telephone_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="email" id="inputEmail" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputPassword" class="form-label">Password</label>
                <input type="password" id="inputPassword" name="password"
                    class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputReligion" class="form-label">Agama</label>
                <select name="religion_id" class="form-select @error('religion_id') is-invalid @enderror">
                    <option value="" disabled selected>=== Pilih Agama ===</option>
                    @foreach ($religions as $religion)
                        @if (old('religion_id') == $religion->id)
                            <option value="{{ $religion->id }}" selected>
                                {{ $religion->name }}
                            </option>
                        @else
                            <option value="{{ $religion->id }}">
                                {{ $religion->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('religion_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputGender" class="form-label">Jenis Kelamin</label>
                <select name="gender_id" class="form-select @error('gender_id') is-invalid @enderror">
                    <option value="" disabled selected>=== Pilih Jenis Kelamin ===</option>
                    @foreach ($genders as $gender)
                        @if (old('gender_id') == $gender->id)
                            <option value="{{ $gender->id }}" selected>
                                {{ $gender->name }}
                            </option>
                        @else
                            <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                        @endif
                    @endforeach
                </select>
                @error('gender_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputClassYears" class="form-label">Tahun Angkatan</label>
                <select name="class_year_id" class="form-select @error('class_year_id') is-invalid @enderror">
                    <option value="" disabled selected>=== Pilih Tahun Angkatan ===</option>
                    @foreach ($classYears as $classYear)
                        @if (old('class_year_id') == $classYear->id)
                            <option value="{{ $classYear->id }}" selected>
                                {{ $classYear->name }}
                            </option>
                        @else
                            <option value="{{ $classYear->id }}">
                                {{ $classYear->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('class_year_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputRole" class="form-label">Role</label>
                <select name="role_id" class="form-select">
                    <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                </select>
            </div>
            <a href="{{ route('students.index') }}" class="btn btn-info" role="button">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">Tambah Murid</button>
        </form>
    </div>
@endsection
