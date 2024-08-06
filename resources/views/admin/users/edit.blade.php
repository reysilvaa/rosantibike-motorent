@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h1 class="text-2xl font-bold mb-6">Edit User</h1>
        <form action="{{ route('admin.users.update', $user) }}" method="POST" x-data="{ showErrors: false }" @submit.prevent="showErrors = true; $nextTick(() => $el.submit())">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                <label for="uname" class="block text-gray-700 text-right sm:pt-2">Username:</label>
                <div class="col-span-2">
                    <input type="text" id="uname" name="uname" value="{{ old('uname', $user->uname) }}" required class="border border-gray-300 rounded p-2 w-full">
                    @error('uname')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                <label for="pass" class="block text-gray-700 text-right sm:pt-2">Password:</label>
                <div class="col-span-2">
                    <input type="password" id="pass" name="pass" class="border border-gray-300 rounded p-2 w-full">
                    <small class="text-gray-600">Leave blank to keep current password</small>
                    @error('pass')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                <label for="pass_confirmation" class="block text-gray-700 text-right sm:pt-2">Confirm Password:</label>
                <div class="col-span-2">
                    <input type="password" id="pass_confirmation" name="pass_confirmation" class="border border-gray-300 rounded p-2 w-full">
                    @error('pass_confirmation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 hover:bg-blue-700">Update</button>
            </div>
        </form>
        <x-back-to-list-button route="{{ route('admin.users.index') }}" />
    </div>
</div>
@endsection
