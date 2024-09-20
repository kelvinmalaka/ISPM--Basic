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
            <h1 class="text-lg font-bold">Add Committee</h1>

            <div class="text-sm breadcrumbs">
                <ul>
                    <li>Dashboard</li>
                    <li>Manage Contest</li>
                    <li>Contest Category</li>
                    <li class="text-gray-500">Add Committee</li>
                </ul>
            </div>
        </div>

        <div class="card shadow bg-base-100">
            <div class="card-body">
                <x-blade-form action="{{ $action }}" :method="$method">

                    <div class="mb-8">

                        <div class="form-control">
                            <x-blade-label for="committee">Available Committee</x-blade-label>
                            <select name="committee" id="committee" class="select select-bordered w-full">
                                @foreach ($committees as $committee)
                                    <option value="{{ $committee->id }}">
                                        {{ $committee->user->name }} - {{ $committee->user->email }}
                                    </option>
                                @endforeach
                            </select>
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
