@error($field, $bag)
    <div class="label">
        <div {{ $attributes->merge(['class' => 'label-text-alt text-error']) }}>
            @if ($slot->isEmpty())
                {{ $message }}
            @else
                {{ $slot }}
            @endif
        </div>
    </div>
@enderror
