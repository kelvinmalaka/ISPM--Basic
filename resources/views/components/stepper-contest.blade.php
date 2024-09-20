<div {{ $attributes->merge(['class' => 'flex items-center justify-between text-base text-gray-600']) }}>
    @foreach ($steps as $index => $step)
        <div class="flex items-center">
            <div class="flex items-center justify-center gap-8 max-w-sm min-w-80">

                @if ($step['isActive'])
                    <a class="flex items-center gap-3.5 bg-indigo-50 p-3.5 rounded-xl relative z-10 border border-indigo-600 w-full"
                        href="{{ $step['canAccess'] ? $step['route'] : '#' }}">
                        <div class="rounded-lg bg-indigo-600 flex items-center justify-center w-10 h-10">
                            <span class="text-white text-base p-3">
                                <i class="bi-{{ $step['icon'] }}"></i>
                            </span>
                        </div>
                        <div class=" flex items-start rounded-md justify-center flex-col ">
                            <h6 class="text-base font-semibold text-black mb-0.5">
                                {{ $step['title'] }}
                            </h6>
                            <p class="text-xs text-gray-500">
                                {{ $step['openedTime'] }} - {{ $step['closedTime'] }}
                            </p>
                        </div>
                    </a>
                @else
                    <a class="flex items-center gap-3.5 bg-gray-50 p-3.5 rounded-xl relative z-10 border border-gray-200 w-full hover:border-indigo-600 transition-all"
                        href="{{ $step['canAccess'] ? $step['route'] : '#' }}">
                        <div class="rounded-lg bg-gray-200 flex items-center justify-center w-10 h-10">
                            <span class="text-base p-3">
                                <i class="bi-{{ $step['icon'] }}"></i>
                            </span>
                        </div>
                        <div class=" flex items-start rounded-md justify-center flex-col">
                            <h6 class="text-base font-semibold text-black mb-0.5">
                                {{ $step['title'] }}
                            </h6>
                            <p class="text-xs text-gray-500">
                                {{ $step['openedTime'] }} - {{ $step['closedTime'] }}
                            </p>
                        </div>
                    </a>
                @endif

            </div>
        </div>

        @unless ($index === count($steps) - 1)
            <div class="h-1 w-full border-b border-gray-300 border-1 mx-8"></div>
        @endunless
    @endforeach
</div>
