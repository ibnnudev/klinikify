<?php

namespace App\Http\Controllers;

use App\Interfaces\DoctorInterface;
use App\Interfaces\PatientInterface;
use App\Interfaces\ReservationInterface;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    private $patient;
    private $doctor;
    private $reservation;

    public function __construct(PatientInterface $patient, DoctorInterface $doctor, ReservationInterface $reservation)
    {
        $this->patient = $patient;
        $this->doctor = $doctor;
        $this->reservation = $reservation;
    }

    public function index()
    {
        $patients = $this->patient->getAll();
        $doctors = $this->doctor->getAll();
        $reservations = $this->reservation->getWithPagination();

        return view('admin.reservation.index', compact('patients', 'doctors', 'reservations'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'time' => 'required',
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'total_deposit' => 'required',
        ]);

        try {
            $this->reservation->store($request->except(['_token', '_method']));
            return redirect()->route('reservation.index')->with('success', 'Reservasi berhasil dibuat');
        } catch (\Throwable $th) {
            return redirect()->route('reservation.index')->with('error', $th->getMessage());
        }
    }

    public function show($id, Request $request)
    {
        if ($request->ajax()) {
            return view('admin.reservation._detail', ['reservation' => $this->reservation->getById($id)])->render();
        }
        return json_encode($this->reservation->getById($id));
    }

    public function edit(Reservation $reservation)
    {
        //
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'date' => 'required',
            'time' => 'required',
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'total_deposit' => 'required',
        ]);

        try {
            $this->reservation->update($id, $request->except(['_token', '_method']));
            return redirect()->route('reservation.index')->with('success', 'Reservasi berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->route('reservation.index')->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        $this->reservation->destroy($id);
        return redirect()->route('reservation.index')->with('success', 'Reservasi berhasil dihapus');
    }

    // CUSTOM FUNCTION
    public function check(Request $request)
    {
        return json_encode($this->reservation->check($request->all()));
    }
}
