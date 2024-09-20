<dialog id="lv_modal" class="modal modal-bottom sm:modal-middle shadow-lg" {{ $attributes }}>
    <div class="modal-box">
        {{ $slot }}
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
