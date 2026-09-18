<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $customersReady = Schema::hasTable('customers');
        $visitsReady = Schema::hasTable('customer_visits');

        $serviceQuery = Service::query()->orderBy('sort_order')->orderBy('title');
        if ($visitsReady) {
            $serviceQuery->withCount('visits');
        }

        return view('admin.dashboard', [
            'pendingBookings' => Booking::query()->where('status', 'pending')->count(),
            'totalBookings' => Booking::query()->count(),
            'unreadMessages' => ContactMessage::unread()->count(),
            'services' => Service::query()->count(),
            'workshopServices' => $serviceQuery->get(),
            'testimonials' => Testimonial::query()->count(),
            'recentBookings' => Booking::query()->with('service')->latest()->take(6)->get(),
            'recentMessages' => ContactMessage::query()->latest()->take(6)->get(),
            'newCustomers' => $customersReady ? Customer::query()->newCustomers()->count() : 0,
            'regularCustomers' => $customersReady ? Customer::query()->regular()->count() : 0,
        ]);
    }
}
