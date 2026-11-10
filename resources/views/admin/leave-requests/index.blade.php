@extends('admin.layouts.app')

@section('title', 'Rugsat haýyşlary')

@section('content')
    <h1 class="text-3xl font-bold">Rugsat haýyşlary</h1>
    <p class="mt-1 text-slate-600">Haýyşlary gözden geçirip, tassyklaň ýa-da ret ediň.</p>
    <div class="mt-6 space-y-4">
        @forelse ($leaveRequests as $leaveRequest)
            <article class="rounded-xl bg-white p-5 shadow-sm">
                <div class="flex flex-wrap justify-between gap-3">
                    <div><h2 class="font-semibold">{{ $leaveRequest->employee->user->name }} · {{ $leaveRequest->employee->department->name }}</h2><p class="mt-1 text-sm text-slate-600">{{ $leaveRequest->start_date->format('d.m.Y') }} — {{ $leaveRequest->end_date->format('d.m.Y') }}</p></div>
                    <span class="h-fit rounded-full bg-slate-100 px-3 py-1 text-sm">{{ ['pending' => 'Garaşýar', 'approved' => 'Tassyklandy', 'rejected' => 'Ret edildi'][$leaveRequest->status] }}</span>
                </div>
                <p class="mt-3">{{ $leaveRequest->reason }}</p>
                @if ($leaveRequest->admin_comment)<p class="mt-1 text-sm text-slate-500">Admin düşündirişi: {{ $leaveRequest->admin_comment }}</p>@endif
                @if ($leaveRequest->status === 'pending')
                    <form class="mt-4 flex flex-wrap gap-3" method="POST" action="{{ route('admin.leave-requests.decide', $leaveRequest) }}">
                        @csrf
                        <input class="min-w-64 flex-1 rounded-lg border border-slate-300 px-3 py-2" name="admin_comment" placeholder="Admin düşündirişi (islege görä)">
                        <button class="rounded-lg bg-emerald-700 px-4 py-2 font-semibold text-white" name="status" value="approved">Tassykla</button>
                        <button class="rounded-lg bg-red-700 px-4 py-2 font-semibold text-white" name="status" value="rejected">Ret et</button>
                    </form>
                @endif
            </article>
        @empty
            <p class="rounded-xl bg-white p-5 text-slate-500 shadow-sm">Rugsat haýyşy ýok.</p>
        @endforelse
    </div>
@endsection
