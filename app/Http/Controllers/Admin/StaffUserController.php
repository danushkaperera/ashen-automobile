<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\StaffPermissions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StaffUserController extends Controller
{
    public function index(): View
    {
        return view('admin.staff.index', [
            'users' => User::query()->where('role', 'staff')->latest()->get(),
        ]);
    }

    public function access(): View
    {
        return view('admin.staff.access', [
            'users' => User::query()->where('role', 'staff')->orderBy('name')->get(),
            'groups' => StaffPermissions::grouped(),
        ]);
    }

    public function updateAccess(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['nullable', 'array'],
            'permissions.*.*' => ['string', Rule::in(StaffPermissions::keys())],
        ]);

        $submitted = $data['permissions'] ?? [];

        User::query()->where('role', 'staff')->get()->each(function (User $staff) use ($submitted) {
            $staff->update([
                'permissions' => array_values($submitted[$staff->id] ?? []),
            ]);
        });

        return redirect()->route('admin.staff.access')->with('success', 'Staff page access updated.');
    }

    public function create(): View
    {
        return view('admin.staff.form', [
            'user' => new User(['role' => 'staff', 'is_active' => true]),
            'groups' => StaffPermissions::grouped(),
            'selected' => StaffPermissions::defaults(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['role'] = 'staff';
        $data['is_admin'] = false;
        $data['is_active'] = $request->boolean('is_active', true);
        $data['permissions'] = $this->permissionsFrom($request);
        User::query()->create($data);

        return redirect()->route('admin.staff.index')->with('success', 'Staff portal user created. They can sign in at /staff/login.');
    }

    public function edit(User $staff): View
    {
        abort_unless($staff->isStaffMember(), 404);

        return view('admin.staff.form', [
            'user' => $staff,
            'groups' => StaffPermissions::grouped(),
            'selected' => $staff->permissionKeys(),
        ]);
    }

    public function update(Request $request, User $staff): RedirectResponse
    {
        abort_unless($staff->isStaffMember(), 404);

        $data = $this->validated($request, $staff);
        $data['is_active'] = $request->boolean('is_active');
        $data['permissions'] = $this->permissionsFrom($request);
        unset($data['role'], $data['is_admin']);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $staff->update($data);

        return redirect()->route('admin.staff.index')->with('success', 'Staff user updated.');
    }

    public function destroy(User $staff): RedirectResponse
    {
        abort_unless($staff->isStaffMember(), 404);
        $staff->delete();

        return back()->with('success', 'Staff user removed.');
    }

    private function validated(Request $request, ?User $user = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user?->id)],
            'phone' => ['nullable', 'string', 'max:40'],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:6'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', Rule::in(StaffPermissions::keys())],
        ]);
    }

    private function permissionsFrom(Request $request): array
    {
        return array_values(array_intersect(StaffPermissions::keys(), $request->input('permissions', [])));
    }
}
