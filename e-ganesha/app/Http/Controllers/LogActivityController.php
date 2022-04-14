<?php

namespace App\Http\Controllers;

use App\Models\{User, Student, Teacher};
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LogActivityController extends Controller
{
    private $perPage = 5;

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $logs = [];
        if ($request->has('keyword')) {
            $logs = Activity::where('description', 'LIKE', "%{$request->keyword}%")
                ->latest()->paginate($this->perPage);
        } else {
            $logs = Activity::with('user')->latest()->paginate($this->perPage);
        }

        $title = 'Log Activities';
        $user = User::select()->count();
        $teacher = Teacher::select()->count();
        $student = Student::select()->count();
        $activityLog = $logs->appends([
            'keyword' => $request->keyword
        ]);

        return view('backend.information.logsActivity.index', compact(
            'title',
            'user',
            'teacher',
            'student',
            'activityLog'
        ));
    }

    public function destroy($description)
    {
        Activity::where('description', $description)->delete();

        return redirect('dashboard/admin/logs-activity')
            ->with('success', "Berhasil menghapus log, yaitu : $description");
    }
}
