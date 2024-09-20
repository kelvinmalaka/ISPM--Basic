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
            <h1 class="text-lg font-bold">Validate Team Answers</h1>

            <div class="text-sm breadcrumbs">
                <ul>
                    <li>Dashboard</li>
                    <li>Answers</li>
                    <li class="text-gray-500">Validate</li>
                </ul>
            </div>
        </div>

        <div class="card shadow bg-base-100">
            <div class="card-body">
                <div>
                    @livewire('answer-detail-view', ['model' => $answer])
                </div>
                <div class="mb-2">
                    @livewire('answers-table-view', ['team' => $team, 'allowCreate' => false])
                </div>

                <div class="divider"></div>

                <div>
                    <h2 class="font-bold text-lg mb-2">
                        Answer Validation
                    </h2>
                </div>
                <x-blade-form action="{{ $action }}" :method="$method">

                    <div class="mb-8">

                        <x-blade-input type="hidden" name="answer" value="{{ $answer->id }}" />

                        <div class="form-control mb-2">
                            <x-blade-label for="description" />
                            <x-blade-textarea name="description" class="textarea textarea-bordered"
                                placeholder="Deskripsi Validasi" required>{{ old('description') }}</x-blade-textarea>
                            <x-blade-error field="description" />
                        </div>

                        <div class="form-control">
                            <x-blade-label for="status">Hasil Validasi</x-blade-label>
                            <select name="status" id="status" class="select select-bordered w-full">
                                <option value="">-- Choose an option --</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}">
                                        {{ $status->title }} - {{ $status->description }}
                                    </option>
                                @endforeach
                            </select>
                            <x-blade-error field="status" />
                        </div>

                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi-floppy me-2"></i>
                            Submit
                        </button>
                    </div>

                </x-blade-form>
            </div>
        </div>
    </div>
@endsection
