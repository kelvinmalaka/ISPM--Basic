@extends('layouts.auth')

@section('content')
    <div class="container mx-auto px-5">
        <div class="h-screen grid md:grid-cols-7 lg:grid-cols-5 xl:grid-cols-3 place-items-center">
            <div class="md:col-start-2 md:col-span-5 lg:col-start-2 lg:col-span-3 xl:col-start-2 xl:col-span-1">

                <div class=" card shadow-2xl bg-white">
                    <div class="card-body lg:px-10 text-center">
                        <h1 class="font-bold text-3xl text-center mb-3">
                            Confirm Password
                        </h1>
                        <p class="mb-4">
                            Please confirm your password before continuing.
                        </p>

                        <x-blade-form action="{{ route('password.confirm') }}">

                            <div class="form-control mb-5">
                                <x-blade-label for="password" />
                                <x-blade-password class="input input-bordered" placeholder="**********" autofocus
                                    required />
                                <x-blade-error field="password" />
                            </div>

                            <div class="mb-2">
                                <button class="btn btn-primary w-full" type="submit">
                                    Confirm Password
                                </button>
                            </div>

                            @if (Route::has('password.request'))
                                <div>
                                    <a class="btn btn-ghost w-full" href="{{ route('password.request') }}">
                                        Lupa Password
                                    </a>
                                </div>
                            @endif

                        </x-blade-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
