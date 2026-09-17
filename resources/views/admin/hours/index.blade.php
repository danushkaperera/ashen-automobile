@extends('layouts.admin')
@section('title', 'Working hours')
@section('content')
<form class="card" method="POST" action="{{ route('admin.hours.update') }}">
    @csrf
    @method('PUT')
    <table class="table">
        <tr><th>Day</th><th>Opens</th><th>Closes</th><th>Closed</th></tr>
        @foreach($hours as $hour)
            <tr>
                <td>{{ $hour->day_name }}</td>
                <td><input name="hours[{{ $hour->id }}][open_time]" value="{{ $hour->open_time }}"></td>
                <td><input name="hours[{{ $hour->id }}][close_time]" value="{{ $hour->close_time }}"></td>
                <td><input type="checkbox" name="hours[{{ $hour->id }}][is_closed]" value="1" @checked($hour->is_closed)></td>
            </tr>
        @endforeach
    </table>
    <button class="btn">Save hours</button>
</form>
@endsection
