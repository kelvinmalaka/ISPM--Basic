@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-10 py-8">

        <x-stepper-contest class="mb-5" :contest="$contest" active-step="assessments" />

        <div class="card shadow bg-base-100">
            <div class="card-body">

                <p>Your team's overall score is: {{ $team->overall_score }}</p>

                <div>
                    <p>Answer uploaded at: {{ $team->answer->created_at }}</p>

                    @foreach ($team->answer->assessments as $assessment)
                        <ul class="my-3">
                            <li>Score: {{ $assessment->score }}</li>
                            <li>Feedback: {{ $assessment->feedback }}</li>
                        </ul>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
@endsection
