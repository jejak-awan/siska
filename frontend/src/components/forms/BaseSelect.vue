<template>
  <div class="form-group">
    <label v-if="label" :for="selectId" class="block text-sm font-medium text-gray-700 mb-1">
      {{ label }}
      <span v-if="required" class="text-red-500">*</span>
    </label>
    
    <div class="relative">
      <select
        :id="selectId"
        :value="modelValue"
        :disabled="disabled"
        :required="required"
        :class="selectClasses"
        @change="handleChange"
        @blur="handleBlur"
        @focus="handleFocus"
      >
        <option v-if="placeholder" value="" disabled>{{ placeholder }}</option>
        <option
          v-for="option in options"
          :key="getOptionValue(option)"
          :value="getOptionValue(option)"
        >
          {{ getOptionLabel(option) }}
        </option>
      </select>
      
      <!-- Icon -->
      <div v-if="icon" class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <component :is="icon" class="h-5 w-5 text-gray-400" />
      </div>
      
      <!-- Dropdown Arrow -->
      <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
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

interface Option {
  value: any
  label: string
  disabled?: boolean
}

interface Props {
  modelValue?: any
  options: Option[] | string[]
  label?: string
  placeholder?: string
  help?: string
  error?: string
  disabled?: boolean
  required?: boolean
  icon?: any
  size?: 'sm' | 'md' | 'lg'
  valueKey?: string
  labelKey?: string
}

const props = withDefaults(defineProps<Props>(), {
  size: 'md',
  disabled: false,
  required: false,
  valueKey: 'value',
  labelKey: 'label',
})

const emit = defineEmits<{
  'update:modelValue': [value: any]
  'blur': [event: FocusEvent]
  'focus': [event: FocusEvent]
}>()

const selectId = ref(`select-${Math.random().toString(36).substr(2, 9)}`)

const selectClasses = computed(() => {
  const baseClasses = 'block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm'
  
  const sizeClasses = {
    sm: 'px-3 py-1.5 text-sm',
    md: 'px-3 py-2',
    lg: 'px-4 py-3 text-lg'
  }
  
  const stateClasses = props.error 
    ? 'border-red-300 focus:ring-red-500 focus:border-red-500' 
    : 'border-gray-300 focus:ring-primary-500 focus:border-primary-500'
  
  const iconClasses = props.icon ? 'pl-10' : ''
  
  return [
    baseClasses,
    sizeClasses[props.size],
    stateClasses,
    iconClasses,
    'pr-10',
    props.disabled ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : 'bg-white'
  ].filter(Boolean).join(' ')
})

const getOptionValue = (option: any) => {
  if (typeof option === 'string') return option
  return option[props.valueKey]
}

const getOptionLabel = (option: any) => {
  if (typeof option === 'string') return option
  return option[props.labelKey]
}

const handleChange = (event: Event) => {
  const target = event.target as HTMLSelectElement
  emit('update:modelValue', target.value)
}

const handleBlur = (event: FocusEvent) => {
  emit('blur', event)
}

const handleFocus = (event: FocusEvent) => {
  emit('focus', event)
}
</script>
