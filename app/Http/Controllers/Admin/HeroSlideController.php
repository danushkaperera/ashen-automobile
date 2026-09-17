<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use App\Support\HandlesMedia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HeroSlideController extends Controller
{
    use HandlesMedia;

    public function index(): View
    {
        return view('admin.heroes.index', [
            'slides' => HeroSlide::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.heroes.form', ['slide' => new HeroSlide]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['image'] = $this->uploadImage($request, 'image', 'heroes');
        $data['is_active'] = $request->boolean('is_active', true);
        HeroSlide::query()->create($data);

        return redirect()->route('admin.heroes.index')->with('success', 'Hero slide created.');
    }

    public function edit(HeroSlide $hero): View
    {
        return view('admin.heroes.form', ['slide' => $hero]);
    }

    public function update(Request $request, HeroSlide $hero): RedirectResponse
    {
        $data = $this->validated($request);
        $data['image'] = $this->uploadImage($request, 'image', 'heroes', $hero->image);
        $data['is_active'] = $request->boolean('is_active');
        $hero->update($data);

        return redirect()->route('admin.heroes.index')->with('success', 'Hero slide updated.');
    }

    public function destroy(HeroSlide $hero): RedirectResponse
    {
        $hero->delete();

        return back()->with('success', 'Hero slide removed.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'subtitle' => ['nullable', 'string', 'max:180'],
            'description' => ['nullable', 'string', 'max:500'],
            'cta_text' => ['nullable', 'string', 'max:80'],
            'cta_url' => ['nullable', 'string', 'max:180'],
            'secondary_cta_text' => ['nullable', 'string', 'max:80'],
            'secondary_cta_url' => ['nullable', 'string', 'max:180'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
