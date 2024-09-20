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
            <h1 class="text-lg font-bold">View Team Detail</h1>

            <div class="text-sm breadcrumbs">
                <ul>
                    <li>Dashboard</li>
                    <li>Manage Contests</li>
                    <li class="text-gray-500">View Team</li>
                </ul>
            </div>
        </div>

        <div class="card shadow bg-base-100">
            <div class="card-body">
                <div>
                    @livewire('team-detail-view', ['model' => $team])
                </div>
                <div class="mb-2">
                    @livewire('team-members-table-view', ['team' => $team, 'readOnly' => true])
                </div>
                <div class="mb-2">
                    @livewire('answers-table-view', ['team' => $team, 'allowCreate' => false])
                </div>`
            </div>
        </div>

    </div>
@endsection
