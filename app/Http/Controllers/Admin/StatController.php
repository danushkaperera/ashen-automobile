<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatController extends Controller
{
    public function index(): View
    {
        return view('admin.stats.index', [
            'stats' => Stat::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.stats.form', ['stat' => new Stat]);
    }

    public function store(Request $request): RedirectResponse
    {
        Stat::query()->create($this->payload($request, true));

        return redirect()->route('admin.stats.index')->with('success', 'Stat created.');
    }

    public function edit(Stat $stat): View
    {
        return view('admin.stats.form', compact('stat'));
    }

    public function update(Request $request, Stat $stat): RedirectResponse
    {
        $stat->update($this->payload($request));

        return redirect()->route('admin.stats.index')->with('success', 'Stat updated.');
    }

    public function destroy(Stat $stat): RedirectResponse
    {
        $stat->delete();

        return back()->with('success', 'Stat deleted.');
    }

    private function payload(Request $request, bool $creating = false): array
    {
        $data = $request->validate([
            'label' => ['required', 'string', 'max:120'],
            'value' => ['required', 'string', 'max:40'],
            'icon' => ['nullable', 'string', 'max:80'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
        $data['is_active'] = $creating ? $request->boolean('is_active', true) : $request->boolean('is_active');

        return $data;
    }
}
