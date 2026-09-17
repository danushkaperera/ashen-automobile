<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(): View
    {
        return view('admin.menus.index', [
            'headerItems' => MenuItem::query()->where('location', 'header')->orderBy('sort_order')->get(),
            'footerItems' => MenuItem::query()->where('location', 'footer')->orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['open_in_new_tab'] = $request->boolean('open_in_new_tab');
        MenuItem::query()->create($data);

        return back()->with('success', 'Menu item added.');
    }

    public function update(Request $request, MenuItem $menu): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['open_in_new_tab'] = $request->boolean('open_in_new_tab');
        $menu->update($data);

        return back()->with('success', 'Menu item updated.');
    }

    public function destroy(MenuItem $menu): RedirectResponse
    {
        $menu->delete();

        return back()->with('success', 'Menu item removed.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'label' => ['required', 'string', 'max:80'],
            'url' => ['required', 'string', 'max:180'],
            'location' => ['required', 'in:header,footer'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
