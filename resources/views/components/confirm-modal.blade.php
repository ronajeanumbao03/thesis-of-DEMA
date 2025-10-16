<div
    x-data="{
        show: false,
        message: '',
        confirmText: 'Confirm',
        cancelText: 'Cancel',
        confirmAction: () => {},
        open(config) {
            this.message = config.message
            this.confirmText = config.confirmText || 'Confirm'
            this.cancelText = config.cancelText || 'Cancel'
            this.confirmAction = config.confirmAction
            this.show = true
        }
    }"
    x-show="show"
    x-cloak
    @show-confirm.window="open($event.detail)"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    x-transition
>
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md max-w-sm w-full">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Confirmation</h2>
        <p class="text-gray-600 dark:text-gray-300 mb-6" x-text="message"></p>
        <div class="flex justify-end gap-3">
            <button @click="show = false"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-300 dark:hover:bg-gray-600">
                <span x-text="cancelText"></span>
            </button>
            <button @click="confirmAction(); show = false"
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                <span x-text="confirmText"></span>
            </button>
        </div>
    </div>
</div>
