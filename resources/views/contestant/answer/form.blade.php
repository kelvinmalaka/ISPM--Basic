@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-10 py-8">

        <x-stepper-contest class="mb-5" :contest="$contest" active-step="answers" />

        <div class="flex justify-center sm:justify-start mb-2">
            <a href="{{ $back }}" class="btn btn-ghost text-primary p-0 hover:bg-transparent">
                <i class="bi-arrow-left me-2"></i>
                Kembali
            </a>
        </div>

        <div class="flex items-center flex-col sm:flex-row justify-center sm:justify-between mb-4">
            <h1 class="text-lg font-bold">Upload Team Answer</h1>

            <div class="text-sm breadcrumbs">
                <ul>
                    <li>Contest</li>
                    <li>Answers</li>
                    <li class="text-gray-500">Upload</li>
                </ul>
            </div>
        </div>

        <div class="card shadow bg-base-100">
            <div class="card-body">
                <x-blade-form action="{{ $action }}" :method="$method" has-files>
                    <div class="mb-8">

                        @foreach ($answerTypes as $index => $type)
                            <div class="form-control mb-3">
                                <x-blade-label for="type-{{ $type->id }}">
                                    <p class="font-bold text-base">{{ $type->name }}</p>
                                    <p>{{ $type->description }}</p>
                                </x-blade-label>
                                <x-blade-input type="file" id="type-{{ $type->id }}"
                                    name="answers[{{ $index }}][file]"
                                    class="file-input file-input-bordered file-input-accent"
                                    accept="{{ $type->mimetype }}" />
                                <x-forms.input-helper :types="$type->file_type" :size="$type->max_size" />
                                <x-blade-error field="answers.{{ $index }}.file" />

                                <x-blade-input type="hidden" name="answers[{{ $index }}][id]"
                                    value="{{ $type->id }}" />
                            </div>
                        @endforeach

                        <div class="divider"></div>

                        <div class="form-control mb-2">
                            <x-blade-label for="description" />
                            <x-blade-textarea name="description" class="textarea textarea-bordered"
                                placeholder="Answer Description"></x-blade-textarea>
                            <x-blade-error field="description" />
                        </div>

                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi-upload mr-2"></i>
                            Upload
                        </button>
                    </div>

                </x-blade-form>
            </div>
        </div>
    </div>
@endsection
