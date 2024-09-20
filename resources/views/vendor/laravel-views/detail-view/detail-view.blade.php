<x-lv-layout>
    <div class="flex items-center mb-4">
        <div class="flex-1">
            @isset($title)
                <div class="font-bold text-2xl text-gray-900">
                    {{ $title }}
                </div>
            @endisset()

            @isset($subtitle)
                <span class="text-sm">{{ $subtitle }}</span>
            @endisset
        </div>


        @if (count($this->actions) > 0)
            <div class="flex justify-end">
                <x-lv-actions :actions="$this->actions" :model="$model" />
            </div>
        @endif
    </div>

    @foreach ($components as $component)
        <div class="mb-4">
            {!! $component !!}
        </div>
    @endforeach
</x-lv-layout>
