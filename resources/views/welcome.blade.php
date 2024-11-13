<!DOCTYPE html>
<html>
<head>
    <title>Insider Champions League</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div id="app" class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-center mb-6">Insider Champions League</h1>
        <controls></controls>
        <league-table></league-table>
        <games></games>
        <predictions></predictions>
    </div>
</body>
</html>
