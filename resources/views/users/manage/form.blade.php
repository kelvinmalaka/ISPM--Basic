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
            <h1 class="text-lg font-bold">Create User</h1>

            <div class="text-sm breadcrumbs">
                <ul>
                    <li>Dashboard</li>
                    <li>Manage Users</li>
                    <li class="text-gray-500">Create User</li>
                </ul>
            </div>
        </div>

        <div class="card shadow bg-base-100">
            <div class="card-body">
                <x-blade-form action="{{ $action }}" :method="$method">

                    <div class="form-control mb-2">
                        <x-blade-label for="name">Full Name</x-blade-label>
                        <x-blade-input name="name" type="text" class="input input-bordered"
                            value="{{ old('name') }}" placeholder="Nama Lengkap" autocomplete="off" autofocus required />
                        <x-blade-error field="name" />
                    </div>

                    <div class="form-control mb-2">
                        <x-blade-label for="email" />
                        <x-blade-email class="input input-bordered" value="{{ old('email') }}" placeholder="Email"
                            autocomplete="off" required />
                        <x-blade-error field="email" />
                    </div>

                    <div class="form-control mb-2">
                        <x-blade-label for="password">Default Password</x-blade-label>
                        <x-blade-password class="input input-bordered" placeholder="**********" required />
                        <x-blade-error field="password" />
                    </div>

                    <div class="form-control mb-5">
                        <x-blade-label for="role">Default User Role</x-blade-label>
                        <select name="role" id="role" class="select select-bordered w-full">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->title) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="card-actions">
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
