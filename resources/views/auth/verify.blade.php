@extends('layouts.auth')

@section('content')
    <div class="container mx-auto px-5">
        <div class="h-screen grid md:grid-cols-7 lg:grid-cols-5 xl:grid-cols-3 place-items-center">
            <div class="md:col-start-2 md:col-span-5 lg:col-start-2 lg:col-span-3 xl:col-start-2 xl:col-span-1">

                <div class=" card shadow-2xl bg-white">
                    <div class="card-body lg:px-10 text-center">
                        <h1 class="font-bold text-3xl text-center mb-5">
                            Confirm Your Email
                        </h1>
                        <p class="mb-4">
                            To complete the registration process, open the verification link sent to
                            <strong>{{ auth()->user()->email }}.</strong> If you haven't received a verification email, you
                            can request another one.
                        </p>

                        <x-blade-form action="{{ route('verification.resend') }}">
                            <button id="js-resend-verification" class="btn btn-primary w-full" type="submit" disabled>
                                Resend Verification Link
                                <span id="js-resend-verification-time"></span>
                            </button>
                        </x-blade-form>

                        <a href="{{ route('home') }}" class="btn btn-ghost">
                            <i class="bi-arrow-left me-2"></i>
                            Back to Homepage
                        </a>
                    </div>
                </div>

                @if (session('resent'))
                    <div class="alert alert-success mt-10 text-sm text-white" role="alert">
                        <i class="bi-check2-circle text-lg"></i>
                        The verification link has been successfully re-sent to your email.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const btn = document.getElementById("js-resend-verification");
        const time = document.getElementById("js-resend-verification-time");
        let interval = 30;
        let countdown = setInterval(() => {
            if (interval > 0) {
                time.innerText = "(" + (--interval) + "s)";
            } else {
                time.innerText = "";
                clearInterval(countdown);
            }
        }, 1000);

        setTimeout(() => {
            btn.disabled = false;
        }, 30000);
    </script>
@endsection
