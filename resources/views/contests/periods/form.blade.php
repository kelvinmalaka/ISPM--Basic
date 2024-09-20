@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-10 py-8">

        <div class="flex justify-center sm:justify-start mb-2">
            <a href="{{ $back }}" class="btn btn-ghost text-primary p-0 hover:bg-transparent">
                <i class="bi-arrow-left me-2"></i>
                Kembali
            </a>
        </div>

        <div class="flex items-center flex-col sm:flex-row justify-center sm:justify-between mb-4">
            <h1 class="text-lg font-bold">Manage Contest Periods</h1>

            <div class="text-sm breadcrumbs">
                <ul>
                    <li>Dashboard</li>
                    <li>Manage Contest</li>
                    <li class="text-gray-500">Periods</li>
                </ul>
            </div>
        </div>

        <div class="card shadow bg-base-100">
            <div class="card-body">
                <x-blade-form action="{{ $action }}" :method="$method">

                    <div class="mb-8">

                        <div class="grid gap-y-10 md:gap-y-8 px-3 md:px-5">
                            @foreach ($periods as $index => $period)
                                <div class="grid items-center md:grid-cols-3 md:gap-x-5">
                                    <div class="mb-2">
                                        <h3 class="font-semibold">Periode {{ $period->type->title }}</h3>
                                        <p class="text-sm">{{ $period->type->description }}</p>
                                    </div>

                                    <div class="form-control">
                                        <x-blade-label for="period-{{ $period->type->id }}-open">Opened
                                            at:</x-blade-label>
                                        <x-blade-input type="datetime-local" name="periods[{{ $index }}][opened_at]"
                                            id="period-{{ $period->type->id }}-opened" class="input input-bordered"
                                            value="{{ old('periods[' . $index . '][opened_at]', $period->opened_at) }}" />
                                        <x-blade-error field="periods[{{ $index }}][opened_at]" />
                                    </div>

                                    <div class="form-control">
                                        <x-blade-label for="{{ $period->type->id }}-closed">Closed at:</x-blade-label>
                                        <x-blade-input type="datetime-local" name="periods[{{ $index }}][closed_at]"
                                            id="period-{{ $period->type->id }}-closed" class="input input-bordered"
                                            value="{{ old('periods[' . $index . '][closed_at]', $period->closed_at) }}" />
                                        <x-blade-error field="title" />
                                    </div>

                                    <x-blade-input type="hidden" name="periods[{{ $index }}][id]"
                                        value="{{ $period->type->id }}" />
                                </div>
                            @endforeach
                        </div>

                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi-floppy me-2"></i>
                            Simpan
                        </button>
                    </div>

                </x-blade-form>
            </div>
        </div>
    </div>
@endsection
