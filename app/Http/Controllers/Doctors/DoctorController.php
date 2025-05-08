<?php

namespace App\Http\Controllers\Doctors;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Resources\DoctorResource;
class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return DoctorResource::collection($doctors);
    }
}
