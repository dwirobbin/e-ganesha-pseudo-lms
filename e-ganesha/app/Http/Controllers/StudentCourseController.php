<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\UploadAnswer;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    public function storeFile(Request $request)
    {
        $rules = [
            'file_name' => "required|mimes:pdf,doc,docx|max:10240"
        ];

        $messages = [
            'file_name.required' => 'File tidak boleh kosong',
            'file_name.mimes' => 'File harus berformat .pdf, .doc, .docx',
            'file_name.max' => 'File harus maksimal berukuran 10 MB',
        ];

        $this->validate($request, $rules, $messages);

        $courses = Course::where('id', $request->id)->get();

        $values = [];
        foreach ($courses as $course) {
            $values[] = $course;
        }

        $result = [];
        foreach ($values as $item) {
            $result = $item;
        }

        $fileName = null;

        if ($request->file('file_name')) {
            $fileNameBody = uniqid();
            $fileName = substr(md5($fileNameBody), 6, 6) . '_' . time() . '.' . $request->file_name->extension();
            $rules['file_name'] = $request->file('file_name')->storeAs('upload_answer', $fileName);
        }

        UploadAnswer::create([
            'file_name' => $fileName,
            'teacher_course_id' => $result['teacher_course_id'],
            'course_id' => $request->id,
            'course_id' => $request->id,
            'class_year_id' => $result['class_year_id'],
            'bab_id' => $result['bab_id'],
            'user_id' => auth()->user()->id
        ]);

        return back()->with('success', "Berhasil mengupload file jawaban");
    }
}
