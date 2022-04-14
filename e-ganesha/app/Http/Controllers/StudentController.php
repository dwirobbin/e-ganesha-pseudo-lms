<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\{Str, Facades\Hash, Facades\File};
use App\Models\{User, Gender, Student, Religion, ClassYear};

class StudentController extends Controller
{
    private $perPage = 5;

    public function __construct()
    {
        $this->middleware('auth');
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
            $roles = Student::where('name', 'LIKE', "%{$request->keyword}%")
                ->latest()->paginate($this->perPage);
        } else {
            $roles = Student::latest()->paginate($this->perPage);
        }

        return view('backend.information.students.index', [
            'title' => 'Daftar Seluruh Murid',
            'students' => $roles->appends(
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
        return view('backend.information.students.create', [
            'title' => 'Tambah Murid Baru',
            'religions' => Religion::all(),
            'genders' => Gender::all(),
            'classYears' => ClassYear::all(),
            'role' => Role::findById(3)
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
            'name' => 'required|max:255',
            'ttl' => 'required',
            'address' => 'required',
            'telephone_number' => 'required|unique:students',
            'email' => 'required|email:dns|unique:students',
            'password' => 'required',
            'religion_id' => 'required',
            'gender_id' => 'required',
            'class_year_id' => 'required',
            'role_id' => 'required',
        ];

        $messages = [
            'name.required' => 'Nama tidak boleh kosong',
            'name.max' => 'Nama harus maksimal 255 karakter',
            'ttl.required' => 'Ttl tidak boleh kosong',
            'address.required' => 'Alamat tidak boleh kosong',
            'telephone_number.required' => 'No. Hp tidak boleh kosong',
            'telephone_number.unique' => 'No. Hp sudah digunakan',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email salah',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password tidak boleh kosong',
            'religion_id.required' => 'Agama tidak boleh kosong',
            'gender_id.required' => 'Jenis kelamin tidak boleh kosong',
            'class_year_id.required' => 'Kelas tidak boleh kosong',
            'role_id.required' => 'Role tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);

        $user = User::create([
            'name' => Str::title($request->name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'class_year_id' => $request->class_year_id
        ]);

        $user->assignRole($request->role_id);

        Student::create([
            'name' => Str::title($request->name),
            'ttl' => Str::title($request->ttl),
            'address' => Str::title($request->address),
            'telephone_number' => $request->telephone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'religion_id' => $request->religion_id,
            'gender_id' => $request->gender_id,
            'class_year_id' => $request->class_year_id,
            'role_id' => $request->role_id,
            'user_id' => $user->id
        ]);

        activity()->log("Berhasil menambahkan murid baru, yaitu : " . Str::title($request->name));

        return redirect()
            ->route('students.index')
            ->with('success', "Berhasil menambahkan murid baru, yaitu : " . Str::title($request->name));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return view('backend.information.students.show', [
            'title' => "Detail $student->name",
            'student' => $student
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        return view('backend.information.students.edit', [
            'title' => "Edit $student->name",
            'student' => $student,
            'religions' => Religion::all(),
            'genders' => Gender::all(),
            'classYears' => ClassYear::all(),
            'role' => Role::findById(2)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $rules = [
            'name' => 'required|max:255',
            'ttl' => 'required',
            'address' => 'required',
            'religion_id' => 'required',
            'gender_id' => 'required',
            'class_year_id' => 'required',
            'role_id' => 'required'
        ];

        if ($request->telephone_number != $student->telephone_number) {
            $rules['telephone_number'] = 'required|unique:students';
        } elseif ($request->email != $student->email) {
            $rules['email'] = 'required|email:dns|unique:students';
        }

        $messages = [
            'name.required' => 'Nama tidak boleh kosong',
            'name.max' => 'Nama harus maksimal 255 karakter',
            'ttl.required' => 'Ttl tidak boleh kosong',
            'address.required' => 'Alamat tidak boleh kosong',
            'telephone_number.required' => 'No. Hp tidak boleh kosong',
            'telephone_number.unique' => 'No. Hp sudah digunakan',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email salah',
            'email.unique' => 'Email sudah digunakan',
            'religion_id.required' => 'Agama tidak boleh kosong',
            'gender_id.required' => 'Jenis kelamin tidak boleh kosong',
            'class_year_id.required' => 'Role tidak boleh kosong',
            'role_id.required' => 'Role tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);

        Student::where('id', $student->id)->update([
            'name' => Str::title($request->name),
            'ttl' => Str::title($request->ttl),
            'address' => Str::title($request->address),
            'telephone_number' => $request->telephone_number,
            'email' => $request->email,
            'religion_id' => $request->religion_id,
            'gender_id' => $request->gender_id,
            'class_year_id' => $request->class_year_id,
            'role_id' => $request->role_id
        ]);

        User::where('id', $student->user_id)->update([
            'name' => Str::title($request->name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->email != $student->email) {
            $rules['email'] = 'required|unique:students' . $student->id;
        }

        activity()->log("Berhasil mengubah data murid, yaitu : " . Str::title($request->name));

        return redirect()
            ->route('students.index')
            ->with('success', "Berhasil mengubah data murid, yaitu : " . Str::title($request->name));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        if (File::exists('storage/image_profile/' . $student->image)) {
            File::delete('storage/image_profile/' . $student->image);
        }

        $user = User::find($student->user_id);
        $user->removeRole($user->roles()->detach());

        User::where('id', $student->user_id)->delete();
        Student::destroy($student->id);

        activity()->log("Berhasil menghapus data murid, yaitu : " . Str::title($student->name));

        return redirect()
            ->route('students.index')
            ->with('success', "Berhasil Menghapus murid, dengan nama : " . Str::title($student->name));
    }
}
