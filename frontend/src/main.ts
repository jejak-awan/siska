import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { createRouter, createWebHistory } from 'vue-router'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'

import App from './App.vue'
import routes from './router'
import './assets/css/main.css'

// Create Vue app
const app = createApp(App)

// Create Pinia store
const pinia = createPinia()

// Create router
const router = createRouter({
  history: createWebHistory(),
  routes,
})

// Toast configuration
const toastOptions = {
  position: 'top-right' as const,
  timeout: 3000,
  closeOnClick: true,
  pauseOnFocusLoss: true,
  pauseOnHover: true,
  draggable: true,
  draggablePercent: 0.6,
  showCloseButtonOnHover: false,
  hideProgressBar: false,
  closeButton: 'button',
  icon: true,
  rtl: false,
}

// Use plugins
app.use(pinia)
app.use(router)
app.use(Toast, toastOptions)

// Mount app
app.mount('#app')
