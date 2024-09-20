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
                                value="{{ old('name', $type->name) }}" placeholder="Project Proposals" autocomplete="off"
                                autofocus required />
                            <x-blade-error field="name" />
                        </div>

                        <div class="form-control mb-2">
                            <x-blade-label for="description" />
                            <x-blade-textarea name="description" class="textarea textarea-bordered"
                                placeholder="Answer File Description" required>{{ $type->description }}</x-blade-textarea>
                            <x-blade-error field="description" />
                        </div>

                        <div class="form-control mb-2">
                            <x-blade-label for="file_type">File Type</x-blade-label>
                            <select name="file_type" id="file_type" class="select select-bordered w-full">
                                @foreach ($validTypes as $validType)
                                    <option value="{{ $validType }}"
                                        {{ $type->file_type === $validType ? 'selected' : '' }}>
                                        {{ strtoupper($validType) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-control mb-2">
                            <x-blade-label for="max_size">Maximum File Size</x-blade-label>
                            <div class="input input-bordered flex items-center gap-2">
                                <x-blade-input type="number" name="max_size" class="grow" placeholder="Maximum File Size"
                                    value="{{ old('max_size', $type->max_size) }}" autocomplete="off" required />
                                <div>MB</div>
                            </div>
                            <x-forms.input-helper>Size in Megabytes (MB)</x-forms.input-helper>
                            <x-blade-error field="max_size" />
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
