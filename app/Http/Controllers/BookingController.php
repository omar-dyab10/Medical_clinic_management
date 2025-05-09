<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Time_slot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    // عرض جميع الحجوزات مع العلاقات المرتبطة
    public function index()
    {
        $bookings = Booking::with(['timeSlot', 'patient'])->get();
        return response()->json($bookings);
    }

    // عرض تفاصيل حجز محدد
    public function show($id)
    {
        $booking = Booking::with(['timeSlot', 'patient'])->findOrFail($id);
        return response()->json($booking);
    }

    // إنشاء حجز جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'time_slot_id' => 'required|exists:time_slots,id',
            'patient_id' => 'required|exists:patients,id',
            'status' => 'required|string',
        ]);

        $timeSlot = Time_slot::findOrFail($validated['time_slot_id']);
        if ($timeSlot->status !== 'available') {
            return response()->json(['error' => 'Time slot is not available'], 422);
        }

        // تحديث حالة الفترة الزمنية إلى محجوزة
        $timeSlot->update(['status' => 'booked']);

        // إضافة بيانات الحجز
        $validated['booking_date'] = now()->format('Y-m-d');
        $validated['booking_time'] = now()->format('H:i:s');

        // إنشاء الحجز
        $booking = Booking::create($validated);
        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking,
        ], 201);
    }

    // حذف حجز
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $timeSlot = Time_slot::find($booking->time_slot_id);
        if ($timeSlot) {
            $timeSlot->update(['status' => 'available']);
        }

        $booking->delete();
        return response()->json(['message' => 'Booking deleted']);
    }
}
