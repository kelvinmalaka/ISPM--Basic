@if (session()->has('message') || session()->has('error'))
    @php
        if (session()->has('message')) {
            $type = 'success';
            $title = 'Success!';
            $message = session('message');
        }
        if (session()->has('error')) {
            $type = 'error';
            $title = 'Error!';
            $message = session('error');
        }
    @endphp

    <div x-cloak x-data='{ open: false }' x-init="setTimeout(() => { open = true }, 300);
    setTimeout(() => { open = false }, 5000)">
        <div :id="$id('toast')" x-show="open" x-transition.duration.300
            class="fixed z-50 bottom-0 left-0 w-full p-4 md:w-1/2 md:right-0 md:p-8 md:left-auto xl:w-1/3 h-auto rounded">
            <div class="bg-white rounded p-4 flex items-center shadow-lg h-auto border-gray-200 border">
                <div class="mr-4 rounded-full h-10 w-10">
                    <div
                        class="flex items-end justify-center border-2 rounded-full {{ $type === 'success' ? 'bg-green-100 border-green-300 text-green-700' : 'bg-red-100 border-red-300 text-red-700' }}">
                        <i class="{{ $type === 'success' ? 'bi-check' : 'bi-x' }} text-3xl"></i>
                    </div>
                </div>

                <div class="flex-1">
                    <div class="text-gray-900 font-semibold">{{ $title }}</div>
                    <div class="text-sm">{{ $message }}</div>
                </div>

                <button @click.prevent='open = false'
                    class="text-gray-400 hover:text-gray-900 transition duration-300 ease-in-out cursor-pointer">
                    <i class="bi-x-circle"></i>
                </button>
            </div>
        </div>
    </div>
@endif
