@extends('layouts.auth')

@section('content')
    <div class="container mx-auto px-5">
        <div class="h-screen grid md:grid-cols-7 lg:grid-cols-5 xl:grid-cols-3 place-items-center">
            <div class="md:col-start-2 md:col-span-5 lg:col-start-2 lg:col-span-3 xl:col-start-2 xl:col-span-1">

                <div class="mb-2">
                    <a href="{{ route('home') }}" class="text-primary text-lg font-bold">
                        <i class="bi-arrow-left me-2"></i>
                        Back to Homepage
                    </a>
                </div>

                <div class="card shadow-xl bg-base-100 w-full">
                    <div class="card-body text-center gap-0">
                        <h1 class="font-bold text-3xl text-center mb-2">
                            Registration
                        </h1>
                        <p class="mb-3">
                            Please register an account to access Business and System Innovation Challenge (BASIC).
                        </p>

                        <x-blade-form action="{{ route('register') }}">
                            <div class="form-control mb-2">
                                <x-blade-label for="name" />
                                <x-blade-input name="name" type="text" class="input input-bordered"
                                    placeholder="Nama Lengkap" autocomplete="name" required autofocus />
                                <x-blade-error field="name" />
                            </div>

                            <div class="form-control mb-2">
                                <x-blade-label for="email" />
                                <x-blade-email class="input input-bordered" autocomplete="email" placeholder="Email"
                                    required />
                                <x-blade-error field="email" />
                            </div>

                            <div class="form-control mb-2">
                                <x-blade-label for="password" />
                                <x-blade-password class="input input-bordered" placeholder="**********" required />
                                <x-blade-error field="password" />
                            </div>

                            <div class="form-control mb-2">
                                <x-blade-label for="password_confirmation">Retype Password</x-blade-label>
                                <x-blade-password name="password_confirmation" class="input input-bordered"
                                    placeholder="**********" required />
                                <x-blade-error field="password_confirmation" />
                            </div>

                            <div class="form-control mb-4">
                                <label class="label cursor-pointer justify-start">
                                    <x-blade-checkbox name="agreement" class="checkbox checkbox-primary mr-3" required />
                                    <span for="agreement" class="label-text">
                                        I agree to the Terms and Conditions.
                                    </span>
                                </label>
                            </div>

                            <div class="mb-2">
                                <button class="btn btn-primary w-full" type="submit">
                                    Register
                                </button>
                            </div>

                            <p class="text-dark-emphasis text-center text-sm">Already have an account?
                                <a href="{{ route('login') }}" class="font-bold underline underline-offset-4 ms-1">
                                    Sign In
                                </a>
                            </p>
                        </x-blade-form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
