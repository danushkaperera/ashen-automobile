@extends('layouts.admin')
@section('title', $user->exists ? 'Edit staff user' : 'Add staff user')
@section('content')
@include('admin.staff._tabs')
<div class="tabs" data-form-tabs>
    <a href="#details" class="active" data-tab="details">Details</a>
    <a href="#access" data-tab="access">Page access</a>
</div>
<form class="card" method="POST" action="{{ $user->exists ? route('admin.staff.update', $user) : route('admin.staff.store') }}">
    @csrf
    @if($user->exists) @method('PUT') @endif
    <div data-panel="details">
        <label>Name</label>
        <input name="name" value="{{ old('name', $user->name) }}" required>
        <div class="form-grid">
            <div><label>Email</label><input type="email" name="email" value="{{ old('email', $user->email) }}" required></div>
            <div><label>Phone</label><input name="phone" value="{{ old('phone', $user->phone) }}"></div>
            <div>
                <label>Password @if($user->exists)<span class="help">(leave blank to keep current)</span>@endif</label>
                <input type="password" name="password" {{ $user->exists ? '' : 'required' }} minlength="6">
            </div>
        </div>
        <label class="check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $user->is_active ?? true))> Can sign in to the staff portal</label>
    </div>
    <div data-panel="access" hidden>
        <p class="help" style="margin-top:0">Tick the pages this person may open. Leave Admin dashboard unticked to keep them on the staff portal.</p>
        @foreach($groups as $group => $pages)
            <div class="perm-group">
                <h4>{{ $group }}</h4>
                <div class="perm-list">
                    @foreach($pages as $key => $page)
                        <label class="check">
                            <input type="checkbox" name="permissions[]" value="{{ $key }}" @checked(in_array($key, old('permissions', $selected), true))>
                            {{ $page['label'] }}
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    <button class="btn" style="margin-top:16px">Save staff user</button>
</form>
<script>
    document.querySelectorAll('[data-form-tabs] [data-tab]').forEach((tab) => {
        tab.addEventListener('click', (event) => {
            event.preventDefault();
            const name = tab.getAttribute('data-tab');
            document.querySelectorAll('[data-form-tabs] [data-tab]').forEach((item) => item.classList.toggle('active', item === tab));
            document.querySelectorAll('[data-panel]').forEach((panel) => {
                panel.hidden = panel.getAttribute('data-panel') !== name;
            });
        });
    });
    if (window.location.hash === '#access') {
        document.querySelector('[data-tab="access"]')?.click();
    }
</script>
@endsection
