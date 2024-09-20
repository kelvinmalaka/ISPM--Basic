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
            <h1 class="text-lg font-bold">{{ $title }}</h1>

            <div class="text-sm breadcrumbs">
                <ul>
                    <li>Dashboard</li>
                    <li>Manage Contests</li>
                    <li class="text-gray-500">{{ $title }}</li>
                </ul>
            </div>
        </div>

        <div class="card shadow bg-base-100">
            <div class="card-body">
                <x-blade-form action="{{ $action }}" :method="$method" has-files>

                    <div class="mb-8">

                        <div class="form-control mb-2">
                            <x-blade-label for="title" />
                            <x-blade-input name="title" class="input input-bordered"
                                value="{{ old('title', $contest->title) }}" placeholder="Judul Perlombaan"
                                autocomplete="off" autofocus required />
                            <x-blade-error field="title" />
                        </div>

                        <div class="form-control mb-2">
                            <x-blade-label for="description" />
                            <x-blade-textarea name="description" class="textarea textarea-bordered"
                                placeholder="Deskripsi Perlombaan" required>{{ $contest->description }}</x-blade-textarea>
                            <x-blade-error field="description" />
                        </div>

                        @can('create', $contest)
                            <div class="form-control">
                                <x-blade-label for="administrator" />
                                <select name="administrator" id="administrator" class="select select-bordered w-full">
                                    @foreach ($administrators as $administrator)
                                        <option value="{{ $administrator->id }}"
                                            {{ $administrator->id === $contest->administrator_id ? 'selected' : '' }}>
                                            {{ $administrator->user->name }} - {{ $administrator->user->email }} -
                                            {{ $administrator->user->trashed() ? 'Deactivated' : 'Active' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endcan

                        <div class="divider"></div>

                        <div class="form-control mb-2">
                            <x-blade-label for="guide_file">Guide Document</x-blade-label>
                            <x-blade-input type="file" name="guide_file"
                                class="file-input file-input-bordered file-input-accent" accept="application/pdf" />
                            <x-forms.input-helper types="pdf" size="5" />
                            <x-blade-error field="guide_file" />
                        </div>

                        <div class="form-control">
                            <x-blade-label for="banner_img">Banner Image</x-blade-label>
                            <x-blade-input type="file" name="banner_img"
                                class="file-input file-input-bordered file-input-accent"
                                accept="image/jpg,image/jpeg,image/png" />
                            <x-forms.input-helper :types="['jpg', 'jpeg', 'png']" size="1" />
                            <x-blade-error field="banner_img" />
                        </div>

                    </div>

                    <div>
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
