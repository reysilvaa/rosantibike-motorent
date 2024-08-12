<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
     @include('layouts.styles')
     <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body class="font-lato bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100 flex items-center justify-center min-h-screen p-4">
    <div class="flex flex-col md:flex-row w-full max-w-screen-lg bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Left Side -->
        <div class="md:w-1/2 bg-gray-50 text-gray-900 p-10 flex flex-col justify-center">
            <h1 class="text-4xl font-bold mb-6 text-gray-800">RosantiBike Admin</h1>
            <h2 class="text-2xl mb-8 text-gray-600">Masuk</h2>
            <form id="loginForm" method="POST" action="{{ route('login') }}" class="space-y-6">
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
                        <label for="remember_me" class="ml-2 text-sm text-gray-400">Ingat saya</label>
                    </div>
                    <a href="https://wa.me/6285232152313?text=Saya%20lupa%20passwordnya" class="text-sm text-blue-400 hover:text-blue-300">Lupa Password?</a>
                </div>
                <button type="submit" class="bg-blue-600 text-white p-3 rounded-lg w-full font-semibold hover:bg-blue-700 transition duration-300">Sign In</button>
            </form>

        </div>

        <!-- Right Side -->
        <div class="md:w-1/2 bg-gradient-to-b from-blue-300 to-blue-500 text-white p-12 flex flex-col justify-center hidden md:flex">
            <h2 class="text-4xl mb-6">Selamat Kembali!</h2>
            <p class="text-lg mb-4">Admin RosantiBike Motorent</p>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#loginForm').on('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission

            // Gather form data
            var formData = $(this).serialize();

            // Make AJAX request
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Berhasil',
                        text: 'Selamat Datang Kembali.',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = response.redirect_url || '/admin';
                        }
                    });
                },
                error: function (xhr) {
                    // Handle errors (e.g., validation errors)
                    var errors = xhr.responseJSON.errors;
                    var errorList = '<ul>';
                    $.each(errors, function (key, value) {
                        $.each(value, function (index, error) {
                            errorList += '<li>' + error + '</li>';
                        });
                    });
                    errorList += '</ul>';

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: errorList,
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>
</body>
</html>
