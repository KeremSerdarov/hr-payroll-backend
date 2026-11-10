@extends('admin.layouts.app')

@section('title', $employee->exists ? 'Işgäri üýtget' : 'Işgär goş')

@section('content')
    @php($editing = $employee->exists)
    <div class="max-w-3xl rounded-xl bg-white p-6 shadow-sm">
        <h1 class="text-2xl font-bold">{{ $editing ? 'Işgäri üýtget' : 'Täze işgär' }}</h1>
        <form class="mt-6 grid gap-4 sm:grid-cols-2" method="POST" action="{{ $editing ? route('admin.employees.update', $employee) : route('admin.employees.store') }}">
            @csrf
            @if ($editing) @method('PUT') @endif
            <label class="text-sm font-medium">Ady<input class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" name="name" value="{{ old('name', $employee->user?->name) }}" required></label>
            <label class="text-sm font-medium">E-poçta<input class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" type="email" name="email" value="{{ old('email', $employee->user?->email) }}" required></label>
            <label class="text-sm font-medium">{{ $editing ? 'Täze parol (islege görä)' : 'Parol' }}<input class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" type="password" name="password" {{ $editing ? '' : 'required' }}></label>
            <label class="text-sm font-medium">Bölüm<select class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" name="department_id" required><option value="">Saýlaň</option>@foreach ($departments as $department)<option value="{{ $department->id }}" @selected(old('department_id', $employee->department_id) == $department->id)>{{ $department->name }}</option>@endforeach</select></label>
            <label class="text-sm font-medium">Wezipesi<input class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" name="position" value="{{ old('position', $employee->position) }}" required></label>
            <label class="text-sm font-medium">Esasy aýlyk<input class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" type="number" step="0.01" min="0" name="base_salary" value="{{ old('base_salary', $employee->base_salary) }}" required></label>
            <label class="text-sm font-medium">Işe başlan senesi<input class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" type="date" name="hired_at" value="{{ old('hired_at', $employee->hired_at?->format('Y-m-d')) }}" required></label>
            <div class="flex items-end gap-3"><button class="rounded-lg bg-blue-700 px-4 py-2 font-semibold text-white">Ýatda sakla</button><a class="rounded-lg bg-slate-100 px-4 py-2" href="{{ route('admin.employees.index') }}">Yza</a></div>
        </form>
    </div>
@endsection
