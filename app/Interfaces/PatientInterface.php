<?php

namespace App\Interfaces;

interface PatientInterface
{
    public function getAll();
    public function getWithPagination();
    public function getById($id);
    public function store($data);
    public function update($id, $data);
    public function destroy($id);
}
