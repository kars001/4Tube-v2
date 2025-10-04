<div x-data="{
        toasts: [],
        notify(toast) {
            this.toasts.push(toast);
            setTimeout(() => this.toasts.shift(), 5000);
        }
    }"
    x-on:notify.window="notify($event.detail)"
    class="flex flex-col items-end fixed bottom-4 right-3 ml-3 space-y-2 z-50">

    <template x-for="(toast, index) in toasts" :key="index">
        <div x-show="true"
            class="flex items-center gap-3 px-4 py-3 rounded-md w-fit bg-third shadow-md shadow-121212">

            <!-- Error Icon -->
            <svg x-show="toast.type === 'error'" class="min-w-7 h-7 bg-[#991b1b] text-[#fecaca] p-1 rounded-md"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
            </svg>

            <!-- Info Icon -->
            <svg x-show="toast.type === 'info'" class="min-w-7 h-7 bg-[#9c4221] text-[#fbd38d] p-1 rounded-md"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
            </svg>

            <!-- Success Icon -->
            <svg x-show="toast.type === 'success'" class="min-w-7 h-7 bg-[#065f46] text-[#a7f3d0] p-1 rounded-md"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
            </svg>

            <span class="text-gray-300 text-[15px]" x-text="toast.message"></span>
        </div>
    </template>
</div>
