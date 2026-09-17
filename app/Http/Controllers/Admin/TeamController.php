<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use App\Support\HandlesMedia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamController extends Controller
{
    use HandlesMedia;

    public function index(): View
    {
        return view('admin.team.index', [
            'members' => TeamMember::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.team.form', ['member' => new TeamMember]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['photo'] = $this->uploadImage($request, 'photo', 'team');
        $data['is_active'] = $request->boolean('is_active', true);
        TeamMember::query()->create($data);

        return redirect()->route('admin.team.index')->with('success', 'Team member added.');
    }

    public function edit(TeamMember $team): View
    {
        return view('admin.team.form', ['member' => $team]);
    }

    public function update(Request $request, TeamMember $team): RedirectResponse
    {
        $data = $this->validated($request);
        $data['photo'] = $this->uploadImage($request, 'photo', 'team', $team->photo);
        $data['is_active'] = $request->boolean('is_active');
        $team->update($data);

        return redirect()->route('admin.team.index')->with('success', 'Team member updated.');
    }

    public function destroy(TeamMember $team): RedirectResponse
    {
        $team->delete();

        return back()->with('success', 'Team member removed.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'role' => ['nullable', 'string', 'max:120'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'phone' => ['nullable', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:150'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
