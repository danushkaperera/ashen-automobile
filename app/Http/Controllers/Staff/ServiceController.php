<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('staff.services.index', [
            'services' => Service::query()
                ->active()
                ->orderBy('title')
                ->withCount('visits')
                ->get(),
        ]);
    }
}
