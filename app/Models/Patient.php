<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','date_of_birth','gender'];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function activeAppointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id')->where('status','completed');
    }
}
