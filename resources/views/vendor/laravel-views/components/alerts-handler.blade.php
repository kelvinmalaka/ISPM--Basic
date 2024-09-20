<div x-cloak x-data='{ open: false, message: "", type: "success" }' x-init="$wire.on('notify', (notification) => {
    open = true;
    message = notification.message;
    type = notification.type;
    setTimeout(() => { open = false }, 5000)
})">
    <div :id="$id('alert')" x-show="open && type === 'danger'">
        <x-lv-alert type='danger' onClose='open = false' class="bg-red-100 border-red-300 text-red-700">
            <div x-text='message'></div>
        </x-lv-alert>
    </div>
    <div :id="$id('alert')" x-show="open && type === 'success'">
        <x-lv-alert onClose='open = false' class="bg-green-100 border-green-300 text-green-700">
            <div x-text='message'></div>
        </x-lv-alert>
    </div>
</div>
