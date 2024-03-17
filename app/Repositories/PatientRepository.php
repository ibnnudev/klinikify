<?php

namespace App\Repositories;

use App\Interfaces\PatientInterface;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PatientRepository implements PatientInterface
{
    private $patient;
    private $user;

    public function __construct(Patient $patient, User $user)
    {
        $this->patient = $patient;
        $this->user = $user;
    }

    public function getAll()
    {
        return $this->patient->with('user')->get();
    }

    public function getWithPagination()
    {
        return $this->patient->with('user')->orderBy('id', 'desc')->paginate(10);
    }

    public function getById($id)
    {
        return $this->patient->with('user')->find($id);
    }

    public function store($data)
    {
        DB::beginTransaction();

        try {
            $user = $this->user->create(array_merge($data, ['role_id' => 3, 'password' => bcrypt('password')]));
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }

        try {
            $this->patient->create([
                'user_id' => $user->id,
                'is_allergy' => $data['is_allergy'],
                'is_heart_disease' => $data['is_heart_disease'],
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
            $this->user->find($id)->update($data);
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }

        try {
            $this->patient->where('user_id', $id)->update([
                'is_allergy' => $data['is_allergy'],
                'is_heart_disease' => $data['is_heart_disease'],
            ]);
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }

        DB::commit();
    }

    public function destroy($id)
    {
        $this->patient->where('user_id', $id)->delete();
        $this->user->destroy($id);

        return true;
    }
}
