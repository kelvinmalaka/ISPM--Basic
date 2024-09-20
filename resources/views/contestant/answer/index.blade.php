@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-10 py-8">

        <x-stepper-contest class="mb-5" :contest="$contest" active-step="answers" />

        @if ($isCaseDistributionOpen)
            <div class="card shadow bg-base-100 mb-5">
                <div class="card-body">

                    <div class="flex flex-wrap justify-between">
                        <div>
                            <h2 class="text-base font-bold mb-1">Case Document - {{ $category->title }}</h2>
                            <p class="text-sm text-gray-500">
                                Available to download until {{ $closeCaseDistributionPeriod }}
                            </p>
                        </div>
                        <a href="{{ $case }}" class="btn btn-primary w-fit">
                            <i class="bi-save mr-1"></i>
                            Download
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <div class="card shadow bg-base-100">
            <div class="card-body">

                <p class="text-sm text-gray-500">
                    Maximum upload is {{ $category->max_answer_uploads }} answers.
                </p>

                <div>
                    @livewire('answers-table-view', ['team' => $team, 'allowCreate' => $isSubmissionOpen])
                </div>

                <div class="card-action">
                    @if (auth()->user()->can('access', [$team, 'score']))
                        <div>
                            <a href="{{ $next }}" class="btn btn-primary">
                                Score Announcement
                                <i class="bi-arrow-right ml-1"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
