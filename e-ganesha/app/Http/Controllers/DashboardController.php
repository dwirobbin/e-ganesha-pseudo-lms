<?php

namespace App\Http\Controllers;

use App\Models\{Student, Teacher, TeacherCourse};
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $teachers = Teacher::all();
        $totalTeacher = $teachers->count();

        $student = Student::all();
        $totalStudent = $student->count();

        $course = TeacherCourse::select('name')->distinct()->get();
        $totalCourse = $course->count();

        return view('backend.index', [
            'title' => 'Dashboard',
            'totalTeacher' => $totalTeacher,
            'totalStudent' => $totalStudent,
            'totalCourse' => $totalCourse
        ]);
    }
}
