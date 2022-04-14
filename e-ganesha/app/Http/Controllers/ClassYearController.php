<?php

namespace App\Http\Controllers;

use App\Models\ClassYear;
use Illuminate\Http\Request;

class ClassYearController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.information.classYears.index', [
            'title' => 'Tahun Angkatan',
            'classYears' => ClassYear::paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.information.classYears.create', [
            'title' => "Tambah Tahun Angkatan Baru"
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
            'name' => 'required|unique:class_years'
        ];

        $message = [
            'name.required' => 'Tidak boleh kosong',
            'name.unique' => 'Sudah digunakan'
        ];

        $this->validate($request, $rules, $message);

        ClassYear::create([
            'name' => $request->name
        ]);

        activity()->log("Berhasil menambahkan tahun $request->name");

        return redirect('dashboard/admin/class-years')
            ->with('success', "Berhasil menambahkan tahun angkatan baru, yaitu : $request->name");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClassYear  $classYear
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassYear $classYear)
    {
        activity()->log("Berhasil menghapus tahun $classYear->name");

        ClassYear::destroy($classYear->id);

        return redirect('dashboard/admin/class-years')
            ->with('success', "Berhasil menghapus tahun angkatan, yaitu : $classYear->name");
    }
}
