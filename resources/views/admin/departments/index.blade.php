@extends('admin.layouts.app')

@section('title', 'Bölümler')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div><h1 class="text-3xl font-bold">Bölümler</h1><p class="mt-1 text-slate-600">Işgär bölümlerini dolandyryň.</p></div>
        <a class="rounded-lg bg-blue-700 px-4 py-2 font-semibold text-white" href="{{ route('admin.departments.create') }}">+ Bölüm goş</a>
    </div>
    <div class="mt-6 overflow-x-auto rounded-xl bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-600"><tr><th class="px-4 py-3">Ady</th><th class="px-4 py-3">Düşündiriş</th><th class="px-4 py-3">Işgär sany</th><th class="px-4 py-3">Hereket</th></tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($departments as $department)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $department->name }}</td><td class="px-4 py-3">{{ $department->description ?: '—' }}</td><td class="px-4 py-3">{{ $department->employees_count }}</td>
                        <td class="flex gap-3 px-4 py-3"><a class="text-blue-700" href="{{ route('admin.departments.edit', $department) }}">Üýtget</a><form method="POST" action="{{ route('admin.departments.destroy', $department) }}" onsubmit="return confirm('Bölümi aýyrmalymy?')">@csrf @method('DELETE')<button class="text-red-700">Aýyr</button></form></td>
                    </tr>
                @empty
                    <tr><td class="px-4 py-5 text-slate-500" colspan="4">Bölüm ýok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
