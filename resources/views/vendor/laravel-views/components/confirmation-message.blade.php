<div x-data="{ action: 'null', id: 'null', message: 'null' }" @keydown.escape="document.getElementById('lv_modal').close()" x-init="$wire.on('openConfirmationModal', (actionObject) => {
    document.getElementById('lv_modal').showModal();
    action = actionObject.id;
    id = actionObject.modelId;
    message = actionObject.message;
})">
    <x-lv-modal>
        <h6 class="font-bold text-lg">Confirmation</h6>
        <p x-text='message' class="py-4"></p>
        <div class="mt-4 flex flex-col gap-y-1 sm:flex-row-reverse sm:justify-start sm:gap-y-0 sm:gap-x-2">
            <button
                @click="$wire.call('confirmAndExecuteAction', action, id, false); document.getElementById('lv_modal').close()"
                wire:loading.attr="disabled" class="btn btn-primary shadow">
                {{ __('Proceed') }}
            </button>
            <button @click="document.getElementById('lv_modal').close()" wire:loading.attr="disabled"
                class="btn btn-ghost">
                {{ __('Cancel') }}
            </button>

            <x-lv-loading wire:loading />
        </div>
    </x-lv-modal>
</div>
