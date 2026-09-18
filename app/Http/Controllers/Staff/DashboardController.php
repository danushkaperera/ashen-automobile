<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerVisit;
use App\Models\Service;
use App\Models\WorkshopJob;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = now()->startOfDay();

        return view('staff.dashboard', [
            'todayVisits' => WorkshopJob::query()->where('created_at', '>=', $today)->count(),
            'newCustomers' => Customer::query()->newCustomers()->count(),
            'regularCustomers' => Customer::query()->regular()->count(),
            'services' => Service::query()
                ->active()
                ->orderBy('title')
                ->withCount('visits')
                ->get(),
            'recentVisits' => CustomerVisit::query()->with(['customer', 'service'])->latest('visited_at')->take(8)->get(),
        ]);
    }
}
