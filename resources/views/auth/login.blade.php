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

                <div class="card shadow-xl bg-base-100">
                    <div class="card-body text-center gap-0">
                        <h1 class="font-bold text-3xl text-center mb-3">Sign In</h1>
                        <p class="mb-4">
                            Please enter your credentials to access Business and System Innovation
                            Challenge (BASIC).
                        </p>

                        <x-blade-form action="{{ route('login') }}">

                            <div class="form-control mb-2">
                                <x-blade-label for="email" />
                                <x-blade-email class="input input-bordered" autocomplete="email" placeholder="Email"
                                    autofocus required />
                                <x-blade-error field="email" />
                            </div>

                            <div class="form-control mb-2">
                                <x-blade-label for="password" />
                                <x-blade-password class="input input-bordered" placeholder="**********" required />
                                <x-blade-error field="password" />
                            </div>

                            <div class="mb-4 flex justify-between items-center">
                                <div class="form-control">
                                    <label class="label cursor-pointer">
                                        <x-blade-checkbox name="remember" class="checkbox checkbox-primary me-2" />
                                        <span for="remember" class="label-text">Remember me</span>
                                    </label>
                                </div>

                                <a href="{{ route('password.request') }}" class="text-sm text-primary link-hover">
                                    Forget Password
                                </a>
                            </div>

                            <div class="mb-2">
                                <button class="btn btn-primary w-full" type="submit">
                                    Login
                                </button>
                            </div>

                            <p class="text-dark-emphasis text-center text-sm">Don't have an account yet?
                                <a href="{{ route('register') }}" class="font-bold underline underline-offset-4 ms-1">
                                    Sign Up
                                </a>
                            </p>
                        </x-blade-form>

                        <div class="divider"></div>

                        <div>
                            <a href="{{ route('ms-login') }}" class="btn btn-info btn-sm text-white">
                                <i class="bi-microsoft me-2"></i>
                                Continue with Microsoft
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
