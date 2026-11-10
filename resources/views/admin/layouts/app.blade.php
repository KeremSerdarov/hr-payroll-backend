<!DOCTYPE html>
<html lang="tk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') · HR Payroll</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <header class="bg-slate-900 text-white shadow">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-6 py-4">
            <a class="text-xl font-bold" href="{{ route('admin.dashboard') }}">HR Payroll · Admin</a>
            <nav class="flex flex-wrap items-center gap-4 text-sm text-slate-200">
                <a class="hover:text-white" href="{{ route('admin.departments.index') }}">Bölümler</a>
                <a class="hover:text-white" href="{{ route('admin.employees.index') }}">Işgärler</a>
                <a class="hover:text-white" href="{{ route('admin.attendances.index') }}">Gatnaşyk</a>
                <a class="hover:text-white" href="{{ route('admin.leave-requests.index') }}">Rugsatlar</a>
                <a class="hover:text-white" href="{{ route('admin.payrolls.index') }}">Aýlyk</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="rounded bg-slate-700 px-3 py-2 hover:bg-slate-600">Çykmak</button>
                </form>
            </nav>
        </div>
    </header>
    <main class="mx-auto max-w-7xl px-6 py-8">
        @if (session('success'))
            <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                <p class="font-semibold">Maglumatlary barlaň:</p>
                <ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>
