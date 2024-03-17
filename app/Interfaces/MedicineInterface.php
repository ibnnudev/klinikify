<?php

namespace App\Interfaces;

interface MedicineInterface
{
    public function getAll();
    public function getWithPagination();
    public function getById($id);
    public function store($data);
    public function update($id, $data);
    public function destroy($id);
}
