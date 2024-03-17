<?php

namespace App\Http\Controllers;

use App\Interfaces\PatientInterface;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    private $patient;

    public function __construct(PatientInterface $patient)
    {
        $this->patient = $patient;
    }

    public function index()
    {
        $patients = $this->patient->getWithPagination();
        return view('admin.patient.index', compact('patients'));
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
            'age' => 'required',
            'phone' => 'required',
            'is_allergy' => 'required',
            'is_heart_disease' => 'required',
        ]);


        try {
            $this->patient->store($request->all());
            return redirect()->back()->with('success', 'Pasien berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show($id)
    {
        return json_encode($this->patient->getById($id));
    }

    public function edit(Patient $patient)
    {
        //
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'phone' => 'required',
            'is_allergy' => 'required',
            'is_heart_disease' => 'required',
        ]);

        try {
            $this->patient->update($id, $request->except(['_token', '_method']));
            return redirect()->back()->with('success', 'Pasien berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->patient->destroy($id);
            return redirect()->back()->with('success', 'Pasien berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Pasien gagal dihapus');
        }
    }
}
