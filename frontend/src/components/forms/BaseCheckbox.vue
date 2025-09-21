<template>
  <div class="form-group">
    <div class="flex items-start">
      <div class="flex items-center h-5">
        <input
          :id="checkboxId"
          :checked="modelValue"
          :disabled="disabled"
          :required="required"
          type="checkbox"
          :class="checkboxClasses"
          @change="handleChange"
          @blur="handleBlur"
          @focus="handleFocus"
        />
      </div>
      
      <div class="ml-3 text-sm">
        <label :for="checkboxId" class="font-medium text-gray-700 cursor-pointer">
          {{ label }}
          <span v-if="required" class="text-red-500">*</span>
        </label>
        
        <p v-if="help" class="text-gray-500 mt-1">{{ help }}</p>
      </div>
    </div>
    
    <!-- Error Message -->
    <p v-if="error" class="mt-1 text-sm text-red-600">{{ error }}</p>
  </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'

interface Props {
  modelValue?: boolean
  label?: string
  help?: string
  error?: string
  disabled?: boolean
  required?: boolean
  size?: 'sm' | 'md' | 'lg'
}

const props = withDefaults(defineProps<Props>(), {
  size: 'md',
  disabled: false,
  required: false,
})

const emit = defineEmits<{
  'update:modelValue': [value: boolean]
  'blur': [event: FocusEvent]
  'focus': [event: FocusEvent]
}>()

const checkboxId = ref(`checkbox-${Math.random().toString(36).substr(2, 9)}`)

const checkboxClasses = computed(() => {
  const baseClasses = 'h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded'
  
  const sizeClasses = {
    sm: 'h-3 w-3',
    md: 'h-4 w-4',
    lg: 'h-5 w-5'
  }
  
  const stateClasses = props.error 
    ? 'border-red-300 focus:ring-red-500' 
    : 'border-gray-300 focus:ring-primary-500'
  
  return [
    sizeClasses[props.size],
    baseClasses,
    stateClasses,
    props.disabled ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : ''
  ].filter(Boolean).join(' ')
})

const handleChange = (event: Event) => {
  const target = event.target as HTMLInputElement
  emit('update:modelValue', target.checked)
}

const handleBlur = (event: FocusEvent) => {
  emit('blur', event)
}

const handleFocus = (event: FocusEvent) => {
  emit('focus', event)
}
</script>
