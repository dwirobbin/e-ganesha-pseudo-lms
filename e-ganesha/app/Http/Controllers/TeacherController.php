<?php

namespace App\Http\Controllers;

use App\Models\{User, Gender, Teacher, Religion};
use Illuminate\Support\{Str, Facades\Hash};
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class TeacherController extends Controller
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
            $roles = Teacher::where('name', 'LIKE', "%{$request->keyword}%")
                ->latest()->paginate($this->perPage);
        } else {
            $roles = Teacher::latest()->paginate($this->perPage);
        }

        return view('backend.information.teachers.index', [
            'title' => 'Daftar Seluruh Guru',
            'teachers' => $roles->appends(
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
        return view('backend.information.teachers.create', [
            'title' => 'Tambah Guru Baru',
            'religions' => Religion::all(),
            'genders' => Gender::all(),
            'role' => Role::findById(2)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|max:255',
            'ttl' => 'required',
            'address' => 'required',
            'telephone_number' => 'required|unique:teachers',
            'email' => 'required|email:dns|unique:teachers',
            'password' => 'required',
            'religion_id' => 'required',
            'gender_id' => 'required',
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
            'role_id.required' => 'Role tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);

        $user = User::create([
            'name' => Str::title($request->name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role_id);

        Teacher::create([
            'name' => Str::title($request->name),
            'ttl' => Str::title($request->ttl),
            'address' => Str::title($request->address),
            'telephone_number' => $request->telephone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'religion_id' => $request->religion_id,
            'gender_id' => $request->gender_id,
            'role_id' => $request->role_id,
            'user_id' => $user->id
        ]);

        activity()->log("Berhasil menambahkan guru baru, yaitu : " . Str::title($request->name));

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Berhasil menambahkan guru baru, yaitu : ' . Str::title($request->name));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        return view('backend.information.teachers.show', [
            'title' => "Detail ",
            'teacher' => $teacher
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        return view('backend.information.teachers.edit', [
            'title' => "Edit $teacher->name",
            'teacher' => $teacher,
            'religions' => Religion::all(),
            'genders' => Gender::all(),
            'role' => Role::findById(2)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        $rules = [
            'name' => 'required|max:255',
            'ttl' => 'required',
            'address' => 'required',
            'religion_id' => 'required',
            'gender_id' => 'required',
            'role_id' => 'required'
        ];

        if ($request->telephone_number != $teacher->telephone_number) {
            $rules['telephone_number'] = 'required|unique:teachers';
        } elseif ($request->email != $teacher->email) {
            $rules['email'] = 'required|email:dns|unique:teachers';
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
            'role_id.required' => 'Role tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);

        Teacher::where('id', $teacher->id)->update([
            'name' => Str::title($request->name),
            'ttl' => Str::title($request->ttl),
            'address' => Str::title($request->address),
            'telephone_number' => $request->telephone_number,
            'email' => $request->email,
            'religion_id' => $request->religion_id,
            'gender_id' => $request->gender_id,
            'role_id' => $request->role_id
        ]);

        User::where('id', $teacher->user_id)->update([
            'name' => Str::title($request->name),
            'password' => Hash::make($request->password),
        ]);

        if ($request->email != $teacher->email) {
            $rules['email'] = 'required|unique:teachers' . $teacher->id;
        }

        activity()->log("Berhasil mengubah data guru, yaitu : " . Str::title($request->name));

        return redirect()
            ->route('teachers.index')
            ->with('success', "Berhasil mengubah data guru, yaitu : " . Str::title($request->name));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        $user = User::find($teacher->user_id);
        $user->removeRole($user->roles()->detach());

        User::where('id', $teacher->user_id)->delete();
        Teacher::destroy($teacher->id);

        activity()->log("Berhasil menghapus data guru, yaitu : $teacher->name");

        return redirect()
            ->route('teachers.index')
            ->with('success', "Berhasil Menghapus guru $teacher->name");
    }
}
