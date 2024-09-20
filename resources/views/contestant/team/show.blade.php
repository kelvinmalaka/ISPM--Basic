@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-10 py-8">

        <x-stepper-contest class="mb-5" :contest="$team->contest" active-step="registration" />

        <div class="card shadow bg-base-100">
            <div class="card-body">

                <h2 class="text-base font-bold mb-2">
                    Team Detail
                </h2>
                <table class="table mb-2">
                    <tbody>
                        <tr class="hover">
                            <td>Contest</td>
                            <td>{{ $team->contest->title }}</td>
                        </tr>
                        <tr class="hover">
                            <td>Contest Category</td>
                            <td>{{ $team->category->title }}</td>
                        </tr>
                        <tr class="hover">
                            <td>Maximum Team Member</td>
                            <td>{{ $team->category->max_team_member }} Person</td>
                        </tr>
                        <tr class="hover">
                            <td>Team Name</td>
                            <td>{{ $team->name }}</td>
                        </tr>
                        <tr class="hover">
                            <td>University</td>
                            <td>{{ $team->university }}</td>
                        </tr>
                        <tr>
                            <td>
                                Registration Status
                            </td>
                            <td
                                class="font-bold {{ $team->registration->status->usid === 'rejected' ? 'text-error' : 'text-primary' }}">
                                {{ $team->registration->status->title }}
                            </td>
                        </tr>
                        @if ($team->registration->status->usid === 'rejected')
                            <tr>
                                <td>Registration Description</td>
                                <td>{{ $team->registration->description }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <div class="mb-5">
                    @livewire('team-members-table-view', ['team' => $team])
                </div>

                <div class="card-action">
                    @can('access', [$team, 'answer'])
                        <div>
                            <a href="{{ $actions['answer'] }}" class="btn btn-primary">
                                Upload Answers
                                <i class="bi-arrow-right ml-2"></i>
                            </a>
                        </div>
                    @endcan

                    @can('update', $team)
                        <a href="{{ $actions['edit'] }}" class="btn btn-outline btn-primary">
                            <i class="bi-pencil mr-1"></i>
                            Edit
                        </a>
                    @endcan

                    @can('register', $team)
                        <x-blade-form action="{{ $actions['register'] }}" method="POST" class="inline-block">
                            <button class="btn btn-primary">
                                <i class="bi-floppy mr-1"></i>
                                Submit Registration
                            </button>
                        </x-blade-form>
                    @endcan
                </div>

            </div>
        </div>
    </div>
@endsection
