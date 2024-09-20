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
            <h1 class="text-lg font-bold">Team Member Registration</h1>

            <div class="text-sm breadcrumbs">
                <ul>
                    <li>Contest</li>
                    <li>Register</li>
                    <li class="text-gray-500">Members</li>
                </ul>
            </div>
        </div>

        <div class="card shadow bg-base-100">
            <div class="card-body">
                <x-blade-form action="{{ $action }}" :method="$method" has-files>
                    <div class="mb-8">

                        <h2 class="text-base font-bold mb-5">
                            <i class="bi-person-circle mr-2"></i>
                            Member Detail
                        </h2>

                        <div class="form-control mb-2">
                            <x-blade-label for="name">Member Name</x-blade-label>
                            <x-blade-input name="name" class="input input-bordered"
                                value="{{ old('name', $member->name) }}" placeholder="Member Name" autocomplete="off"
                                autofocus required />
                            <x-blade-error field="name" />
                        </div>

                        <div class="form-control mb-2">
                            <x-blade-label for="email">Email</x-blade-label>
                            <x-blade-email class="input input-bordered" placeholder="Email"
                                value="{{ old('email', $member->email) }}" required />
                            <x-blade-error field="email" />
                        </div>

                        <div class="form-control mb-5">
                            <x-blade-label for="phone">Handphone</x-blade-label>
                            <x-blade-input name="phone" class="input input-bordered" placeholder="Handphone"
                                value="{{ old('phone', $member->phone) }}" required />
                            <x-blade-error field="phone" />
                        </div>

                        <div class="form-control mb-2">
                            <label class="label cursor-pointer justify-start">
                                <x-blade-checkbox id="is_leader" name="is_leader" class="checkbox checkbox-primary me-2"
                                    :checked="boolval(old('is_leader', $member->is_leader))" />
                                <span for="is_leader" class="label-text">Choose this member as the team leader.</span>
                            </label>
                        </div>

                        <div class="divider my-5"></div>

                        <h2 class="text-base font-bold mb-5">
                            <i class="bi-person-vcard-fill mr-3"></i>
                            National ID
                        </h2>

                        <div class="form-control mb-2">
                            <x-blade-label for="national_id">National ID</x-blade-label>
                            <x-blade-input name="national_id" class="input input-bordered" placeholder="National ID"
                                value="{{ old('national_id', $member->national_id) }}" required />
                            <x-blade-error field="national_id" />
                        </div>

                        <div class="form-control mb-2">
                            <x-blade-label for="national_id_file">National ID Card</x-blade-label>
                            <x-blade-input type="file" name="national_id_file"
                                class="file-input file-input-bordered file-input-accent" accept="image/*" />
                            <x-forms.input-helper :types="['jpg', 'png']" size="1" />
                            <x-blade-error field="national_id_file" />
                        </div>

                        <div class="divider my-5"></div>

                        <h2 class="text-base font-bold mb-5">
                            <i class="bi-person-vcard-fill mr-3"></i>
                            Student ID
                        </h2>

                        <div class="form-control mb-2">
                            <x-blade-label for="student_id">Student ID</x-blade-label>
                            <x-blade-input name="student_id" class="input input-bordered" placeholder="Student ID"
                                value="{{ old('student_id', $member->student_id) }}" required />
                            <x-blade-error field="student_id" />
                        </div>

                        <div class="form-control mb-10">
                            <x-blade-label for="student_id_file">Student ID Card</x-blade-label>
                            <x-blade-input type="file" name="student_id_file"
                                class="file-input file-input-bordered file-input-accent" accept="image/*" />
                            <x-forms.input-helper :types="['jpg', 'png']" size="1" />
                            <x-blade-error field="student_id_file" />
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
