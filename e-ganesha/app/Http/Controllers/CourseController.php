<?php

namespace App\Http\Controllers;

use App\Models\TeacherCourse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private $perPage = 5;

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $roles = [];
        if ($request->has('keyword')) {
            $roles = TeacherCourse::select('name')->where('name', 'LIKE', "%{$request->keyword}%")->distinct()->latest()->paginate($this->perPage);
        } else {
            $roles = TeacherCourse::select('name')->distinct()->latest()->paginate($this->perPage);
        }

        return view('backend.information.courses.index', [
            'title' => 'Semua Course',
            'courses' =>  $roles->appends(
                [
                    'keyword' => $request->keyword
                ]
            )
        ]);
    }
}
