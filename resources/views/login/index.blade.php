<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    @vite('resources/css/app.css')
    @include('layouts.styles')
    <link href="https://fonts.googleapis.com/css2?family=Motiva+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body class="font-motiva-sans bg-gradient-to-r from-gray-800 via-gray-900 to-gray-800 flex items-center justify-center min-h-screen p-4">
    <div class="flex flex-col md:flex-row w-full max-w-screen-lg bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Left Side -->
        <div class="md:w-1/2 bg-zinc-900 text-white p-10 flex flex-col justify-center">
            <h1 class="text-4xl font-bold mb-6 text-gray-200">SewaRide</h1>
            <h2 class="text-2xl mb-8 text-gray-300">Sign In</h2>
            @if ($errors->any())
                <div class="bg-red-900 border border-red-700 text-red-300 p-4 mb-6 rounded-lg" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div class="relative">
                    <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-black"></i>
                    <input id="username" type="text" name="uname" placeholder="Account Name" class="w-full pl-10 pr-3 py-3 border border-zinc-600 rounded-lg text-gray-200 bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-blue-500" required autofocus />
                </div>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-black"></i>
                    <input id="password" type="password" name="pass" placeholder="Password" class="w-full pl-10 pr-3 py-3 border border-zinc-600 rounded-lg text-gray-200 bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-700 rounded" />
                        <label for="remember_me" class="ml-2 text-sm text-gray-400">Remember me</label>
                    </div>
                    <a href="#" class="text-sm text-blue-400 hover:text-blue-300">Forgot your password?</a>
                </div>
                <button type="submit" class="bg-blue-600 text-white p-3 rounded-lg w-full font-semibold hover:bg-blue-700 transition duration-300">Sign In</button>
            </form>
        </div>

        <!-- Right Side -->
        <div class="md:w-1/2 bg-gradient-to-b from-blue-500 to-purple-500 text-white p-12 flex flex-col justify-center hidden md:flex">
            <h2 class="text-4xl mb-6">Welcome to SewaRide!</h2>
            <p class="text-lg mb-4">Admin RosantiBike Motorent</p>
        </div>
    </div>
</body>
</html>
