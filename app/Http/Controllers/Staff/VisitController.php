<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VisitController extends Controller
{
    public function create(Service $service): View
    {
        abort_unless($service->is_active, 404);

        return view('staff.visits.create', [
            'service' => $service,
        ]);
    }

    public function store(Request $request, Service $service): RedirectResponse
    {
        abort_unless($service->is_active, 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:150'],
            'address' => ['nullable', 'string', 'max:255'],
            'vehicle_make' => ['nullable', 'string', 'max:80'],
            'vehicle_model' => ['nullable', 'string', 'max:80'],
            'vehicle_year' => ['nullable', 'string', 'max:10'],
            'job_title' => ['nullable', 'string', 'max:180'],
            'notes' => ['nullable', 'string', 'max:4000'],
            'visited_at' => ['nullable', 'date'],
        ]);

        $phone = Customer::normalizePhone($data['phone']);
        $existing = Customer::findByContact($phone, $data['email'] ?? null);
        $wasNew = ! $existing;

        $customer = $existing ?: new Customer;
        $customer->fill([
            'name' => $data['name'],
            'phone' => $phone,
            'email' => $data['email'] ? strtolower($data['email']) : $customer->email,
            'address' => $data['address'] ?? $customer->address,
            'vehicle_make' => $data['vehicle_make'] ?? $customer->vehicle_make,
            'vehicle_model' => $data['vehicle_model'] ?? $customer->vehicle_model,
            'vehicle_year' => $data['vehicle_year'] ?? $customer->vehicle_year,
        ]);
        $customer->save();

        $customer->visits()->create([
            'registered_by' => $request->user()->id,
            'category' => $service->slug,
            'service_id' => $service->id,
            'job_title' => $data['job_title'] ?? $service->title,
            'notes' => $data['notes'] ?? null,
            'vehicle_make' => $data['vehicle_make'] ?? null,
            'vehicle_model' => $data['vehicle_model'] ?? null,
            'vehicle_year' => $data['vehicle_year'] ?? null,
            'visited_at' => $data['visited_at'] ?? now(),
        ]);

        $customer->recordVisit();
        $customer->refresh();

        $message = $wasNew
            ? 'New customer registered for '.$service->title.'.'
            : $customer->customerTypeLabel().' recorded for '.$service->title.' — visit #'.$customer->visit_count.'.';

        return redirect()
            ->route('staff.services.index')
            ->with('success', $message);
    }
}
