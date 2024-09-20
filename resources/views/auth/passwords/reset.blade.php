@extends('layouts.auth')

@section('content')
    <div class="container mx-auto px-5">
        <div class="h-screen grid md:grid-cols-7 lg:grid-cols-5 xl:grid-cols-3 place-items-center">
            <div class="md:col-start-2 md:col-span-5 lg:col-start-2 lg:col-span-3 xl:col-start-2 xl:col-span-1">

                <div class=" card shadow-2xl bg-white">
                    <div class="card-body lg:px-10">
                        <h1 class="font-bold text-3xl text-center mb-5">
                            Ubah Password
                        </h1>
                        <p class="mb-4">
                            Masukkan password baru Anda.
                        </p>

                        <x-blade-form action="{{ route('password.update') }}">

                            <x-blade-input type="hidden" name="token" value="{{ $token }}" />
                            <x-blade-input type="hidden" name="email" value="{{ old('email', $email) }}" />

                            <div class="form-control mb-2">
                                <x-blade-label for="emailview">Email</x-blade-label>
                                <input type="email" id="emailview" name="emailview" class="input input-bordered"
                                    value={{ old('email', $email) }} disabled required />
                                <x-blade-error field="emailview" />
                            </div>

                            <div class="form-control mb-2">
                                <x-blade-label for="password" />
                                <x-blade-password class="input input-bordered" placeholder="**********" autofocus
                                    required />
                                <x-blade-error field="password" />
                            </div>

                            <div class="form-control mb-4">
                                <x-blade-label for="password_confirmation">Konfirmasi Password</x-blade-label>
                                <x-blade-password name="password_confirmation" class="input input-bordered"
                                    placeholder="**********" required />
                                <x-blade-error field="password_confirmation" />
                            </div>

                            <button class="btn btn-primary w-full" type="submit">
                                Ubah Password
                            </button>

                        </x-blade-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
