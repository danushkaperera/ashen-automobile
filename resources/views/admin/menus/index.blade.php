@extends('layouts.admin')
@section('title', 'Menus')
@section('content')
<div class="form-grid">
    @foreach(['header' => $headerItems, 'footer' => $footerItems] as $location => $items)
        <div class="card">
            <h3>{{ ucfirst($location) }} menu</h3>
            <table class="table">
                <tr><th>Label</th><th>URL</th><th></th></tr>
                @foreach($items as $item)
                    <tr>
                        <td colspan="3">
                            <form method="POST" action="{{ route('admin.menus.update', $item) }}" class="form-grid" style="align-items:end">
                                @csrf @method('PUT')
                                <input type="hidden" name="location" value="{{ $item->location }}">
                                <div><label>Label</label><input name="label" value="{{ $item->label }}"></div>
                                <div><label>URL</label><input name="url" value="{{ $item->url }}"></div>
                                <div><label>Order</label><input name="sort_order" value="{{ $item->sort_order }}"></div>
                                <div class="check"><input type="checkbox" name="is_active" value="1" @checked($item->is_active)> Active</div>
                                <button class="btn small" type="submit">Update</button>
                            </form>
                            <form method="POST" action="{{ route('admin.menus.destroy', $item) }}" style="margin-top:6px">@csrf @method('DELETE')<button class="btn small danger">Remove</button></form>
                        </td>
                    </tr>
                @endforeach
            </table>
            <form method="POST" action="{{ route('admin.menus.store') }}" style="margin-top:16px">
                @csrf
                <input type="hidden" name="location" value="{{ $location }}">
                <label>New label</label><input name="label" required>
                <label>URL</label><input name="url" required placeholder="/services">
                <label>Order</label><input name="sort_order" value="{{ $items->count() + 1 }}">
                <label class="check"><input type="checkbox" name="is_active" value="1" checked> Active</label>
                <button class="btn" style="margin-top:12px">Add to {{ $location }}</button>
            </form>
        </div>
    @endforeach
</div>
@endsection
