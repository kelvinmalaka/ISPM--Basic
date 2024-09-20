@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-10 py-8">

        <div class="flex justify-center sm:justify-start mb-1">
            <a href="{{ $back }}" class="btn btn-ghost text-primary p-0 hover:bg-transparent">
                <i class="bi-arrow-left me-2"></i>
                Kembali
            </a>
        </div>

        <div class="flex items-center flex-col sm:flex-row justify-center sm:justify-between mb-4">
            <h1 class="text-lg font-bold">{{ $contest->title }} - Registration</h1>

            <div class="text-sm breadcrumbs">
                <ul>
                    <li>Contest</li>
                    <li class="text-gray-500">Registration</li>
                </ul>
            </div>
        </div>

        <div class="card shadow bg-base-100">
            <div class="card-body">
                <x-blade-form action="{{ $action }}" :method="$method">
                    <div class="mb-8">

                        <div class="form-control mb-2">
                            <x-blade-label for="name">Team Name</x-blade-label>
                            <x-blade-input name="name" class="input input-bordered"
                                value="{{ old('name', $team->name) }}" placeholder="Team Name" autocomplete="off" autofocus
                                required />
                            <x-blade-error field="name" />
                        </div>

                        <div class="form-control mb-2">
                            <x-blade-label for="university" />
                            <x-blade-input name="university" class="input input-bordered"
                                value="{{ old('university', $team->university) }}" placeholder="University"
                                autocomplete="off" autofocus required />
                            <x-blade-error field="university" />
                        </div>

                        <div class="form-control">
                            <x-blade-label for="category">Contest Category</x-blade-label>
                            <select name="category" id="category" class="select select-bordered w-full">
                                @foreach ($contest->categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category', $team->contest_category_id) === $category->id ? 'selected' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">
                            Save
                            <i class="bi-arrow-right ml-2"></i>
                        </button>
                    </div>
                </x-blade-form>
            </div>
        </div>
    </div>
@endsection
