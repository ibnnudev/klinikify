<?php

namespace App\Repositories;

use App\Interfaces\MedicineInterface;
use App\Models\Medicine;
use Illuminate\Support\Facades\DB;

class MedicineRepository implements MedicineInterface
{
    private $medicine;

    public function __construct(Medicine $medicine)
    {
        $this->medicine = $medicine;
    }

    public function getAll()
    {
        return $this->medicine->orderBy('id')->paginate(10);
    }

    public function getWithPagination()
    {
        return $this->medicine->orderBy('id')->paginate(10);
    }

    public function getById($id)
    {
        return $this->medicine->find($id);
    }

    public function store($data)
    {
        return $this->medicine->create($data);
    }

    public function update($id, $data)
    {
        $medicine = $this->medicine->find($id);
        $medicine->update($data);

        return $medicine;
    }

    public function destroy($id)
    {
        return $this->medicine->destroy($id);
    }
}
