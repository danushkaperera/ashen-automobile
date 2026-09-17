<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function contact(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['nullable', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:4000'],
        ]);

        ContactMessage::query()->create($data);

        return back()->with('success', 'Thanks for getting in touch. We will reply as soon as we can.');
    }

    public function booking(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['required', 'string', 'max:40'],
            'vehicle_make' => ['nullable', 'string', 'max:80'],
            'vehicle_model' => ['nullable', 'string', 'max:80'],
            'vehicle_year' => ['nullable', 'string', 'max:10'],
            'service_id' => ['nullable', 'exists:services,id'],
            'preferred_date' => ['nullable', 'date', 'after_or_equal:today'],
            'preferred_time' => ['nullable', 'string', 'max:40'],
            'message' => ['nullable', 'string', 'max:4000'],
        ]);

        if (! empty($data['service_id'])) {
            abort_unless(Service::query()->where('id', $data['service_id'])->where('is_active', true)->exists(), 422);
        }

        Booking::query()->create($data);

        return back()->with('success', 'Your booking request has been received. Our team will confirm your timeslot shortly.');
    }
}
