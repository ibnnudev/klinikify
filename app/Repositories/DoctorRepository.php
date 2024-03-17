<?php

namespace App\Repositories;

use App\Interfaces\DoctorInterface;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DoctorRepository implements DoctorInterface
{
    private $doctor;
    private $user;

    public function __construct(Doctor $doctor, User $user)
    {
        $this->doctor = $doctor;
        $this->user = $user;
    }

    public function getAll()
    {
        return $this->doctor->with('user')->orderBy('id')->paginate(10);
    }

    public function getWithPagination()
    {
        return $this->doctor->with('user')->orderBy('id')->paginate(10);
    }

    public function getById($id)
    {
        return $this->doctor->with('user')->find($id);
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {
            $user = $this->user->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt('password'),
                'gender' => $data['gender'],
                'age' => $data['age'],
                'phone' => $data['phone'],
                'role_id' => 2,
            ]);
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }

        try {
            $this->doctor->create([
                'user_id' => $user['id'],
                'doctor_category_id' => $data['doctor_category_id'],
            ]);
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }

        DB::commit();
    }

    public function update($id, $data)
    {
        DB::beginTransaction();
        try {
            $user = $this->user->find($id);
            $user->update($data);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            throw $th;
            DB::rollBack();
        }

        try {
            $this->doctor->where('user_id', $id)->update([
                'doctor_category_id' => $data['doctor_category_id'],
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            throw $th;
            DB::rollBack();
        }

        DB::commit();
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->user->destroy($id);
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }

        DB::commit();
    }
}
