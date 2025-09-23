import type { Router } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { useJenjangStore } from '@/stores/jenjang'

export function setupRouterGuards(router: Router) {
  // Auth guard
  router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore()
    const jenjangStore = useJenjangStore()

    // Check if route requires authentication
    if (to.meta.requiresAuth) {
      if (!authStore.isAuthenticated) {
        // Redirect to login if not authenticated
        next({
          name: 'Login',
          query: { redirect: to.fullPath }
        })
        return
      }

      // Check if route requires jenjang selection
      if (to.meta.requiresJenjang) {
        const jenjang = to.params.jenjang as string
        
        if (!jenjang) {
          // Redirect to jenjang selector if no jenjang specified
          next({ name: 'JenjangSelector' })
          return
        }

        // Check if jenjang is available and active
        const availableJenjang = await jenjangStore.fetchAvailableJenjang()
        const jenjangInfo = availableJenjang.find(j => j.id === jenjang)
        
        if (!jenjangInfo || !jenjangInfo.isActive) {
          // Redirect to jenjang selector if jenjang not available
          next({ name: 'JenjangSelector' })
          return
        }

        // Set selected jenjang
        jenjangStore.selectJenjang(jenjang)
      }

      // Check if route requires specific feature
      if (to.meta.requiresFeature) {
        const feature = to.meta.requiresFeature as string
        const jenjang = to.params.jenjang as string
        
        if (!jenjangStore.isFeatureAvailable(feature)) {
          // Redirect to jenjang dashboard if feature not available
          next({
            name: 'JenjangDashboard',
            params: { jenjang }
          })
          return
        }
      }
    }

    // Set page title
    if (to.meta.title) {
      document.title = to.meta.title as string
    }

    next()
  })

  // After each route change
  router.afterEach((to, from) => {
    // Update page title
    if (to.meta.title) {
      document.title = to.meta.title as string
    }
  })
}
