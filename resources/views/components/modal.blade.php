@props(['id', 'title'])

<div x-show="{{ $id }}" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     style="display: none;"
     x-cloak>
    
    <!-- Backdrop dengan blur effect -->
    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
        <div class="absolute inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm" 
             @click="{{ $id }} = false"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>
    </div>

    <!-- Modal Dialog dengan animasi -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-xl rounded-xl shadow-2xl overflow-hidden"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <!-- Gradient Bar -->
            <div class="h-1.5 bg-gradient-to-r from-blue-500 via-sky-500 to-teal-500"></div>
            
            <!-- Header dengan shadow subtle -->
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-800 flex items-center space-x-2">
                        <i class="fas fa-edit text-blue-500"></i>
                        <span>{{ $title }}</span>
                    </h3>
                    <button @click="{{ $id }} = false" 
                            class="text-gray-400 hover:text-gray-500 hover:bg-gray-100 p-2 rounded-lg transition-colors duration-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Content dengan padding yang nyaman -->
            <div class="px-6 py-4">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

<style>
    /* Hide scrollbar when modal is open */
    body.modal-open {
        overflow: hidden;
    }
</style>

<script>
    // Toggle body scroll
    document.addEventListener('alpine:init', () => {
        Alpine.effect(() => {
            if ({{ $id }}) {
                document.body.classList.add('modal-open')
            } else {
                document.body.classList.remove('modal-open')
            }
        })
    })
</script>
