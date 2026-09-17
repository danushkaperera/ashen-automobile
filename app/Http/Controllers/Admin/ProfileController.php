<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\HandlesMedia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use HandlesMedia;

    public function edit(): View
    {
        return view('admin.profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email,'.$user->id],
            'phone' => ['nullable', 'string', 'max:40'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $data['avatar'] = $this->uploadImage($request, 'avatar', 'avatars', $user->avatar);

        if (! empty($data['password'])) {
            // hashed via User model cast
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return back()->with('success', 'Profile updated.');
    }
}
