@extends('admin.layouts.app')

@section('title', 'Işgärler')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div><h1 class="text-3xl font-bold">Işgärler</h1><p class="mt-1 text-slate-600">Işgär hasaplaryny we iş maglumatlaryny dolandyryň.</p></div>
        <a class="rounded-lg bg-blue-700 px-4 py-2 font-semibold text-white" href="{{ route('admin.employees.create') }}">+ Işgär goş</a>
    </div>
    <div class="mt-6 overflow-x-auto rounded-xl bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-600"><tr><th class="px-4 py-3">Işgär</th><th class="px-4 py-3">E-poçta</th><th class="px-4 py-3">Bölüm</th><th class="px-4 py-3">Wezipesi</th><th class="px-4 py-3">Aýlygy</th><th class="px-4 py-3">Hereket</th></tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($employees as $employee)
                    <tr><td class="px-4 py-3 font-medium">{{ $employee->user->name }}</td><td class="px-4 py-3">{{ $employee->user->email }}</td><td class="px-4 py-3">{{ $employee->department->name }}</td><td class="px-4 py-3">{{ $employee->position }}</td><td class="px-4 py-3">{{ number_format($employee->base_salary, 2) }}</td>
                        <td class="flex gap-3 px-4 py-3"><a class="text-blue-700" href="{{ route('admin.employees.edit', $employee) }}">Üýtget</a><form method="POST" action="{{ route('admin.employees.destroy', $employee) }}" onsubmit="return confirm('Işgäriň hasabyny we bagly ýazgylaryny aýyrmalymy?')">@csrf @method('DELETE')<button class="text-red-700">Aýyr</button></form></td>
                    </tr>
                @empty
                    <tr><td class="px-4 py-5 text-slate-500" colspan="6">Işgär ýok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
