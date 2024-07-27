@extends('layouts.admin')

@section('content')
    <h1>Create User</h1>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div>
            <label for="uname">Username:</label>
            <input type="text" id="uname" name="uname" required>
        </div>
        <div>
            <label for="pass">Password:</label>
            <input type="password" id="pass" name="pass" required>
        </div>
        <div>
            <label for="pass_confirmation">Confirm Password:</label>
            <input type="password" id="pass_confirmation" name="pass_confirmation" required>
        </div>
        <button type="submit">Create</button>
    </form>
@endsection
