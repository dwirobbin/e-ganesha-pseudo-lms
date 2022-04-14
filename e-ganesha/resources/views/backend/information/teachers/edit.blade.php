@extends('backend.core.main')

@section('title')
    {{ $title }}
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('teacher_edit', $teacher) }}
@endsection

@section('content')
    <div class="col-lg-13 my-3">
        <form action="{{ route('teachers.update', $teacher->name) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="mb-3">
                <label for="inputName" class="form-label">Nama</label>
                <input type="text" id="inputName" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $teacher->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputTtl" class="form-label">Tempat, Tgl Lahir</label>
                <input type="text" id="inputTtl" name="ttl" class="form-control @error('ttl') is-invalid @enderror"
                    value="{{ old('ttl', $teacher->ttl) }}">
                @error('ttl')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputAddress" class="form-label">Alamat</label>
                <input type="text" id="inputAddress" name="address"
                    class="form-control @error('address') is-invalid @enderror"
                    value="{{ old('address', $teacher->address) }}">
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputTlpNumber" class="form-label">Nomor Hp</label>
                <input type="number" id="inputTlpNumber" name="telephone_number"
                    class="form-control @error('telephone_number') is-invalid @enderror"
                    value="{{ old('telephone_number', $teacher->telephone_number) }}">
                @error('telephone_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="email" id="inputEmail" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $teacher->email) }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputReligion" class="form-label">Agama</label>
                <select name="religion_id" class="form-select @error('religion_id') is-invalid @enderror">
                    <option value="" disabled selected>=== Pilih Agama ===</option>
                    @foreach ($religions as $religion)
                        @if (old('religion_id', $teacher->religion_id) == $religion->id)
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
                        @if (old('gender_id', $teacher->gender_id) == $gender->id)
                            <option value="{{ $gender->id }}" selected>
                                {{ $gender->name }}
                            </option>
                        @else
                            <option value="{{ $gender->id }}">
                                {{ $gender->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('gender_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputRole" class="form-label">Role</label>
                <select name="role_id" class="form-select">
                    <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                </select>
            </div>
            <a href="{{ route('teachers.index') }}" class="btn btn-info" role="button">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
