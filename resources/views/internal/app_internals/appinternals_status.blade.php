<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-8">

    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow-md">
        <h1 class="text-2l font-semibold mb-6">App Internals status</h1>

        <table class="min-w-full bg-white border border-gray-300">
            <tbody>
                @foreach ($array_status as $key => $value)
                <tr>
                    <td class="py-2 px-4 border-b border-r"><b>{{ $key }}</b></td>
                    <td class="py-2 px-4 border-b">{{ is_array($value) ? var_dump($value) : $value }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow-md">
        <h1 class="text-2l font-semibold mb-6">Actions</h1>

        <table class="min-w-full bg-white border border-gray-300">
            <tbody>
                <tr>
                    <td class="py-2 px-4 border-b">Git Pull</td>
                    <td><button class="text-blue-500 underline" onclick="onClickOpenInNewWindow('{{ route('app-internals-gitpull') }}')">Update the current branch (New Window)</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

<script>
    // rewrite the url to avoid showing same login url
    window.history.pushState("", "", "/app-internals");

    function onClickOpenInNewWindow(url) {
        if (window.confirm('Warning : Site will be updated now. Are you sure?')) {
            window.open(url, '_blank');
        }
    }
</script>
</body>

</html>
