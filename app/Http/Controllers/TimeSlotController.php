<?php

namespace App\Http\Controllers;

use App\Models\Time_slot;
use Illuminate\Http\Request;
use App\Http\Resources\TimeSlotResource;
use Illuminate\Support\Facades\Gate;

class TimeSlotController extends Controller
{
    public function index()
    {
        $timeSlots = Time_slot::all();
        return TimeSlotResource::collection($timeSlots);
    }
    public function show(Time_slot $timeSlot)
    {
        return new TimeSlotResource($timeSlot);
    }
    public function destroy(Time_slot $timeSlot)
    {
        if (Gate::allows('is_doctor')) {
            if ($timeSlot->status === 'available') {
                $timeSlot->delete();
                return response()->json(['message' => 'Time slot deleted successfully'], 200);
            }
            return response()->json(['message' => 'Time slot is not available'], 400);
        }
        return response()->json(['message' => 'You are not authorized to delete this time slot'], 403);
    }
}