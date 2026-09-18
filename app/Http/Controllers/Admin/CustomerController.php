<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerVisit;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $query = Customer::query()->latest('last_visited_at');

        if ($request->get('type') === 'regular') {
            $query->regular();
        } elseif ($request->get('type') === 'new') {
            $query->newCustomers();
        }

        if ($serviceId = $request->get('service')) {
            $query->whereHas('visits', function ($builder) use ($serviceId) {
                $builder->where('service_id', $serviceId);
            });
        }

        if ($search = trim((string) $request->get('q'))) {
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', '%'.Customer::normalizePhone($search).'%')
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return view('admin.customers.index', [
            'customers' => $query->paginate(20)->withQueryString(),
            'total' => Customer::query()->count(),
            'newCount' => Customer::query()->newCustomers()->count(),
            'regularCount' => Customer::query()->regular()->count(),
            'visitCount' => CustomerVisit::query()->count(),
            'services' => Service::query()->orderBy('sort_order')->orderBy('title')->withCount('visits')->get(),
        ]);
    }

    public function show(Customer $customer): View
    {
        $customer->load(['visits.staff', 'visits.service']);

        return view('admin.customers.show', compact('customer'));
    }
}
