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
            <h1 class="text-lg font-bold">Assessment</h1>

            <div class="text-sm breadcrumbs">
                <ul>
                    <li>Dashboard</li>
                    <li>Assessments</li>
                    <li class="text-gray-500">Create</li>
                </ul>
            </div>
        </div>

        <div class="card shadow bg-base-100">
            <div class="card-body">
                <div>
                    @livewire('answer-detail-view', ['model' => $answer])
                </div>

                <div class="divider"></div>

                <h2 class="font-bold text-lg mb-2">
                    Assessment
                </h2>
                <x-blade-form action="{{ $action }}" :method="$method">
                    @foreach ($assessments as $index => $assessment)
                        <div class="my-4 p-4 md:p-6 border rounded-lg">
                            <div class="mb-4">
                                <p class="font-bold">{{ $assessment->component->name }}
                                    ({{ $assessment->component->weight }}%)
                                </p>
                                <p>{{ $assessment->component->description }}</p>
                            </div>

                            <x-blade-input type="hidden" name="assessments[{{ $index }}][id]"
                                value="{{ $assessment->component->id }}" />

                            <div class="form-control mb-2">
                                <x-blade-label for="score-{{ $assessment->component->id }}">Score</x-blade-label>
                                <x-blade-input type="number" id="score-{{ $assessment->component->id }}"
                                    name="assessments[{{ $index }}][score]" class="input input-bordered"
                                    value="{{ old('assessments[' . $index . '][score]', $assessment->score) }}"
                                    min="0" max="100" autocomplete="off" required />
                                <x-blade-error field="assessments[{{ $index }}][score]" />
                            </div>

                            <div class="form-control mb-2">
                                <x-blade-label for="feedback-{{ $assessment->component->id }}">Feedback</x-blade-label>
                                <x-blade-textarea id="feedback-{{ $assessment->component->id }}"
                                    name="assessments[{{ $index }}][feedback]" class="textarea textarea-bordered"
                                    placeholder="Feedback"
                                    required>{{ old('assessments[' . $index . '][feedback]', $assessment->feedback) }}</x-blade-textarea>
                                <x-blade-error field="assessments[{{ $index }}][feedback]" />
                            </div>
                        </div>
                    @endforeach

                    <div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi-floppy mr-1"></i>
                            Submit Assessment
                        </button>
                    </div>
                </x-blade-form>

            </div>
        </div>

    </div>
@endsection
