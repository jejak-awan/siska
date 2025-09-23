import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { jenjangService, type JenjangInfo } from '@/services/jenjang'

export const useJenjangStore = defineStore('jenjang', () => {
  // State
  const availableJenjang = ref<JenjangInfo[]>([])
  const selectedJenjang = ref<string>('')
  const isLoading = ref(false)
  const error = ref<string | null>(null)

  // Getters
  const activeJenjang = computed(() => 
    availableJenjang.value.filter(jenjang => jenjang.isActive)
  )

  const selectedJenjangInfo = computed(() => 
    availableJenjang.value.find(jenjang => jenjang.id === selectedJenjang.value)
  )

  const hasActiveJenjang = computed(() => 
    activeJenjang.value.length > 0
  )

  const isJenjangSelected = computed(() => 
    selectedJenjang.value !== ''
  )

  // Actions
  const fetchAvailableJenjang = async () => {
    isLoading.value = true
    error.value = null
    
    try {
      const jenjang = await jenjangService.getAvailableJenjang()
      availableJenjang.value = jenjang
      
      // Auto-select first active jenjang if none selected
      if (!selectedJenjang.value && jenjang.length > 0) {
        const firstActive = jenjang.find(j => j.isActive)
        if (firstActive) {
          selectedJenjang.value = firstActive.id
        }
      }
    } catch (err) {
      error.value = err instanceof Error ? err.message : 'Failed to fetch available jenjang'
      console.error('Error fetching available jenjang:', err)
    } finally {
      isLoading.value = false
    }
  }

  const selectJenjang = (jenjangId: string) => {
    const jenjang = availableJenjang.value.find(j => j.id === jenjangId)
    if (jenjang && jenjang.isActive) {
      selectedJenjang.value = jenjangId
    } else {
      throw new Error('Jenjang tidak tersedia atau tidak aktif')
    }
  }

  const clearSelection = () => {
    selectedJenjang.value = ''
  }

  const isFeatureAvailable = (feature: string) => {
    if (!selectedJenjang.value) return false
    return jenjangService.isFeatureAvailable(selectedJenjang.value, feature)
  }

  const getJenjangDisplayName = (jenjangId?: string) => {
    const id = jenjangId || selectedJenjang.value
    return jenjangService.getJenjangDisplayName(id)
  }

  const getJenjangDescription = (jenjangId?: string) => {
    const id = jenjangId || selectedJenjang.value
    return jenjangService.getJenjangDescription(id)
  }

  // Initialize store
  const initialize = async () => {
    await fetchAvailableJenjang()
  }

  return {
    // State
    availableJenjang,
    selectedJenjang,
    isLoading,
    error,
    
    // Getters
    activeJenjang,
    selectedJenjangInfo,
    hasActiveJenjang,
    isJenjangSelected,
    
    // Actions
    fetchAvailableJenjang,
    selectJenjang,
    clearSelection,
    isFeatureAvailable,
    getJenjangDisplayName,
    getJenjangDescription,
    initialize
  }
})
