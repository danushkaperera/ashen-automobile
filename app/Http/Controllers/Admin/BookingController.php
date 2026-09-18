<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $bookings = Booking::query()
            ->with('service')
            ->when(in_array($status, ['pending', 'confirmed', 'completed', 'cancelled'], true), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.bookings.index', [
            'bookings' => $bookings,
            'status' => $status,
        ]);
    }

    public function show(Booking $booking): View
    {
        $booking->load('service');

        return view('admin.bookings.show', compact('booking'));
    }

    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,confirmed,completed,cancelled'],
            'admin_notes' => ['nullable', 'string'],
        ]);
        $booking->update($data);

        return back()->with('success', 'Booking updated.');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted.');
    }
}
