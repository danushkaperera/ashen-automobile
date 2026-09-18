<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Workshop desk login</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="login-wrap">
    <form class="login-card" method="POST" action="{{ route('staff.login.store') }}">
        @csrf
        <img class="login-logo" src="{{ asset('images/logo.png') }}" alt="Auto Bridge">
        <h1>Workshop desk</h1>
        <p class="help">Staff portal for registering customers against workshop services.</p>
        @if($errors->any())
            <div class="notice error">{{ $errors->first() }}</div>
        @endif
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <label class="check"><input type="checkbox" name="remember" value="1"> Remember me</label>
        <button class="btn" type="submit" style="margin-top:18px;width:100%">Log in</button>
        <p class="help" style="margin-top:16px"><a href="{{ route('admin.login') }}">Admin login</a></p>
    </form>
</div>
</body>
</html>
