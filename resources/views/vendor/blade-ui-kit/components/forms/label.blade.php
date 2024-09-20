<div class="label">
    <label for="{{ $for }}" {{ $attributes->merge(['class' => 'label-text']) }}>
        {{ $slot->isNotEmpty() ? $slot : $fallback }}
    </label>
</div>
