{{-- table-view.table-view

Base layout to render all the UI componentes related to the table view, this is the main file for this view,
the rest of the files are included from here

You can customize all the html and css classes but YOU MUST KEEP THE BLADE AND LIVEWIERE DIRECTIVES

UI components used:
  - table-view.filters
  - components.alert
  - components.table
  - components.paginator --}}

<x-lv-layout>
    {{-- Search input and filters --}}
    <div class="py-4 px-0 pb-0">
        @include('laravel-views::components.toolbar.toolbar')
    </div>

    @if (count($items))
        {{-- Content table --}}
        <div class="overflow-x-scroll lg:overflow-x-visible">
            @include('laravel-views::components.table')
        </div>
    @else
        {{-- Empty data message --}}
        <div class="flex justify-center items-center p-4">
            <p class="text-center text-sm italic">
                {{ $emptyDataWords ?? __('No data available to show.') }}
            </p>
        </div>
    @endif

    {{-- Paginator, loading indicator and totals --}}
    @if (!isset($hidePagination) || !$hidePagination)
        <div class="py-4 px-0">
            {{ $items->links('vendor.laravel-views.table-view.pagination') }}
        </div>
    @endif
</x-lv-layout>
