<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Include the Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded shadow-md w-full sm:w-96">

        <h2 class="text-2xl font-semibold mb-6">App Maintainence Page</h2>
        <h2 class="text-2xl font-semibold mb-6">SA Login</h2>

        <form action="{{ url('/app-internals/login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="user_code" class="block text-gray-600 text-sm font-medium mb-2">User code</label>
                <input type="text" id="user_code" name="user_code" class="w-full p-2 border border-gray-300 rounded">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-600 text-sm font-medium mb-2">Password</label>
                <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 rounded">
            </div>

            <button type="submit"
                class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">
                Login
            </button>
            @if ($errors->any())
                <div style="color: red;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>

    </div>

</body>

</html>
