{{-- Manage button --}}
@if (isset($manageAction))
    <a href="{{ $manageAction['route'] }}" class="btn btn-outline btn-sm btn-primary font-bold rounded-md">
        <i class="bi-{{ $manageAction['icon'] }} text-lg me-1"></i>
        {{ $manageAction['text'] }}
    </a>
@endif
