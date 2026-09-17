<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'pendingBookings' => Booking::query()->where('status', 'pending')->count(),
            'totalBookings' => Booking::query()->count(),
            'unreadMessages' => ContactMessage::unread()->count(),
            'services' => Service::query()->count(),
            'testimonials' => Testimonial::query()->count(),
            'recentBookings' => Booking::query()->with('service')->latest()->take(6)->get(),
            'recentMessages' => ContactMessage::query()->latest()->take(6)->get(),
        ]);
    }
}
