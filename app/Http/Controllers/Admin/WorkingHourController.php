<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkingHour;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkingHourController extends Controller
{
    public function index(): View
    {
        return view('admin.hours.index', [
            'hours' => WorkingHour::ordered()->get(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'hours' => ['required', 'array'],
        ]);

        foreach ($request->input('hours', []) as $id => $data) {
            $hour = WorkingHour::query()->find($id);
            if (! $hour) {
                continue;
            }
            $hour->update([
                'open_time' => $data['open_time'] ?? null,
                'close_time' => $data['close_time'] ?? null,
                'is_closed' => isset($data['is_closed']),
            ]);
        }

        return back()->with('success', 'Working hours updated.');
    }
}
