<template>
  <div class="jenjang-selector">
    <div v-if="isLoading" class="loading">
      <div class="spinner"></div>
      <p>Memuat jenjang...</p>
    </div>

    <div v-else-if="error" class="error">
      <div class="error-icon">⚠️</div>
      <p>{{ error }}</p>
      <button @click="fetchAvailableJenjang" class="retry-btn">
        Coba Lagi
      </button>
    </div>

    <div v-else-if="!hasActiveJenjang" class="no-jenjang">
      <div class="no-jenjang-icon">📚</div>
      <h3>Tidak Ada Jenjang Tersedia</h3>
      <p>Silakan hubungi administrator untuk mengaktifkan jenjang yang tersedia.</p>
    </div>

    <div v-else class="jenjang-grid">
      <div
        v-for="jenjang in activeJenjang"
        :key="jenjang.id"
        :class="[
          'jenjang-card',
          { 'selected': selectedJenjang === jenjang.id }
        ]"
        @click="selectJenjang(jenjang.id)"
      >
        <div class="jenjang-icon">
          {{ getJenjangIcon(jenjang.id) }}
        </div>
        <div class="jenjang-info">
          <h3>{{ jenjang.displayName }}</h3>
          <p>{{ jenjang.description }}</p>
          <div class="features">
            <span
              v-for="feature in jenjang.features"
              :key="feature"
              class="feature-tag"
            >
              {{ getFeatureDisplayName(feature) }}
            </span>
          </div>
        </div>
        <div v-if="selectedJenjang === jenjang.id" class="selected-indicator">
          ✓
        </div>
      </div>
    </div>

    <div v-if="hasActiveJenjang && selectedJenjang" class="selected-info">
      <div class="selected-jenjang">
        <h4>Jenjang Terpilih:</h4>
        <div class="selected-details">
          <span class="jenjang-name">{{ selectedJenjangInfo?.displayName }}</span>
          <span class="jenjang-description">{{ selectedJenjangInfo?.description }}</span>
        </div>
      </div>
      <button @click="proceedToModule" class="proceed-btn">
        Lanjutkan ke Modul
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useJenjangStore } from '@/stores/jenjang'

const router = useRouter()
const jenjangStore = useJenjangStore()

// Computed properties
const isLoading = computed(() => jenjangStore.isLoading)
const error = computed(() => jenjangStore.error)
const activeJenjang = computed(() => jenjangStore.activeJenjang)
const hasActiveJenjang = computed(() => jenjangStore.hasActiveJenjang)
const selectedJenjang = computed(() => jenjangStore.selectedJenjang)
const selectedJenjangInfo = computed(() => jenjangStore.selectedJenjangInfo)

// Methods
const fetchAvailableJenjang = () => {
  jenjangStore.fetchAvailableJenjang()
}

const selectJenjang = (jenjangId: string) => {
  try {
    jenjangStore.selectJenjang(jenjangId)
  } catch (err) {
    console.error('Error selecting jenjang:', err)
  }
}

const proceedToModule = () => {
  if (selectedJenjang.value) {
    router.push(`/jenjang/${selectedJenjang.value}/dashboard`)
  }
}

const getJenjangIcon = (jenjangId: string) => {
  const icons = {
    sd: '🎒',
    smp: '📚',
    sma: '🎓',
    smk: '🔧'
  }
  return icons[jenjangId as keyof typeof icons] || '📖'
}

const getFeatureDisplayName = (feature: string) => {
  const featureNames = {
    'siswa': 'Siswa',
    'presensi': 'Presensi',
    'kredit-poin': 'Kredit Poin',
    'program-kesiswaan': 'Program Kesiswaan',
    'penilaian-karakter': 'Penilaian Karakter',
    'ekstrakurikuler': 'Ekstrakurikuler',
    'organisasi': 'Organisasi',
    'kejuruan': 'Kejuruan'
  }
  return featureNames[feature as keyof typeof featureNames] || feature
}

// Lifecycle
onMounted(() => {
  jenjangStore.initialize()
})
</script>

<style scoped>
.jenjang-selector {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

.loading {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 4rem;
  text-align: center;
}

.spinner {
  width: 40px;
  height: 40px;
  border: 4px solid #f3f3f3;
  border-top: 4px solid #3498db;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin-bottom: 1rem;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.error {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 4rem;
  text-align: center;
  color: #e74c3c;
}

.error-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
}

.retry-btn {
  background: #3498db;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  cursor: pointer;
  margin-top: 1rem;
}

.retry-btn:hover {
  background: #2980b9;
}

.no-jenjang {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 4rem;
  text-align: center;
}

.no-jenjang-icon {
  font-size: 4rem;
  margin-bottom: 1rem;
}

.jenjang-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.jenjang-card {
  position: relative;
  background: white;
  border: 2px solid #e1e8ed;
  border-radius: 12px;
  padding: 1.5rem;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.jenjang-card:hover {
  border-color: #3498db;
  box-shadow: 0 4px 12px rgba(52, 152, 219, 0.15);
  transform: translateY(-2px);
}

.jenjang-card.selected {
  border-color: #27ae60;
  background: #f8fff9;
  box-shadow: 0 4px 12px rgba(39, 174, 96, 0.15);
}

.jenjang-icon {
  font-size: 3rem;
  text-align: center;
}

.jenjang-info h3 {
  margin: 0 0 0.5rem 0;
  color: #2c3e50;
  font-size: 1.25rem;
}

.jenjang-info p {
  margin: 0 0 1rem 0;
  color: #7f8c8d;
  font-size: 0.9rem;
  line-height: 1.4;
}

.features {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
}

.feature-tag {
  background: #ecf0f1;
  color: #2c3e50;
  padding: 0.25rem 0.5rem;
  border-radius: 12px;
  font-size: 0.75rem;
  font-weight: 500;
}

.selected-indicator {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: #27ae60;
  color: white;
  width: 24px;
  height: 24px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.8rem;
  font-weight: bold;
}

.selected-info {
  background: #f8f9fa;
  border: 1px solid #e9ecef;
  border-radius: 8px;
  padding: 1.5rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.selected-jenjang h4 {
  margin: 0 0 0.5rem 0;
  color: #2c3e50;
}

.selected-details {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}

.jenjang-name {
  font-weight: 600;
  color: #27ae60;
}

.jenjang-description {
  font-size: 0.9rem;
  color: #7f8c8d;
}

.proceed-btn {
  background: #27ae60;
  color: white;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
  transition: background 0.3s ease;
}

.proceed-btn:hover {
  background: #229954;
}

@media (max-width: 768px) {
  .jenjang-selector {
    padding: 1rem;
  }
  
  .jenjang-grid {
    grid-template-columns: 1fr;
  }
  
  .selected-info {
    flex-direction: column;
    gap: 1rem;
    text-align: center;
  }
}
</style>
