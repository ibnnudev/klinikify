<?php

namespace App\Repositories;

use App\Interfaces\ReservationInterface;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReservationRepository implements ReservationInterface
{
    private $patient;
    private $doctor;
    private $reservation;

    const DEFAULT_DEPOSIT_PROOF_FILE_PATH = 'public/deposit/';

    public function __construct(Patient $patient, Doctor $doctor, Reservation $reservation)
    {
        $this->patient = $patient;
        $this->doctor = $doctor;
        $this->reservation = $reservation;
    }

    public function getById($id)
    {
        return $this->reservation->with(['patient.user', 'doctor.user'])->find($id);
    }

    public function getWithPagination()
    {
        return $this->reservation->with(['patient', 'doctor'])->paginate(10);
    }

    public function store($data)
    {
        $totalDeposit = $this->_removeRupiahFormat($data['total_deposit']);
        $queueNumber = $this->_generateQueueNumber($data['date']);

        $reservations = $this->check($data);
        if ($reservations->count() > 0) {
            throw new \Exception('Dokter sudah memiliki jadwal pada tanggal dan waktu tersebut');
        }

        DB::beginTransaction();
        try {
            $this->reservation->create(array_merge($data, [
                'total_deposit' => $totalDeposit,
                'queue_number' => $queueNumber
            ]));
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }
        DB::commit();
    }

    function update($id, $data)
    {
        $totalDeposit = $this->_removeRupiahFormat($data['total_deposit']);

        $reservations = $this->check($data);
        if ($reservations->count() > 0) {
            throw new \Exception('Dokter sudah memiliki jadwal pada tanggal dan waktu tersebut');
        }

        DB::beginTransaction();
        try {
            $reservation = $this->reservation->find($id);
            $reservation->update(array_merge($data, [
                'total_deposit' => $totalDeposit
            ]));
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }
        DB::commit();
    }

    public function destroy($id)
    {
        $reservation = $this->reservation->find($id);
        if ($reservation->deposit_proof_file != null) {
            Storage::delete(self::DEFAULT_DEPOSIT_PROOF_FILE_PATH . $reservation->deposit_proof_file);
        }
        $reservation->delete();
    }

    public function _removeRupiahFormat($value)
    {
        return preg_replace('/\D/', '', $value);
    }

    public function _generateQueueNumber($date)
    {
        $reservations = $this->reservation
            ->where('date', $date)
            ->where('status', 'confirmed')
            ->count();

        $code = '';
        if ($reservations < 10) {
            $code = '00' . ($reservations + 1);
        } elseif ($reservations < 100) {
            $code = '0' . ($reservations + 1);
        } else {
            $code = $reservations + 1;
        }

        return 'EX-' . date('Ymd', strtotime($date)) . $code;
    }

    public function check($data)
    {
        $reservations = $this->reservation
            ->whereDate('date', $data['date'])
            ->whereTime('time', $data['time'])
            ->where('doctor_id', $data['doctor_id'])
            ->get();

        return $reservations;
    }
}
