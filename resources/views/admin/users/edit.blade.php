@extends('layouts.admin')

@section('content')
    <h1>Edit User</h1>
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="uname">Username:</label>
            <input type="text" id="uname" name="uname" value="{{ $user->uname }}" required>
        </div>
        <div>
            <label for="pass">Password:</label>
            <input type="password" id="pass" name="pass">
            <small>Leave blank to keep current password</small>
        </div>
        <div>
            <label for="pass_confirmation">Confirm Password:</label>
            <input type="password" id="pass_confirmation" name="pass_confirmation">
        </div>
        <button type="submit">Update</button>
    </form>
@endsection
