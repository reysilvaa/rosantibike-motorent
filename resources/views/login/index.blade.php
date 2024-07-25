<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Motiva+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body class="font-motiva-sans bg-gradient-to-r from-gray-800 via-gray-900 to-gray-800 flex items-center justify-center min-h-screen p-4">
    <div class="form-container bg-gradient-to-b from-gray-900 to-gray-800 p-8 rounded-md shadow-lg w-full max-w-md border border-gray-700">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-200">SIGN IN</h1>
        @if ($errors->any())
            <div class="bg-red-900 border border-red-700 text-red-300 p-4 mb-6 rounded" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-6">
                <label for="username" class="block text-sm font-medium text-gray-400 mb-2">SIGN IN WITH ACCOUNT NAME</label>
                <input id="username"
                       class="steam-input block w-full px-4 py-3 rounded text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm"
                       type="text"
                       name="uname"
                       required
                       autofocus>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-400 mb-2">PASSWORD</label>
                <input id="password"
                       class="steam-input block w-full px-4 py-3 rounded text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm"
                       type="password"
                       name="pass"
                       required>
            </div>
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-700 rounded">
                    <label for="remember_me" class="ml-2 text-sm text-gray-400">Remember me</label>
                </div>
                <a href="#" class="text-sm text-blue-400 hover:text-blue-300">Forgot your password?</a>
            </div>
            <button type="submit"
                    class="steam-button w-full py-3 px-4 rounded text-sm font-semibold text-white uppercase focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Sign in
            </button>
        </form>
    </div>
</body>
</html>
