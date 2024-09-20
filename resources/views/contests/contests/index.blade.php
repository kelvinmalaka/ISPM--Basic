@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-10 py-8">

        <div class="flex items-center flex-col sm:flex-row justify-center sm:justify-between mb-4">
            <h1 class="text-lg font-bold">Manage Contests</h1>

            <div class="text-sm breadcrumbs">
                <ul>
                    <li>Dashboard</li>
                    <li class="text-gray-500">Manage Contests</li>
                </ul>
            </div>
        </div>

        <div class="card shadow bg-base-100">
            <div class="card-body">
                @livewire('contest-table-view', $table)
            </div>
        </div>

    </div>
@endsection
