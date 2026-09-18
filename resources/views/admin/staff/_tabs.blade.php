<div class="tabs">
    <a href="{{ route('admin.staff.index') }}" class="{{ request()->routeIs('admin.staff.index') ? 'active' : '' }}">Staff users</a>
    <a href="{{ route('admin.staff.access') }}" class="{{ request()->routeIs('admin.staff.access') ? 'active' : '' }}">Page access</a>
    <a href="{{ route('admin.staff.create') }}" class="{{ request()->routeIs('admin.staff.create') ? 'active' : '' }}">Add staff</a>
</div>
