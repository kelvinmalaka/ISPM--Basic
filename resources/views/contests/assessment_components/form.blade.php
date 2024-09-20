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
            <h1 class="text-lg font-bold">{{ $title }}</h1>

            <div class="text-sm breadcrumbs">
                <ul>
                    <li>Dashboard</li>
                    <li>Manage Contest</li>
                    <li>Contest Category</li>
                    <li class="text-gray-500">{{ $title }}</li>
                </ul>
            </div>
        </div>

        <div class="card shadow bg-base-100">
            <div class="card-body">
                <x-blade-form action="{{ $action }}" :method="$method">

                    <div class="mb-8">

                        <div class="form-control mb-2">
                            <x-blade-label for="name" />
                            <x-blade-input name="name" class="input input-bordered"
                                value="{{ old('name', $assessmentComponent->name) }}"
                                placeholder="Uniqueness and Innovation" autocomplete="off" autofocus required />
                            <x-blade-error field="name" />
                        </div>

                        <div class="form-control mb-2">
                            <x-blade-label for="description" />
                            <x-blade-textarea name="description" class="textarea textarea-bordered"
                                placeholder="Assessment Component Description"
                                required>{{ old('description', $assessmentComponent->description) }}</x-blade-textarea>
                            <x-blade-error field="description" />
                        </div>

                        <div class="form-control mb-2">
                            <x-blade-label for="weight" />
                            <div class="input input-bordered flex items-center gap-2">
                                <x-blade-input type="number" name="weight" class="grow" placeholder="100"
                                    value="{{ old('weight', $assessmentComponent->weight) }}" autocomplete="off" required />
                                <div>%</div>
                            </div>
                            <x-forms.input-helper>Weight in percentage</x-forms.input-helper>
                            <x-blade-error field="weight" />
                        </div>

                    </div>

                    <div class="card-actions">
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
