<?php

namespace App\Http\Controllers;

use App\Models\Available_day;
use Illuminate\Http\Request;
use App\Http\Requests\AvailableDayRequest;
use App\Models\Time_slot;
use Carbon\Carbon;
use App\Http\Resources\AvailableDayResource;

class AvailableDayController extends Controller
{
    public function index()
    {
        $availableDays = Available_day::all();
        return AvailableDayResource::collection($availableDays);
    }
    public function store(AvailableDayRequest $request)
    {
        $availableDay = Available_day::create($request->validated());
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

        return response()->json(['message' => 'Available day created successfully', 'availableDay' => new AvailableDayResource($availableDay)], 201);
    }
    public function show(Available_day $availableDay)
    {
        return new AvailableDayResource($availableDay);
    }
    public function update(AvailableDayRequest $request, Available_day $availableDay)
    {
        $availableDay->update($request->all());
        return response()->json(['message' => 'Available day updated successfully', 'availableDay' => new AvailableDayResource($availableDay)], 200);
    }
    public function destroy(Available_day $availableDay)
    {
        $availableDay->delete();
        return response()->json(['message' => 'Available day deleted successfully'], 200);
    }
}
