@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-10 py-8">
        <div class="flex justify-center sm:justify-start mb-2">
            <a href="{{ $back }}" class="btn btn-ghost text-primary p-0 hover:bg-transparent">
                <i class="bi-arrow-left me-2"></i>
                Back
            </a>
        </div>

        <figure class="bg-gray-200 w-full h-64 rounded-lg mb-8 overflow-hidden">
            <img src="{{ asset($contest->banner_img_path) }}" alt="Banner {{ $contest->title }}"
                class="object-cover w-full h-full" />
        </figure>

        <div class="flex items-center flex-col sm:flex-row justify-center sm:justify-between mb-4">
            <h1 class="text-2xl font-bold">{{ $contest->title }}</h1>

            <div class="flex gap-x-2">
                <a href="{{ $guide }}" class="btn btn-outline btn-primary" target="_blank">
                    <i class="bi-download mr-1"></i>
                    Event Guide
                </a>

                @if ($hasRegistered)
                    <a href="{{ $nextRoute }}" class="btn btn-primary">
                        Continue
                        <i class="bi-arrow-right ml-1"></i>
                    </a>
                @elseif ($isRegistrationOpen)
                    <a href="{{ $nextRoute }}" class="btn btn-primary">
                        Register
                        <i class="bi-arrow-right ml-1"></i>
                    </a>
                @endif
                </a>

            </div>
        </div>

        <div class="divider"></div>

        <div class="mb-8">
            <h2 class="text-lg font-semibold">Contest Description</h2>
            <p>{{ $contest->description }}</p>
        </div>

        <div class="mb-8">
            <h2 class="text-lg font-semibold">Contest Categories</h2>
            <ul class="list-inside list-disc">
                @foreach ($contest->categories as $category)
                    <li>{{ $category->title }}</li>
                @endforeach
            </ul>
        </div>

        <div class="mb-5">
            <h2 class="text-lg font-semibold">Contest Timeline</h2>
            <ul class="timeline timeline-vertical timeline-compact">
                @foreach ($contest->periods as $index => $period)
                    <li>
                        @if ($index > 0)
                            <hr />
                        @endif

                        <div class="timeline-middle">
                            <i class="bi-check-circle-fill text-gray-700"></i>
                        </div>
                        <div class="timeline-end py-2 ml-4">
                            <h3 class="font-semibold">{{ $period->type->title }}</h3>
                            <p class="text-sm text-gray-700">{{ $period->opened_at->translatedFormat('d F Y') }} -
                                {{ $period->closed_at->translatedFormat('d F Y') }}</p>
                        </div>

                        @if ($index < count($contest->periods) - 1)
                            <hr />
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
