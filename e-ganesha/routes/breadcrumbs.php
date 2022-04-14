<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Illuminate\Support\Str;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('dashboard_admin', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', url('dashboard/admin'));
    $trail->push('Admin', url('dashboard/admin'));
});

// Dashboard > Roles
Breadcrumbs::for('roles', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard_admin');
    $trail->push('Roles', url('dashboard/admin/roles'));
});

// Dashboard > Admin > Roles > Detail > ['name']
Breadcrumbs::for('show_role', function (BreadcrumbTrail $trail, $role) {
    $trail->parent('roles');
    $trail->push('Detail', url('dashboard/admin/roles/show/' . Str::lower($role->name)));
    $trail->push($role->name, url('dashboard/admin/roles/show/' . Str::lower($role->name)));
});

// Dashboard > Admin > Roles > Edit > ['name']
Breadcrumbs::for('edit_role', function (BreadcrumbTrail $trail, $role) {
    $trail->parent('roles');
    $trail->push('Edit', url('dashboard/admin/roles/edit/' . Str::lower($role->name)));
    $trail->push($role->name, url('dashboard/admin/roles/edit/' . Str::lower($role->name)));
});

// Dashboard > Admin > Daftar Guru
Breadcrumbs::for('teachers', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard_admin');
    $trail->push('Daftar Guru', route('teachers.index'));
});

// Dashboard > Admin > Tambah Guru Baru > Create
Breadcrumbs::for('teacher_create', function (BreadcrumbTrail $trail) {
    $trail->parent('teachers');
    $trail->push('Tambah Guru Baru', route('teachers.create'));
});

// Dashboard > Admin > Daftar Guru > Detail > ['name']
Breadcrumbs::for('teacher_show', function (BreadcrumbTrail $trail, $teacher) {
    $trail->parent('teachers');
    $trail->push('Detail', route('teachers.show', $teacher->name));
    $trail->push($teacher->name, route('teachers.show', $teacher->name));
});

// Dashboard > Admin > Daftar Guru > Edit > ['name']
Breadcrumbs::for('teacher_edit', function (BreadcrumbTrail $trail, $teacher) {
    $trail->parent('teachers');
    $trail->push('Edit', route('teachers.edit', Str::lower($teacher->name)));
    $trail->push($teacher->name, route('teachers.edit', Str::lower($teacher->name)));
});

// Dashboard > Admin > Daftar Students
Breadcrumbs::for('students', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard_admin');
    $trail->push('Daftar Murid', route('students.index'));
});

// Dashboard > Admin > Tambah Murid Baru > Create
Breadcrumbs::for('student_create', function (BreadcrumbTrail $trail) {
    $trail->parent('students');
    $trail->push('Tambah Murid Baru', route('students.create'));
});

// Dashboard > Admin > Daftar Students > Detail > ['name']
Breadcrumbs::for('student_show', function (BreadcrumbTrail $trail, $student) {
    $trail->parent('students');
    $trail->push('Detail', route('students.show', Str::lower($student->name)));
    $trail->push($student->name, route('students.show', Str::lower($student->name)));
});

// Dashboard > Admin > Daftar Guru > Edit > ['name']
Breadcrumbs::for('student_edit', function (BreadcrumbTrail $trail, $student) {
    $trail->parent('students');
    $trail->push('Edit', route('students.edit', Str::lower($student->name)));
    $trail->push($student->name, route('students.edit', Str::lower($student->name)));
});

// Dashboard > Admin > Daftar Tahun Angkatan
Breadcrumbs::for('class_years', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard_admin');
    $trail->push('Daftar Tahun Angkatan', url('dashboard/admin/students'));
});

// Dashboard > Admin > ClassYears > Tambah Tahun Angkatan
Breadcrumbs::for('class_years_create', function (BreadcrumbTrail $trail) {
    $trail->parent('class_years');
    $trail->push('Tambah Angkatan Baru', url('dashboard/admin/class-years/create'));
});

// Dashboard > Admin > Courses
Breadcrumbs::for('courses', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard_admin');
    $trail->push("Semua Course", url('dashboard/admin/courses'));
});

// Dashboard > Admin > LogsActivity
Breadcrumbs::for('logs_activity', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard_admin');
    $trail->push('Log Activities', url('dashboard/admin/logs-activity'));
});
