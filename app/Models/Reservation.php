<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    public $table = 'reservations';
    protected $fillable = [
        'date',
        'time',
        'patient_id',
        'doctor_id',
        'queue_number',
        'status',
        'deposit_proof_file',
        'total_deposit'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
