@extends('admin.layouts.app')

@section('title', 'Aýlyk hasaby')

@section('content')
    <h1 class="text-3xl font-bold">Aýlyk hasaby</h1>
    <p class="mt-1 text-slate-600">Aýy we ýyly saýlap, ähli işgärleriň hasabyny dörediň.</p>
    <form class="mt-6 flex flex-wrap items-end gap-3 rounded-xl bg-white p-5 shadow-sm" method="POST" action="{{ route('admin.payrolls.generate') }}">
        @csrf
        <label class="text-sm font-medium">Aý<select class="mt-1 block rounded-lg border border-slate-300 px-3 py-2" name="month" required>@foreach (range(1, 12) as $number)<option value="{{ $number }}" @selected($month == $number)>{{ $number }}</option>@endforeach</select></label>
        <label class="text-sm font-medium">Ýyl<input class="mt-1 block w-28 rounded-lg border border-slate-300 px-3 py-2" type="number" name="year" min="2000" max="2100" value="{{ $year }}" required></label>
        <button class="rounded-lg bg-blue-700 px-4 py-2 font-semibold text-white">Aýlygy hasapla</button>
    </form>
    <p class="mt-4 rounded-lg bg-blue-50 p-4 text-sm text-blue-900">Aýyrma: esasy aýlyk ÷ iş günleri × diňe “Gelmedi” ýazgylary. Şenbe, ýekşenbe we “Rugsatda” günleri aýyrma goşulmaýar. Salgyt: salgyt salynýan möçberiň 10%-i.</p>
    <div class="mt-5 overflow-x-auto rounded-xl bg-white shadow-sm"><table class="w-full text-left text-sm"><thead class="bg-slate-50 text-slate-600"><tr><th class="px-4 py-3">Işgär</th><th class="px-4 py-3">Bölüm</th><th class="px-4 py-3">Esasy aýlyk</th><th class="px-4 py-3">Bonus</th><th class="px-4 py-3">Aýyrma</th><th class="px-4 py-3">Salgyt</th><th class="px-4 py-3">Arassa aýlyk</th><th class="px-4 py-3">Ýagdaý</th></tr></thead><tbody class="divide-y divide-slate-100">
        @forelse ($payrolls as $payroll)<tr><td class="px-4 py-3 font-medium">{{ $payroll->employee->user->name }}</td><td class="px-4 py-3">{{ $payroll->employee->department->name }}</td><td class="px-4 py-3">{{ number_format($payroll->base_salary, 2) }}</td><td class="px-4 py-3">{{ number_format($payroll->bonus, 2) }}</td><td class="px-4 py-3">{{ number_format($payroll->deduction, 2) }}</td><td class="px-4 py-3">{{ number_format($payroll->tax, 2) }}</td><td class="px-4 py-3 font-semibold">{{ number_format($payroll->net_salary, 2) }}</td><td class="px-4 py-3">{{ $payroll->status === 'paid' ? 'Tölenen' : 'Taslama' }}</td></tr>@empty<tr><td class="px-4 py-5 text-slate-500" colspan="8">Saýlanan aý üçin hasap entek döredilmedi.</td></tr>@endforelse
    </tbody></table></div>
@endsection
