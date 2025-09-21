<template>
  <div class="form-group">
    <label v-if="label" :for="textareaId" class="block text-sm font-medium text-gray-700 mb-1">
      {{ label }}
      <span v-if="required" class="text-red-500">*</span>
    </label>
    
    <div class="relative">
      <textarea
        :id="textareaId"
        :value="modelValue"
        :placeholder="placeholder"
        :disabled="disabled"
        :readonly="readonly"
        :required="required"
        :rows="rows"
        :maxlength="maxlength"
        :class="textareaClasses"
        @input="handleInput"
        @blur="handleBlur"
        @focus="handleFocus"
      />
      
      <!-- Character Count -->
      <div v-if="maxlength" class="absolute bottom-2 right-2 text-xs text-gray-400">
        {{ characterCount }}/{{ maxlength }}
      </div>
    </div>
    
    <!-- Error Message -->
    <p v-if="error" class="mt-1 text-sm text-red-600">{{ error }}</p>
    
    <!-- Help Text -->
    <p v-if="help && !error" class="mt-1 text-sm text-gray-500">{{ help }}</p>
  </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'

interface Props {
  modelValue?: string
  label?: string
  placeholder?: string
  help?: string
  error?: string
  disabled?: boolean
  readonly?: boolean
  required?: boolean
  rows?: number
  maxlength?: number
  size?: 'sm' | 'md' | 'lg'
  resize?: 'none' | 'vertical' | 'horizontal' | 'both'
}

const props = withDefaults(defineProps<Props>(), {
  rows: 3,
  size: 'md',
  disabled: false,
  readonly: false,
  required: false,
  resize: 'vertical',
})

const emit = defineEmits<{
  'update:modelValue': [value: string]
  'blur': [event: FocusEvent]
  'focus': [event: FocusEvent]
}>()

const textareaId = ref(`textarea-${Math.random().toString(36).substr(2, 9)}`)

const characterCount = computed(() => {
  return props.modelValue?.length || 0
})

const textareaClasses = computed(() => {
  const baseClasses = 'block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm'
  
  const sizeClasses = {
    sm: 'px-3 py-1.5 text-sm',
    md: 'px-3 py-2',
    lg: 'px-4 py-3 text-lg'
  }
  
  const stateClasses = props.error 
    ? 'border-red-300 focus:ring-red-500 focus:border-red-500' 
    : 'border-gray-300 focus:ring-primary-500 focus:border-primary-500'
  
  const resizeClasses = {
    none: 'resize-none',
    vertical: 'resize-y',
    horizontal: 'resize-x',
    both: 'resize'
  }
  
  return [
    baseClasses,
    sizeClasses[props.size],
    stateClasses,
    resizeClasses[props.resize],
    props.disabled ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : 'bg-white',
    props.readonly ? 'bg-gray-50' : '',
    props.maxlength ? 'pb-6' : ''
  ].filter(Boolean).join(' ')
})

const handleInput = (event: Event) => {
  const target = event.target as HTMLTextAreaElement
  emit('update:modelValue', target.value)
}

const handleBlur = (event: FocusEvent) => {
  emit('blur', event)
}

const handleFocus = (event: FocusEvent) => {
  emit('focus', event)
}
</script>
