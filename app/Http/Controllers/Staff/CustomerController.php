<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function lookup(Request $request): JsonResponse
    {
        $customer = Customer::findByContact($request->get('phone'), $request->get('email'));

        if (! $customer) {
            return response()->json([
                'found' => false,
                'type' => 'new',
                'label' => 'New customer',
            ]);
        }

        return response()->json([
            'found' => true,
            'type' => $customer->customerType(),
            'label' => $customer->customerTypeLabel(),
            'visit_count' => $customer->visit_count,
            'customer' => [
                'name' => $customer->name,
                'phone' => $customer->phone,
                'email' => $customer->email,
                'address' => $customer->address,
                'vehicle_make' => $customer->vehicle_make,
                'vehicle_model' => $customer->vehicle_model,
                'vehicle_year' => $customer->vehicle_year,
                'notes' => $customer->notes,
            ],
        ]);
    }
}
