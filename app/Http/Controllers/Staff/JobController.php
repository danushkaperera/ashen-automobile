<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Service;
use App\Models\WorkshopJob;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(): View
    {
        return view('staff.jobs.index', [
            'jobs' => WorkshopJob::query()->with('items')->latest()->paginate(20),
        ]);
    }

    public function create(Request $request): View
    {
        $services = Service::query()->active()->orderBy('title')->get();
        $selected = $services->firstWhere('id', (int) $request->get('service'));

        return view('staff.jobs.form', [
            'job' => new WorkshopJob,
            'services' => $services,
            'items' => old('items', $selected ? [[
                'service_id' => $selected->id,
                'title' => $selected->title,
                'quantity' => 1,
                'unit_price' => $selected->price,
            ]] : [['service_id' => '', 'title' => '', 'quantity' => 1, 'unit_price' => '']]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $customer = $this->customerFrom($data);

        $job = WorkshopJob::query()->create([
            'number' => WorkshopJob::nextNumber('JOB-'),
            'customer_id' => $customer->id,
            'created_by' => $request->user()->id,
            'customer_name' => $customer->name,
            'customer_phone' => $customer->phone,
            'customer_email' => $customer->email,
            'customer_address' => $customer->address,
            'vehicle_make' => $data['vehicle_make'] ?? null,
            'vehicle_model' => $data['vehicle_model'] ?? null,
            'vehicle_year' => $data['vehicle_year'] ?? null,
            'notes' => $data['notes'] ?? null,
            'status' => WorkshopJob::DRAFT,
            'gst_rate' => 15,
        ]);

        $this->syncItems($job, $data['items']);
        $job->recalculate();

        return redirect()->route('staff.jobs.show', $job)->with('success', 'Job '.$job->number.' saved.');
    }

    public function show(WorkshopJob $job): View
    {
        $job->load(['items.service', 'customer', 'staff']);

        return view('staff.jobs.show', compact('job'));
    }

    public function edit(WorkshopJob $job): View
    {
        abort_unless($job->isDraft(), 404);
        $job->load('items');

        return view('staff.jobs.form', [
            'job' => $job,
            'services' => Service::query()->active()->orderBy('title')->get(),
            'items' => old('items', $job->items->map(fn ($item) => [
                'service_id' => $item->service_id,
                'title' => $item->title,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
            ])->all()),
        ]);
    }

    public function update(Request $request, WorkshopJob $job): RedirectResponse
    {
        abort_unless($job->isDraft(), 404);

        $data = $this->validated($request);
        $customer = $this->customerFrom($data);

        $job->update([
            'customer_id' => $customer->id,
            'customer_name' => $customer->name,
            'customer_phone' => $customer->phone,
            'customer_email' => $customer->email,
            'customer_address' => $customer->address,
            'vehicle_make' => $data['vehicle_make'] ?? null,
            'vehicle_model' => $data['vehicle_model'] ?? null,
            'vehicle_year' => $data['vehicle_year'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);

        $job->items()->delete();
        $this->syncItems($job, $data['items']);
        $job->recalculate();

        return redirect()->route('staff.jobs.show', $job)->with('success', 'Job updated.');
    }

    public function invoice(WorkshopJob $job): RedirectResponse
    {
        abort_unless($job->isDraft(), 404);
        abort_unless($job->items()->exists(), 422);

        $job->update([
            'status' => WorkshopJob::INVOICED,
            'invoice_number' => WorkshopJob::nextNumber('INV-'),
            'invoiced_at' => now(),
        ]);

        return redirect()->route('staff.jobs.invoice', $job)->with('success', 'Invoice '.$job->invoice_number.' created.');
    }

    public function showInvoice(WorkshopJob $job): View
    {
        abort_unless($job->isInvoiced(), 404);
        $job->load(['items.service', 'customer', 'staff']);

        return view('staff.jobs.invoice', compact('job'));
    }

    public function paid(WorkshopJob $job): RedirectResponse
    {
        abort_unless($job->isInvoiced(), 404);

        $job->update([
            'status' => WorkshopJob::PAID,
            'paid_at' => now(),
        ]);

        return back()->with('success', 'Invoice marked as paid.');
    }

    public function destroy(WorkshopJob $job): RedirectResponse
    {
        abort_unless($job->isDraft(), 404);
        $job->delete();

        return redirect()->route('staff.jobs.index')->with('success', 'Draft job removed.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:150'],
            'address' => ['nullable', 'string', 'max:255'],
            'vehicle_make' => ['nullable', 'string', 'max:80'],
            'vehicle_model' => ['nullable', 'string', 'max:80'],
            'vehicle_year' => ['nullable', 'string', 'max:10'],
            'notes' => ['nullable', 'string', 'max:4000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.service_id' => ['nullable', 'exists:services,id'],
            'items.*.title' => ['required', 'string', 'max:180'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
        ]);
    }

    private function customerFrom(array $data): Customer
    {
        $phone = Customer::normalizePhone($data['phone']);
        $customer = Customer::findByContact($phone, $data['email'] ?? null) ?: new Customer;
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

        return $customer;
    }

    private function syncItems(WorkshopJob $job, array $items): void
    {
        foreach (array_values($items) as $index => $item) {
            $qty = (float) $item['quantity'];
            $price = (float) $item['unit_price'];
            $job->items()->create([
                'service_id' => $item['service_id'] ?: null,
                'title' => $item['title'],
                'quantity' => $qty,
                'unit_price' => $price,
                'line_total' => round($qty * $price, 2),
                'sort_order' => $index,
            ]);
        }
    }
}
