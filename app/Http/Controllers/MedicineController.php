<?php

namespace App\Http\Controllers;

use App\Interfaces\MedicineInterface;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    private $medicine;

    public function __construct(MedicineInterface $medicine)
    {
        $this->medicine = $medicine;
    }

    public function index()
    {
        $medicines = $this->medicine->getWithPagination();
        return view('admin.medicine.index', compact('medicines'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'hpp' => 'required',
            'unit' => 'required',
        ]);

        try {
            $this->medicine->store($request->all());
            return redirect()->back()->with('success', 'Obat berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show($id)
    {
        return json_encode($this->medicine->getById($id));
    }

    public function edit(Medicine $medicine)
    {
        //
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'hpp' => 'required',
            'unit' => 'required',
        ]);

        try {
            $this->medicine->update($id, $request->all());
            return redirect()->back()->with('success', 'Obat berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->medicine->destroy($id);
            return redirect()->back()->with('success', 'Obat berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
