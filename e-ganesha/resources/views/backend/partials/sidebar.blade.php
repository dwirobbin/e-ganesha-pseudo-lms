<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Core</div>
            <a class="nav-link {{ Request::is('dashboard/admin') ? 'active' : '' }}"
                href="{{ url('dashboard/admin') }}">
                <div class="sb-nav-link-icon">
                    <i class="fas fa-tachometer-alt"></i>
                </div>
                Dashboard
            </a>
            <div class="sb-sidenav-menu-heading">Information</div>
            <a class="nav-link {{ Request::is('dashboard/admin/teachers*') ? 'active' : '' }}"
                href="{{ route('teachers.index') }}">
                <div class="sb-nav-link-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                Daftar Guru
            </a>
            <a class="nav-link {{ Request::is('dashboard/admin/students*') ? 'active' : '' }}"
                href="{{ route('students.index') }}">
                <div class="sb-nav-link-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                Daftar Murid
            </a>
            <a class="nav-link {{ Request::is('dashboard/admin/class-years*') ? 'active' : '' }}"
                href="{{ url('dashboard/admin/class-years') }}">
                <div class="sb-nav-link-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                Tahun Angkatan
            </a>
            <a class="nav-link {{ Request::is('dashboard/admin/courses*') ? 'active' : '' }}"
                href="{{ url('dashboard/admin/courses') }}">
                <div class="sb-nav-link-icon">
                    <i class="fas fa-book"></i>
                </div>
                Course
            </a>
            <a class="nav-link {{ Request::is('dashboard/admin/logs-activity*') ? 'active' : '' }}"
                href="{{ url('dashboard/admin/logs-activity') }}">
                <div class="sb-nav-link-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                Aktivitas
            </a>


            <div class="sb-sidenav-menu-heading">Level User</div>
            <a class="nav-link {{ Request::is('dashboard/admin/roles*') ? 'active' : '' }}"
                href="{{ url('dashboard/admin/roles') }}">
                <div class="sb-nav-link-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                Wewenang
            </a>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Login sebagai :</div>
        {{ Auth::user()->name }}
    </div>
</nav>
