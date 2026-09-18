@extends('layouts.admin')
@section('title', 'Page access')
@section('content')
@include('admin.staff._tabs')
<p class="help" style="margin-top:0">Choose which pages each staff member can open. Admin dashboard stays off unless you tick it.</p>
@if($users->isEmpty())
    <div class="card"><p class="help" style="margin:0">Add a staff user first, then set their page access here.</p></div>
@else
<form method="POST" action="{{ route('admin.staff.access.update') }}">
    @csrf
    @method('PUT')
    @foreach($users as $staff)
        <div class="card perm-card" id="staff-{{ $staff->id }}">
            <div class="toolbar">
                <div>
                    <h3 style="margin:0">{{ $staff->name }}</h3>
                    <p class="help" style="margin:4px 0 0">{{ $staff->email }}</p>
                </div>
                <a class="ghost" href="{{ route('admin.staff.edit', $staff) }}">Edit details</a>
            </div>
            @foreach($groups as $group => $pages)
                <div class="perm-group">
                    <h4>{{ $group }}</h4>
                    <div class="perm-list">
                        @foreach($pages as $key => $page)
                            <label class="check">
                                <input type="checkbox" name="permissions[{{ $staff->id }}][]" value="{{ $key }}" @checked(in_array($key, $staff->permissionKeys(), true))>
                                {{ $page['label'] }}
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
    <button class="btn" style="margin-top:8px">Save page access</button>
</form>
@endif
@endsection
