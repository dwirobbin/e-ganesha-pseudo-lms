<?php

namespace App\Http\Controllers;

use App\Models\{Student, UploadAnswer};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProfileStudentController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        return view('backend.student.profile', [
            'title' => "Profile",
            'profilesStudent' => Student::where('user_id', auth()->user()->id)->get()
        ]);
    }

    public function saveImgProfile(Request $request, Student $student)
    {
        $rules = [
            'image' => 'mimes:png,jpg,jpeg|max:10240'
        ];

        $messages = [
            'image.mimes' => 'Image harus berformat .png, .jpg, .jpeg, ',
            'image.max' => 'Image harus maksimal 10MB'
        ];

        $this->validate($request, $rules, $messages);

        $imageName = $student->image;

        if ($request->file('image')) {
            if (File::exists('storage/image_profile/' . $student->image)) {
                File::delete('storage/image_profile/' . $student->image);
            }

            $imageNameBody = uniqid();
            $imageName = substr(md5($imageNameBody), 6, 6) . '_' . time() . '.' . $request->image->extension();
            $rules['image'] = $request->file('image')->storeAs('image_profile', $imageName);
        }

        Student::where('user_id', auth()->user()->id)->update([
            'image' => $imageName
        ]);

        return back()->with('success', 'Berhasil mengubah foto profile');
    }

    public function profileStatistik($id)
    {
        $answers = UploadAnswer::where('user_id', $id)->get();

        // $answersOne = [];
        // foreach ($answers as $answerOne) {
        //     $answersOne[] = $answerOne['user_id'];
        //     $answersOne[] = $answerOne['bab_id'];
        // }

        // return $answers;

        $totalAnswers = $answers->count();
        return view('backend.student.profileStatistik', [
            'title' => "Profile Staistik",
            'profilesStudent' => Student::where('user_id', auth()->user()->id)->get(),
            'answers' => $answers
        ]);
    }
}
