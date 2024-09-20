@extends('layouts.auth')

@section('content')
    <div class="container mx-auto px-5">
        <div class="h-screen grid md:grid-cols-7 lg:grid-cols-5 xl:grid-cols-3 place-items-center">
            <div class="md:col-start-2 md:col-span-5 lg:col-start-2 lg:col-span-3 xl:col-start-2 xl:col-span-1">

                <div class="mb-2">
                    <a href="{{ route('login') }}" class="text-primary text-lg font-bold">
                        <i class="bi-arrow-left me-2"></i>
                        Kembali
                    </a>
                </div>

                <div class=" card shadow-2xl bg-white">
                    <div class="card-body lg:px-10 text-center">
                        <h1 class="font-bold text-3xl text-center mb-2">
                            Reset Password
                        </h1>
                        <p class="mb-4">
                            Enter your email address and we'll send you an email with instructions to reset your
                            password.
                        </p>

                        <x-blade-form action="{{ route('password.email') }}">

                            <div class="form-control mb-4">
                                <x-blade-label for="email" />
                                <x-blade-email class="input input-bordered" autocomplete="email" placeholder="Email"
                                    autofocus required />
                                <x-blade-error field="email" />
                            </div>

                            <button class="btn btn-primary w-full" type="submit">
                                Reset Password
                            </button>

                        </x-blade-form>
                    </div>
                </div>

                @if (session('status'))
                    <div class="alert alert-success mt-10 text-sm text-white" role="alert">
                        <i class="bi-check2-circle text-lg"></i>
                        Instruksi reset password berhasil dikirimkan ulang ke email Anda.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
