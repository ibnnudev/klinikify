<?php

namespace App\Http\Controllers;

use App\Interfaces\DoctorCategoryInterface;
use App\Interfaces\DoctorInterface;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    private $doctor;
    private $doctorCategory;

    public function __construct(DoctorInterface $doctor, DoctorCategoryInterface $doctorCategory)
    {
        $this->doctor = $doctor;
        $this->doctorCategory = $doctorCategory;
    }

    public function index()
    {
        $doctors = $this->doctor->getWithPagination();
        $doctorCategories = $this->doctorCategory->getAll();

        return view('admin.doctor.index', compact('doctors', 'doctorCategories'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'gender' => 'required',
            'age' => 'required|integer',
            'phone' => 'required',
            'doctor_category_id' => 'required|exists:doctor_categories,id',
        ]);

        try {
            $this->doctor->store($request);
            return redirect()->back()->with('success', 'Dokter berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return json_encode($this->doctor->getById($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'age' => 'required|integer',
            'phone' => 'required',
            'gender' => 'required',
            'doctor_category_id' => 'required|exists:doctor_categories,id',
        ]);

        try {
            $this->doctor->update($id, $request->all());
            return redirect()->back()->with('success', 'Dokter berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error: ' . $th->getMessage());
        }
    }

    public function destroy($id)
    {
        $this->doctor->destroy($id);
        return redirect()->back()->with('success', 'Dokter berhasil dihapus');
    }
}
