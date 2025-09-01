<div 
    id="global-toast"
    x-data="{
        show: false,
        message: '',
        type: 'success',
        timeout: 5000,
        icon(type) {
            if (type === 'success') return 'M9 12l2 2 4-4';
            if (type === 'error') return 'M6 18L18 6M6 6l12 12';
            if (type === 'info') return 'M13 16h-1v-4h-1m1-4h.01';
            return 'M13 16h-1v-4h-1m1-4h.01';
        },
        showToast(msg, t = 'success', duration = 5000) {
            this.message = msg;
            this.type = t;
            this.timeout = duration;
            this.show = true;
            setTimeout(() => this.show = false, this.timeout);
        }
    }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed bottom-6 left-1/2 transform -translate-x-1/2 z-[10000]"
    style="display: none;"
>
    <div class="flex items-center space-x-3 px-4 py-3 rounded-xl shadow-lg border backdrop-blur-sm"
         :class="{
            'bg-green-50/90 border-green-200 text-green-800 dark:bg-green-900/40 dark:border-green-800 dark:text-green-200': type === 'success',
            'bg-red-50/90 border-red-200 text-red-800 dark:bg-red-900/40 dark:border-red-800 dark:text-red-200': type === 'error',
            'bg-blue-50/90 border-blue-200 text-blue-800 dark:bg-blue-900/40 dark:border-blue-800 dark:text-blue-200': type === 'info'
         }">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="icon(type)" />
        </svg>
        <span class="text-sm font-medium" x-text="message"></span>
    </div>
</div>

<script>
    window.Toast = {
        el: null,
        ensure() {
            if (!this.el) {
                this.el = document.getElementById('global-toast');
            }
            return this.el;
        },
        show(message, type = 'success', timeout = 5000) {
            const el = this.ensure();
            if (!el || !window.Alpine) return alert(message);
            window.Alpine.$data(el).showToast(message, type, timeout);
        }
    }
</script>


