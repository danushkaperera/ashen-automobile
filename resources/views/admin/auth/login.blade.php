<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin login</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="login-wrap">
    <form class="login-card" method="POST" action="{{ route('admin.login.store') }}">
        @csrf
        <img class="login-logo" src="{{ asset('images/logo.png') }}" alt="Auto Bridge">
        <h1>Auto Bridge Admin</h1>
        <p class="help">Sign in to customise the website frontend.</p>
        @if($errors->any())
            <div class="notice error">{{ $errors->first() }}</div>
        @endif
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <label class="check"><input type="checkbox" name="remember" value="1"> Remember me</label>
        <button class="btn" type="submit" style="margin-top:18px;width:100%">Log in</button>
        <p class="help" style="margin-top:16px">Default: admin@autobridge.co.nz / Admin@123<br><a href="{{ route('staff.login') }}">Workshop desk login</a></p>
    </form>
</div>
</body>
</html>
