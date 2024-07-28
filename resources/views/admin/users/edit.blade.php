@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Edit User</h1>
    <form action="{{ route('admin.users.update', $user) }}" method="POST" x-data="{ showErrors: false }" @submit.prevent="showErrors = true; $nextTick(() => $el.submit())">
        @csrf
        @method('PUT')

        {{-- Validation Modal --}}
        @include('admin.users.validation-modal')

        <div class="mb-4">
            <label for="uname" class="block text-gray-700">Username:</label>
            <input type="text" id="uname" name="uname" value="{{ $user->uname }}" required class="border border-gray-300 rounded p-2 w-full">
        </div>
        <div class="mb-4">
            <label for="pass" class="block text-gray-700">Password:</label>
            <input type="password" id="pass" name="pass" class="border border-gray-300 rounded p-2 w-full">
            <small class="text-gray-600">Leave blank to keep current password</small>
        </div>
        <div class="mb-4">
            <label for="pass_confirmation" class="block text-gray-700">Confirm Password:</label>
            <input type="password" id="pass_confirmation" name="pass_confirmation" class="border border-gray-300 rounded p-2 w-full">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Update</button>
    </form>
    <x-back-to-list-button route="{{ route('admin.users.index') }}" />
@endsection

</body>
</html>
