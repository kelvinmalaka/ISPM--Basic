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
            <h1 class="text-lg font-bold">View Contest Category</h1>

            <div class="text-sm breadcrumbs">
                <ul>
                    <li>Dashboard</li>
                    <li>Manage Contest</li>
                    <li class="text-gray-500">View Category</li>
                </ul>
            </div>
        </div>

        <div class="card shadow bg-base-100">
            <div class="card-body">
                <div class="mb-2">
                    @livewire('category-detail-view', ['model' => $category])
                </div>

                <div class="mb-3">
                    @livewire('committee-permissions-table-view', ['category' => $category])
                </div>

                <div class="mb-3">
                    @livewire('answer-types-table-view', ['category' => $category])
                </div>

                <div>
                    @livewire('assessment-components-table-view', ['category' => $category])
                </div>
            </div>
        </div>

    </div>
@endsection
