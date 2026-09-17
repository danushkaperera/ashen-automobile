@extends('layouts.admin')
@section('title', 'Homepage sections')
@section('content')
<p class="help">Turn blocks on or off, rename headings, and change the order they appear on the homepage.</p>
<form class="card" method="POST" action="{{ route('admin.sections.update') }}">
    @csrf
    @method('PUT')
    <table class="table">
        <tr><th>Block</th><th>Heading</th><th>Subheading</th><th>Order</th><th>Visible</th></tr>
        @foreach($sections as $section)
            <tr>
                <td>{{ $section->label }}</td>
                <td><input name="sections[{{ $section->id }}][heading]" value="{{ $section->heading }}"></td>
                <td><input name="sections[{{ $section->id }}][subheading]" value="{{ $section->subheading }}"></td>
                <td style="width:90px"><input name="sections[{{ $section->id }}][sort_order]" value="{{ $section->sort_order }}"></td>
                <td><input type="checkbox" name="sections[{{ $section->id }}][is_enabled]" value="1" @checked($section->is_enabled)></td>
            </tr>
        @endforeach
    </table>
    <button class="btn" type="submit">Save sections</button>
</form>
@endsection
