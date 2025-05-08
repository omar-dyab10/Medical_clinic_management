<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller {
      public function index() {
        return Patient::all();
    }



    public function show($id) {
        return response()->json(Patient::findOrFail($id));
        
    }


  
}
