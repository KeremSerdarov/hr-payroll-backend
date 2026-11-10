<!DOCTYPE html>
<html lang="tk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin girişi · HR Payroll</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="flex min-h-screen items-center justify-center bg-slate-100 px-4 text-slate-900">
    <main class="w-full max-w-md rounded-2xl bg-white p-8 shadow-lg">
        <h1 class="text-2xl font-bold">HR Payroll</h1>
        <p class="mt-2 text-slate-600">Admin paneline girmek üçin hasabyňyzy ulanyň.</p>
        @if ($errors->any())
            <div class="mt-5 rounded-lg bg-red-50 p-3 text-sm text-red-700">{{ $errors->first() }}</div>
        @endif
        <form class="mt-6 space-y-4" method="POST" action="{{ route('admin.login.store') }}">
            @csrf
            <label class="block text-sm font-medium">E-poçta
                <input class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </label>
            <label class="block text-sm font-medium">Parol
                <input class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" type="password" name="password" required>
            </label>
            <button class="w-full rounded-lg bg-blue-700 px-4 py-2 font-semibold text-white hover:bg-blue-800">Girmek</button>
        </form>
    </main>
</body>
</html>
