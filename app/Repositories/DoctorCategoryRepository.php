<?php

namespace App\Repositories;

use App\Interfaces\DoctorCategoryInterface;
use App\Models\DoctorCategory;

class DoctorCategoryRepository implements DoctorCategoryInterface
{
    private $doctorCategory;

    public function __construct(DoctorCategory $doctorCategory)
    {
        $this->doctorCategory = $doctorCategory;
    }

    public function getAll()
    {
        return $this->doctorCategory->all();
    }

    public function getWithPagination()
    {
        return $this->doctorCategory->orderBy('id')->paginate(10);
    }

    public function getById($id)
    {
        return $this->doctorCategory->find($id);
    }

    public function store($data)
    {
        return $this->doctorCategory->create([
            'name' => $data['name'],
            'price' => $data['price']
        ]);
    }

    public function update($id, $data)
    {
        return $this->doctorCategory->find($id)->update([
            'name' => $data['name'],
            'price' => $data['price']
        ]);
    }

    public function destroy($id)
    {
        return $this->doctorCategory->destroy($id);
    }
}
