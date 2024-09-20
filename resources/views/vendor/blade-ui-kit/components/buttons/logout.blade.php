<form method="POST" action="{{ $action }}" class="flex">
    @csrf

    <button type="submit" {{ $attributes->merge(['class' => 'w-full text-start']) }}>
        {{ $slot->isEmpty() ? __('Log out') : $slot }}
    </button>
</form>
