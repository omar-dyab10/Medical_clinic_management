<?php

namespace App\Http\Controllers;

use App\Models\Available_day;
use Illuminate\Http\Request;
use App\Http\Requests\AvailableDayRequest;
use App\Models\Time_slot;
use Carbon\Carbon;

class AvailableDayController extends Controller
{
    public function index()
    {
        $availableDays = Available_day::all();
        return response()->json($availableDays);
    }
    public function store(AvailableDayRequest $request)
    {
        $availableDay = Available_day::create($request->all());
        $startTime = Carbon::parse($request->start_time);
        $endTime = Carbon::parse($request->end_time);
        $slotDuration = 30;
        if ($startTime->gte($endTime)) {
            return response()->json(['error' => 'Start time must be before end time.'], 422);
        }
        while ($startTime->lt($endTime)) {
            $slotEnd = $startTime->copy()->addMinutes($slotDuration);
            Time_slot::create([
                'available_day_id' => $availableDay->id,
                'start_time' => $startTime->format('H:i:s'),
                'end_time' => $slotEnd->format('H:i:s'),
                'status' => 'available',
            ]);
            $startTime = $slotEnd;
        }

        return response()->json(['message' => 'Available day created successfully', 'availableDay' => $availableDay], 201);
    }
    public function show(Available_day $availableDay)
    {
        return response()->json($availableDay);
    }
    public function update(AvailableDayRequest $request, Available_day $availableDay)
    {
        $availableDay->update($request->all());
    }
    public function destroy(Available_day $availableDay)
    {
        $availableDay->delete();
        return response()->json(['message' => 'Available day deleted successfully'], 200);
    }
}
