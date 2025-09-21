<template>
  <button
    :type="type"
    :disabled="disabled || loading"
    :class="buttonClasses"
    @click="handleClick"
  >
    <!-- Loading Spinner -->
    <div v-if="loading" class="absolute inset-0 flex items-center justify-center">
      <div class="loading-spinner h-4 w-4 border-white"></div>
    </div>
    
    <!-- Icon -->
    <component
      v-if="icon && !loading"
      :is="icon"
      :class="iconClasses"
    />
    
    <!-- Content -->
    <span :class="contentClasses">
      <slot />
    </span>
    
    <!-- Right Icon -->
    <component
      v-if="rightIcon && !loading"
      :is="rightIcon"
      :class="rightIconClasses"
    />
  </button>
</template>

<script setup lang="ts">
import { computed } from 'vue'

interface Props {
  type?: 'button' | 'submit' | 'reset'
  variant?: 'primary' | 'secondary' | 'success' | 'warning' | 'danger' | 'outline' | 'ghost'
  size?: 'xs' | 'sm' | 'md' | 'lg' | 'xl'
  disabled?: boolean
  loading?: boolean
  icon?: any
  rightIcon?: any
  fullWidth?: boolean
  rounded?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  type: 'button',
  variant: 'primary',
  size: 'md',
  disabled: false,
  loading: false,
  fullWidth: false,
  rounded: false,
})

const emit = defineEmits<{
  click: [event: MouseEvent]
}>()

const buttonClasses = computed(() => {
  const baseClasses = 'inline-flex items-center justify-center font-medium border transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed relative'
  
  const variantClasses = {
    primary: 'bg-primary-600 text-white border-transparent hover:bg-primary-700 focus:ring-primary-500',
    secondary: 'bg-secondary-600 text-white border-transparent hover:bg-secondary-700 focus:ring-secondary-500',
    success: 'bg-success-600 text-white border-transparent hover:bg-success-700 focus:ring-success-500',
    warning: 'bg-warning-600 text-white border-transparent hover:bg-warning-700 focus:ring-warning-500',
    danger: 'bg-danger-600 text-white border-transparent hover:bg-danger-700 focus:ring-danger-500',
    outline: 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 focus:ring-primary-500',
    ghost: 'bg-transparent text-gray-700 border-transparent hover:bg-gray-100 focus:ring-primary-500'
  }
  
  const sizeClasses = {
    xs: 'px-2.5 py-1.5 text-xs',
    sm: 'px-3 py-2 text-sm',
    md: 'px-4 py-2 text-sm',
    lg: 'px-4 py-2 text-base',
    xl: 'px-6 py-3 text-base'
  }
  
  const shapeClasses = props.rounded ? 'rounded-full' : 'rounded-md'
  const widthClasses = props.fullWidth ? 'w-full' : ''
  
  return [
    baseClasses,
    variantClasses[props.variant],
    sizeClasses[props.size],
    shapeClasses,
    widthClasses
  ].filter(Boolean).join(' ')
})

const iconClasses = computed(() => {
  const sizeClasses = {
    xs: 'h-3 w-3',
    sm: 'h-4 w-4',
    md: 'h-4 w-4',
    lg: 'h-5 w-5',
    xl: 'h-5 w-5'
  }
  
  return [
    sizeClasses[props.size],
    'mr-2'
  ].join(' ')
})

const rightIconClasses = computed(() => {
  const sizeClasses = {
    xs: 'h-3 w-3',
    sm: 'h-4 w-4',
    md: 'h-4 w-4',
    lg: 'h-5 w-5',
    xl: 'h-5 w-5'
  }
  
  return [
    sizeClasses[props.size],
    'ml-2'
  ].join(' ')
})

const contentClasses = computed(() => {
  return props.loading ? 'opacity-0' : ''
})

const handleClick = (event: MouseEvent) => {
  if (!props.disabled && !props.loading) {
    emit('click', event)
  }
}
</script>
