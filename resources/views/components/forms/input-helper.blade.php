<div class="label pb-0">
    <span class="label-text-alt text-gray-500 dark:text-gray-300">
        {{ $slot }}

        @if (isset($types))
            Supported file types: {{ strtoupper(implode(', ', $types)) }}
        @endif

        @if (isset($size))
            (MAX {{ $size }})
        @endif
    </span>
</div>
