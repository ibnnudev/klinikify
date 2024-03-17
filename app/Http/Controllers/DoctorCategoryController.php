<?php

namespace App\Http\Controllers;

use App\Interfaces\DoctorCategoryInterface;
use App\Models\DoctorCategory;
use Illuminate\Http\Request;

class DoctorCategoryController extends Controller
{
    private $doctorCategory;

    public function __construct(DoctorCategoryInterface $doctorCategory)
    {
        $this->doctorCategory = $doctorCategory;
    }

    public function index()
    {
        $categories = $this->doctorCategory->getWithPagination();
        return view('admin.doctor_category.index', compact('categories'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:doctor_categories,name']);

        $this->doctorCategory->store($request->all());
        return redirect()->route('doctor-category.index')->with('success', 'Kategori dokter baru berhasil dibuat!');
    }

    public function show(DoctorCategory $doctorCategory)
    {
        //
    }

    public function edit(DoctorCategory $doctorCategory)
    {
        //
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $this->doctorCategory->update($id, $request->all());

        return redirect()->route('doctor-category.index')->with('success', 'Kategori Dokter Berhasil Diupdate');
    }

    public function destroy($id)
    {
        $this->doctorCategory->destroy($id);

        return redirect()->route('doctor-category.index')->with('success', 'Kategori Dokter Berhasil Dihapus');
    }
}
