@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-10 py-8">

        <div class="card shadow bg-base-100">
            <div class="card-body">
                <h2 class="card-title mb-3">Change Password</h2>

                <x-blade-form action="{{ $action }}" :method="$method">

                    <div class="mb-8">

                        <div class="form-control mb-2">
                            <x-blade-label for="current_password">Current Password</x-blade-label>
                            <x-blade-password name="current_password" class="input input-bordered" placeholder="**********"
                                autocomplete="off" autofocus required />
                            <x-blade-error field="current_password" />
                        </div>

                        <div class="form-control mb-2">
                            <x-blade-label for="password">New Password</x-blade-label>
                            <x-blade-password name="password" class="input input-bordered" placeholder="**********"
                                autocomplete="off" required />
                            <x-blade-error field="password" />
                        </div>

                        <div class="form-control mb-2">
                            <x-blade-label for="password_confirmation">Retype New Password</x-blade-label>
                            <x-blade-password name="password_confirmation" class="input input-bordered"
                                placeholder="**********" required />
                            <x-blade-error field="password_confirmation" />
                        </div>

                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi-floppy me-2"></i>
                            Save
                        </button>
                    </div>

                </x-blade-form>
            </div>
        </div>
    </div>
@endsection
