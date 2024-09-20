@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-10 py-8">
        <div class="flex justify-center sm:justify-start mb-2">
            <a href="{{ $back }}" class="btn btn-ghost text-primary p-0 hover:bg-transparent">
                <i class="bi-arrow-left me-2"></i>
                Kembali
            </a>
        </div>

        <div class="text-center mb-10">
            <h1 class="text-2xl font-bold mb-4">
                Switch User Role
            </h1>
            <p class="text-gray-500">
                Shown below are roles which available for your account.
                <br />
                Current active role can be seen on navigation bar.
            </p>
        </div>

        <div class="flex flex-col justify-center items-center gap-4">
            @if ($roles->count() > 0)
                @foreach ($roles as $role)
                    <div>
                        <a class="btn btn-outline btn-primary" href="{{ $role->route }}">
                            {{ ucfirst($role->title) }}
                            <i class="bi-arrow-right ml-2"></i>
                        </a>
                    </div>
                @endforeach
            @else
                <div class="py-10 border-t">
                    <p class="text-center">
                        Currently you have <strong>no role assigned</strong>.
                        <br />
                        If you think this is a mistake, please contact Administrator.
                    </p>
                </div>
            @endif
        </div>

    </div>
@endsection
