<template>
  <Teleport to="body">
    <Transition
      enter-active-class="duration-300 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="duration-200 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="isOpen"
        class="fixed inset-0 z-50 overflow-y-auto"
        @click="handleBackdropClick"
      >
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
        
        <!-- Modal Container -->
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <Transition
            enter-active-class="duration-300 ease-out"
            enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to-class="opacity-100 translate-y-0 sm:scale-100"
            leave-active-class="duration-200 ease-in"
            leave-from-class="opacity-100 translate-y-0 sm:scale-100"
            leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          >
            <div
              v-if="isOpen"
              :class="modalClasses"
              @click.stop
            >
              <!-- Header -->
              <div v-if="title || $slots.header" class="modal-header">
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-3">
                    <!-- Icon -->
                    <div v-if="icon" class="flex-shrink-0">
                      <div :class="iconClasses">
                        <component :is="icon" class="h-6 w-6" />
                      </div>
                    </div>
                    
                    <!-- Title -->
                    <div>
                      <h3 v-if="title" class="text-lg font-medium text-gray-900">
                        {{ title }}
                      </h3>
                      <p v-if="subtitle" class="text-sm text-gray-500 mt-1">
                        {{ subtitle }}
                      </p>
                    </div>
                  </div>
                  
                  <!-- Close Button -->
                  <button
                    v-if="closable"
                    type="button"
                    class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                    @click="handleClose"
                  >
                    <span class="sr-only">Tutup</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
                
                <!-- Custom Header Slot -->
                <slot name="header" />
              </div>
              
              <!-- Body -->
              <div class="modal-body">
                <slot />
              </div>
              
              <!-- Footer -->
              <div v-if="$slots.footer" class="modal-footer">
                <slot name="footer" />
              </div>
            </div>
          </Transition>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup lang="ts">
import { computed, watch, nextTick } from 'vue'

interface Props {
  isOpen: boolean
  title?: string
  subtitle?: string
  icon?: any
  size?: 'sm' | 'md' | 'lg' | 'xl' | 'full'
  closable?: boolean
  closeOnBackdrop?: boolean
  variant?: 'default' | 'success' | 'warning' | 'danger'
}

const props = withDefaults(defineProps<Props>(), {
  size: 'md',
  closable: true,
  closeOnBackdrop: true,
  variant: 'default',
})

const emit = defineEmits<{
  'update:isOpen': [value: boolean]
  'close': []
  'open': []
}>()

const modalClasses = computed(() => {
  const baseClasses = 'relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all'
  
  const sizeClasses = {
    sm: 'sm:max-w-sm',
    md: 'sm:max-w-md',
    lg: 'sm:max-w-lg',
    xl: 'sm:max-w-xl',
    full: 'sm:max-w-full'
  }
  
  return [
    baseClasses,
    sizeClasses[props.size],
    'w-full'
  ].join(' ')
})

const iconClasses = computed(() => {
  const variantClasses = {
    default: 'bg-gray-100 text-gray-600',
    success: 'bg-success-100 text-success-600',
    warning: 'bg-warning-100 text-warning-600',
    danger: 'bg-danger-100 text-danger-600'
  }
  
  return [
    'flex h-10 w-10 items-center justify-center rounded-full',
    variantClasses[props.variant]
  ].join(' ')
})

const handleClose = () => {
  emit('update:isOpen', false)
  emit('close')
}

const handleBackdropClick = () => {
  if (props.closeOnBackdrop) {
    handleClose()
  }
}

// Handle escape key
const handleEscape = (event: KeyboardEvent) => {
  if (event.key === 'Escape' && props.isOpen && props.closable) {
    handleClose()
  }
}

// Watch for modal open/close
watch(() => props.isOpen, (isOpen) => {
  if (isOpen) {
    emit('open')
    nextTick(() => {
      document.addEventListener('keydown', handleEscape)
      document.body.style.overflow = 'hidden'
    })
  } else {
    document.removeEventListener('keydown', handleEscape)
    document.body.style.overflow = ''
  }
})

// Cleanup on unmount
import { onUnmounted } from 'vue'
onUnmounted(() => {
  document.removeEventListener('keydown', handleEscape)
  document.body.style.overflow = ''
})
</script>

<style scoped>
.modal-header {
  @apply px-6 py-4 border-b border-gray-200;
}

.modal-body {
  @apply px-6 py-4;
}

.modal-footer {
  @apply px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end space-x-3;
}
</style>
