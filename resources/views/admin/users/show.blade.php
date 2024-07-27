@extends('layouts.admin')

@section('content')
    <h1>User Details</h1>
    <p>Username: {{ $user->uname }}</p>
    <a href="{{ route('admin.users.edit', $user) }}">Edit</a>
    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
    <x-back-to-list-button route="{{ route('admin.users.index') }}" />

@endsection
