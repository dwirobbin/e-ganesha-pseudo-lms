@extends('backend.core.main')

@section('title')
    {{ $title }}
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('courses') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header pt-0 ">
                    <div class="row ">
                        <div class="col-md-6 px-1">
                            <form action="#" method="GET">
                                <div class="input-group pt-2">
                                    <input name="keyword" value="{{ request()->get('keyword') }}" type="search"
                                        class="form-control" placeholder="Cari course.....">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body px-2 pt-2 pb-0">
                    <ul class="list-group list-group-flush">
                        @forelse ($courses as $course)
                            <li
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center pr-0">
                                <label class="mt-auto mb-auto">
                                    {{ $course->name }}
                                </label>
                            </li>
                        @empty
                            @if (request()->get('keyword'))
                                <p class="text-center fw-bold">Course dengan nama {{ request()->get('keyword') }} tidak
                                    tersedia</p>
                            @else
                                <p class="text-center fw-bold">
                                    <strong>Seluruh course belum tersedia</strong>
                                </p>
                            @endif
                        @endforelse
                    </ul>
                </div>
                @if ($courses->hasPages())
                    <div class="card-footer d-flex justify-content-end pb-0">
                        {{ $courses->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
