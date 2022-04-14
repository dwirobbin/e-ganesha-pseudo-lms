<nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Bab</div>
            @foreach ($babs as $bab)
                <a class="nav-link {{ Request::is('dashboard/teacher-courses*') ? 'active' : '' }}"
                    href="{{ url('dashboard/teacher-courses/' . $teacherCourse->name . '/create' . "/$bab->name") }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    {{ $bab->name }}
                </a>
            @endforeach
        </div>
    </div>
</nav>
