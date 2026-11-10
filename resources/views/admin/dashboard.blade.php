@extends('admin.layouts.app')

@section('title', 'Baş sahypa')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Dolandyryş paneli</h1>
        <p class="mt-1 text-slate-600">Işgär we aýlyk maglumatlarynyň gysgaça görnüşi.</p>
    </div>
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ([['Işgärler', $employeeCount], ['Bölümler', $departmentCount], ['Garaşýan rugsatlar', $pendingLeaveCount], ['Şu günki gatnaşyklar', $attendanceCount]] as [$label, $value])
            <div class="rounded-xl bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">{{ $label }}</p>
                <p class="mt-2 text-3xl font-bold">{{ $value }}</p>
            </div>
        @endforeach
    </div>
    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <section class="rounded-xl bg-white p-5 shadow-sm">
            <h2 class="text-lg font-semibold">Soňky rugsat haýyşlary</h2>
            <div class="mt-4 divide-y divide-slate-100">
                @forelse ($recentLeaveRequests as $leaveRequest)
                    <div class="flex justify-between gap-3 py-3">
                        <span>{{ $leaveRequest->employee->user->name }}</span>
                        <span class="text-sm text-slate-500">{{ $leaveRequest->status }}</span>
                    </div>
                @empty
                    <p class="py-3 text-slate-500">Rugsat haýyşy ýok.</p>
                @endforelse
            </div>
        </section>
        <section class="rounded-xl bg-white p-5 shadow-sm">
            <h2 class="text-lg font-semibold">Soňky aýlyk ýazgylary</h2>
            <div class="mt-4 divide-y divide-slate-100">
                @forelse ($recentPayrolls as $payroll)
                    <div class="flex justify-between gap-3 py-3">
                        <span>{{ $payroll->employee->user->name }}</span>
                        <span class="text-sm text-slate-500">{{ $payroll->month }}/{{ $payroll->year }}</span>
                    </div>
                @empty
                    <p class="py-3 text-slate-500">Aýlyk hasaby entek döredilmedi.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection
