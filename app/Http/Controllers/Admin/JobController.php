<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkshopJob;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(): View
    {
        return view('admin.jobs.index', [
            'jobs' => WorkshopJob::query()->with('items')->latest()->paginate(20),
        ]);
    }

    public function show(WorkshopJob $job): View
    {
        $job->load(['items.service', 'customer', 'staff']);

        return view('admin.jobs.show', compact('job'));
    }

    public function invoice(WorkshopJob $job): View
    {
        abort_unless($job->isInvoiced(), 404);
        $job->load(['items.service', 'customer', 'staff']);

        return view('staff.jobs.invoice', compact('job'));
    }
}
