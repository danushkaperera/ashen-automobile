<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SectionController extends Controller
{
    public function index(): View
    {
        return view('admin.sections.index', [
            'sections' => HomepageSection::ordered()->get(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'sections' => ['required', 'array'],
        ]);

        foreach ($request->input('sections', []) as $id => $data) {
            $section = HomepageSection::query()->find($id);
            if (! $section) {
                continue;
            }

            $section->update([
                'heading' => $data['heading'] ?? $section->heading,
                'subheading' => $data['subheading'] ?? $section->subheading,
                'is_enabled' => isset($data['is_enabled']),
                'sort_order' => (int) ($data['sort_order'] ?? $section->sort_order),
            ]);
        }

        return back()->with('success', 'Homepage sections updated. Reorder, rename or hide any block from the public site.');
    }
}
