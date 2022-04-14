<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\{Str, Facades\Auth, Facades\File};
use App\Models\{Bab, Course, ClassYear, TeacherCourse, UploadAnswer};

class TeacherCourseController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = [];
        if ($request->has('keyword')) {
            $roles = TeacherCourse::select('name')
                ->where('name', 'LIKE', "%{$request->keyword}%")
                ->distinct()->latest()->paginate(8);
        } else {
            $roles = TeacherCourse::select('name')->distinct()->paginate(8);
        }

        return view('backend.courses.index', [
            'title' => 'Dashboard Teacher',
            'teacherCourses' => $roles->appends(
                [
                    'keyword' => $request->keyword
                ]
            )
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.courses.createCourse', [
            'title' => 'Create Course',
            'babs' => Bab::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255|unique:teacher_courses',
            'description' => 'required',
        ];

        $messages = [
            'name.required' => 'Nama tidak boleh kosong',
            'name.max' => 'Nama harus maksimal 255 karakter',
            'name.unique' => 'Nama sudah digunakan',
            'description.required' => 'Deskripsi tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);

        TeacherCourse::create([
            'name' => Str::title($request->name),
            'description' => $request->description,
            'bab_id' => $request->bab_id,
        ]);

        return redirect('dashboard/courses')
            ->with('success', "Berhasil menambahkan course baru, yaitu : $request->name");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TeacherCourse  $teacherCourse
     * @return \Illuminate\Http\Response
     */
    public function show(TeacherCourse $teacherCourse)
    {
        return view('backend.courses.showCourse', [
            'title' => 'Detail Course',
            'teacherCourse' => $teacherCourse,
            'babs' => Bab::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TeacherCourse  $teacherCourse
     * @return \Illuminate\Http\Response
     */
    public function editCourse(TeacherCourse $teacherCourse)
    {
        return view('backend.courses.editCourse', [
            'title' => "Edit Course $teacherCourse->name",
            'teacherCourse' => $teacherCourse
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TeacherCourse  $teacherCourse
     * @return \Illuminate\Http\Response
     */
    public function updateCourse(Request $request, TeacherCourse $teacherCourse)
    {
        $rules = [
            'name' => 'max:255'
        ];

        if ($request->name != $teacherCourse->name) {
            $rules['name'] = 'required|unique:teacher_courses';
        } elseif ($request->description != $teacherCourse->description) {
            $rules['description'] = 'required';
        }

        $messages = [
            'name.required' => 'Nama tidak boleh kosong',
            'name.max' => 'Nama harus maksimal 255 karakter',
            'name.unique' => 'Nama sudah digunakan',
            'description.required' => 'Nama tidak boleh kosong'
        ];

        $this->validate($request, $rules, $messages);

        TeacherCourse::where('id', $teacherCourse->id)->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect('dashboard/courses')
            ->with('success', "Berhasil mengubah informasi course $teacherCourse->name");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TeacherCourse  $teacherCourse
     * @return \Illuminate\Http\Response
     */
    public function destroyCourse(TeacherCourse $teacherCourse)
    {
        $answerFile = UploadAnswer::where('teacher_course_id', $teacherCourse->id)->get();

        $filesAnswer = [];
        foreach ($answerFile as $fileAnswer) {
            $filesAnswer[] = $fileAnswer['file_name'];
        }

        foreach ($filesAnswer as $itemAnswer) {
            if (File::exists('storage/upload_answer/' . $itemAnswer)) {
                File::delete('storage/upload_answer/' . $itemAnswer);
            }
        }

        $teacherFile = TeacherCourse::where('name', $teacherCourse->name)->get();

        $files = [];
        foreach ($teacherFile as  $teachFiles) {
            $files[] = $teachFiles['file_name'];
        }

        foreach ($files as $item) {
            if (File::exists('storage/course_file/' . $item) && Course::where('teacher_course_id', $teacherCourse->id)->get()) {
                File::delete('storage/course_file/' . $item);
            }
        }

        TeacherCourse::where('name', $teacherCourse->name)->delete();
        Course::where('teacher_course_id', $teacherCourse->id)->delete();
        UploadAnswer::where('teacher_course_id', $teacherCourse->id)->delete();

        return redirect('dashboard/courses')
            ->with('success', "Berhasil mengapus course $teacherCourse->name");
    }

    public function detailCreate(TeacherCourse $teacherCourse)
    {
        return view('backend.courses.detailCreate', [
            'title' => 'Detail Create',
            'teacherCourse' => $teacherCourse,
            'classYears' => ClassYear::all(),
            'babs' => Bab::all(),
            'role' => Role::findById(3)
        ]);
    }

    public function detailStore(Request $request, TeacherCourse $teacherCourse)
    {
        $rules = [
            'file_name' => "mimes:pdf|max:10240",
            'soal' => 'required',
            'bab_id' => 'required',
            'class_year_id' => 'required'
        ];

        $messages = [
            'file_name.max' => 'File harus maksimal berukuran 10 MB',
            'file_name.mimes' => 'File harus berformat .pdf',
            'soal.required' => 'Soal tidak boleh kosong',
            'bab_id.required' => 'Bab tidak boleh kosong',
            'class_year_id.required' => 'Tahun angkatan tidak boleh kosong'
        ];

        $this->validate($request, $rules, $messages);

        $fileName = null;

        if ($request->file('file_name')) {
            $fileNameBody = uniqid();
            $fileName = substr(md5($fileNameBody), 6, 6) . '_' . time() . '.' . $request->file_name->extension();
            $rules['file_name'] = $request->file('file_name')->storeAs('course_file', $fileName);
        }

        $course = Course::create([
            'file_name' => $fileName,
            'link_name' => $request->link_name,
            'soal' => $request->soal,
            'class_year_id' => $request->class_year_id,
            'bab_id' => $request->bab_id,
            'teacher_course_id' => $request->teacher_course_id,
            'user_id' => Auth::user()->id,
            'role_id' => $request->role_id
        ]);

        TeacherCourse::create([
            'name' => $teacherCourse->name,
            'description' => $teacherCourse->name,
            'course_id' => $course->id,
            'class_year_id' => $request->class_year_id,
            'file_name' => $fileName
        ]);

        return redirect("dashboard/courses/$teacherCourse->name")
            ->with('success', 'Berhasil menambahkan data');
    }

    public function detailCourse(TeacherCourse $teacherCourse)
    {
        return view('backend.courses.detailCourse', [
            'title' => 'Detail Course',
            'teacherCourse' => $teacherCourse,
            'courses' => Course::where('teacher_course_id', $teacherCourse->id)->get()
        ]);
    }

    public function downloadFile($file_name)
    {
        return response()->download(public_path('storage/course_file/' . $file_name));
    }

    public function editBab($id)
    {
        $courses = Course::where('id', $id)->get();

        $classYears = ClassYear::all();
        $babs = Bab::all();

        $title = "Edit $id";

        return view('backend.courses.editBab', compact('title', 'courses', 'classYears', 'babs'));
    }

    public function updateBab(Request $request)
    {
        $rules = [
            'file_name' => 'mimes:pdf|max:10240',
            'soal' => 'required',
            'class_year_id' => 'required',
            'bab_id' => 'required',
            'teacher_course_id' => 'required',
            'role_id' => 'required'
        ];

        $messages = [
            'file_name.mimes' => 'File harus berformat .pdf',
            'file_name.max' => 'File harus maksimal 10MB',
            'soal.required' => 'Soal tidak boleh kosong',
            'class_year_id.required' => 'Tahun angkatan tidak boleh kosong',
            'bab_id.required' => 'Bab tidak boleh kosong',
            'teacher_course_id.required' => 'Course tidak boleh kosong',
            'role_id.required' => 'Role tidak boleh kosong'
        ];

        $this->validate($request, $rules, $messages);

        $teacherCourse = TeacherCourse::where('course_id', $request->id)->get();

        $values = [];
        foreach ($teacherCourse as $value) {
            $values[] = $value;
        }

        $result = [];
        foreach ($values as $item) {
            $result = $item;
        }

        $imageName = $result['file_name'];

        if ($request->file('file_name')) {
            if (File::exists('storage/course_file/' . $imageName)) {
                File::delete('storage/course_file/' . $imageName);
            }

            $imageNameBody = uniqid();
            $imageName = substr(md5($imageNameBody), 6, 6) . '_' . time() . '.' . $request->file_name->extension();
            $rules['file_name'] = $request->file('file_name')->storeAs('course_file', $imageName);
        }

        Course::where('id', $request->id)->update([
            'file_name' => $imageName,
            'link_name' => $request->link_name,
            'soal' => $request->soal,
            'class_year_id' => $request->class_year_id,
            'bab_id' => $request->bab_id,
            'user_id' => auth()->user()->id,
            'teacher_course_id' => $request->teacher_course_id,
            'role_id' => $request->role_id
        ]);

        TeacherCourse::where('course_id', $request->id)->update([
            'name' => $result['name'],
            'description' => $result['name'],
            'course_id' => $request->id,
            'class_year_id' => $request->class_year_id,
            'file_name' => $imageName
        ]);

        return redirect('dashboard/courses/' . $result['name'] . '/show')
            ->with('success', "Berhasil mengubah data : " . $result['name']);
    }

    public function deleteBab(Course $course)
    {
        $answers = UploadAnswer::where('course_id', $course->id)->get();

        $values = [];
        foreach ($answers as $answer) {
            $values[] = $answer['file_name'];
        }

        foreach ($values as $item) {
            if (File::exists('storage/upload_answer/' . $item) && Course::where('teacher_course_id', $course->teacher_course_id)->get()) {
                File::delete('storage/upload_answer/' . $item);
            }
        }

        UploadAnswer::where('course_id', $course->id)->delete();

        if (File::exists('storage/course_file/' . $course->file_name)) {
            File::delete('storage/course_file/' . $course->file_name);
        }

        TeacherCourse::where('course_id', $course->id)->delete();
        Course::where('id', $course->id)->delete();

        return back()->with('success', 'Berhasil menghapus ' . $course->bab->name);
    }

    public function seeUploadAnswer($id)
    {
        return view('backend.courses.showUploadAnswer', [
            'title' => 'Done Upload Answer',
            'courses' => Course::where('id', $id)->get(),
            'answers' => UploadAnswer::where('course_id', $id)->get()
        ]);
    }

    public function downloadFileAnswer($file_name)
    {
        return response()->download(public_path('storage/upload_answer/' . $file_name));
    }
}
