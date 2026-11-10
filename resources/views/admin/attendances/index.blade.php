@extends('admin.layouts.app')

@section('title', 'Gatnaşyk')

@section('content')
    <div><h1 class="text-3xl font-bold">Gatnaşyk bellemek</h1><p class="mt-1 text-slate-600">Işgäriň senedäki ýagdaýyny belläň.</p></div>
    <form class="mt-6 grid gap-4 rounded-xl bg-white p-5 shadow-sm sm:grid-cols-4" method="POST" action="{{ route('admin.attendances.store') }}">
        @csrf
        <label class="text-sm font-medium">Işgär<select class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" name="employee_id" required><option value="">Saýlaň</option>@foreach ($employees as $employee)<option value="{{ $employee->id }}" @selected(old('employee_id') == $employee->id)>{{ $employee->user->name }} · {{ $employee->department->name }}</option>@endforeach</select></label>
        <label class="text-sm font-medium">Sene<input class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" type="date" name="date" value="{{ old('date', $date) }}" required></label>
        <label class="text-sm font-medium">Ýagdaý<select class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" name="status" required><option value="present">Geldi</option><option value="absent">Gelmedi</option><option value="leave">Rugsatda</option></select></label>
        <button class="self-end rounded-lg bg-blue-700 px-4 py-2 font-semibold text-white">Ýatda sakla</button>
    </form>
    <form class="mt-6 flex flex-wrap items-end gap-3" method="GET" action="{{ route('admin.attendances.index') }}"><label class="text-sm font-medium">Sene boýunça gör<input class="mt-1 block rounded-lg border border-slate-300 bg-white px-3 py-2" type="date" name="date" value="{{ $date }}"></label><button class="rounded-lg bg-slate-800 px-4 py-2 text-white">Görkez</button></form>
    <div class="mt-4 overflow-x-auto rounded-xl bg-white shadow-sm"><table class="w-full text-left text-sm"><thead class="bg-slate-50 text-slate-600"><tr><th class="px-4 py-3">Işgär</th><th class="px-4 py-3">Sene</th><th class="px-4 py-3">Ýagdaý</th></tr></thead><tbody class="divide-y divide-slate-100">
        @forelse ($attendances as $attendance)<tr><td class="px-4 py-3">{{ $attendance->employee->user->name }}</td><td class="px-4 py-3">{{ $attendance->date->format('d.m.Y') }}</td><td class="px-4 py-3">{{ ['present' => 'Geldi', 'absent' => 'Gelmedi', 'leave' => 'Rugsatda'][$attendance->status] }}</td></tr>@empty<tr><td class="px-4 py-5 text-slate-500" colspan="3">Bu senede ýazgy ýok.</td></tr>@endforelse
    </tbody></table></div>
@endsection
