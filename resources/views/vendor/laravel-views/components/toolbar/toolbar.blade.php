{{-- list-view.filters.blade

Renders the search input and the filters dropdown
You can customize all the html and css classes but YOU MUST KEEP THE BLADE AND LIVEWIERE DIRECTIVES
UI components used:
  - form/input-group
  - dropdown --}}

<div class="md:flex items-end">
    {{-- Title and search input --}}
    <div class="flex gap-x-3 flex-col flex-1 flex-wrap justify-between md:justify-normal">
        @include('laravel-views::components.toolbar.title')
        @include('laravel-views::components.toolbar.search')
    </div>

    {{-- Actions on the left --}}
    <div class="flex space-x-2 flex-1 justify-end items-center mb-4">
        <x-lv-loading class="mb-0" wire:loading />

        {{-- Bulk actions --}}
        <div>
            @include('laravel-views::components.toolbar.bulk-actions')
        </div>

        {{-- Sorting --}}
        @if (isset($sortableBy) && $sortableBy->isNotEmpty())
            <div class="border">
                @include('laravel-views::components.toolbar.sorting')
            </div>
        @endif

        {{-- Filters --}}
        <div class="border">
            @include('laravel-views::components.toolbar.filters')
        </div>

        {{-- Manage button --}}
        <div>
            @include('laravel-views::components.toolbar.manage-action')
        </div>
    </div>
</div>
