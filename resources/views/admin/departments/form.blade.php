@extends('admin.layouts.app')

@section('title', $department->exists ? 'Bölümi üýtget' : 'Bölüm goş')

@section('content')
    @php($editing = $department->exists)
    <div class="max-w-2xl rounded-xl bg-white p-6 shadow-sm">
        <h1 class="text-2xl font-bold">{{ $editing ? 'Bölümi üýtget' : 'Täze bölüm' }}</h1>
        <form class="mt-6 space-y-4" method="POST" action="{{ $editing ? route('admin.departments.update', $department) : route('admin.departments.store') }}">
            @csrf
            @if ($editing) @method('PUT') @endif
            <label class="block text-sm font-medium">Bölümiň ady<input class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" name="name" value="{{ old('name', $department->name) }}" required></label>
            <label class="block text-sm font-medium">Düşündiriş<textarea class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2" name="description" rows="4">{{ old('description', $department->description) }}</textarea></label>
            <div class="flex gap-3"><button class="rounded-lg bg-blue-700 px-4 py-2 font-semibold text-white">Ýatda sakla</button><a class="rounded-lg bg-slate-100 px-4 py-2" href="{{ route('admin.departments.index') }}">Yza</a></div>
        </form>
    </div>
@endsection
