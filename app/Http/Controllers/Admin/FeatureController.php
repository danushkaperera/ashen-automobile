<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeatureController extends Controller
{
    public function index(): View
    {
        return view('admin.features.index', [
            'features' => Feature::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.features.form', ['feature' => new Feature]);
    }

    public function store(Request $request): RedirectResponse
    {
        Feature::query()->create($this->payload($request, true));

        return redirect()->route('admin.features.index')->with('success', 'Feature created.');
    }

    public function edit(Feature $feature): View
    {
        return view('admin.features.form', compact('feature'));
    }

    public function update(Request $request, Feature $feature): RedirectResponse
    {
        $feature->update($this->payload($request));

        return redirect()->route('admin.features.index')->with('success', 'Feature updated.');
    }

    public function destroy(Feature $feature): RedirectResponse
    {
        $feature->delete();

        return back()->with('success', 'Feature deleted.');
    }

    private function payload(Request $request, bool $creating = false): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'description' => ['nullable', 'string', 'max:500'],
            'icon' => ['nullable', 'string', 'max:80'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
        $data['is_active'] = $creating ? $request->boolean('is_active', true) : $request->boolean('is_active');

        return $data;
    }
}
