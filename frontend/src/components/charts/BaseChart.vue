<template>
  <div class="chart-container">
    <!-- Chart Header -->
    <div v-if="title || $slots.header" class="chart-header">
      <div class="flex items-center justify-between">
        <div>
          <h3 v-if="title" class="text-lg font-medium text-gray-900">{{ title }}</h3>
          <p v-if="subtitle" class="text-sm text-gray-500 mt-1">{{ subtitle }}</p>
        </div>
        
        <!-- Chart Controls -->
        <div v-if="$slots.controls" class="flex items-center space-x-2">
          <slot name="controls" />
        </div>
      </div>
    </div>
    
    <!-- Chart Canvas -->
    <div class="chart-wrapper" :style="{ height: height + 'px' }">
      <canvas ref="chartCanvas" />
    </div>
    
    <!-- Chart Legend -->
    <div v-if="showLegend && legendData.length > 0" class="chart-legend">
      <div class="flex flex-wrap justify-center space-x-6">
        <div
          v-for="(item, index) in legendData"
          :key="index"
          class="flex items-center space-x-2"
        >
          <div
            class="w-3 h-3 rounded-full"
            :style="{ backgroundColor: item.color }"
          />
          <span class="text-sm text-gray-600">{{ item.label }}</span>
        </div>
      </div>
    </div>
    
    <!-- Chart Footer -->
    <div v-if="$slots.footer" class="chart-footer">
      <slot name="footer" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted, watch, nextTick } from 'vue'
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  ArcElement,
  Title,
  Tooltip,
  Legend,
  Filler,
  type ChartConfiguration,
  type ChartData,
  type ChartOptions
} from 'chart.js'

// Import controllers
import { DoughnutController, BarController, LineController, PieController, PolarAreaController } from 'chart.js'

// Register Chart.js components
ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  ArcElement,
  Title,
  Tooltip,
  Legend,
  Filler,
  DoughnutController,
  BarController,
  LineController,
  PieController,
  PolarAreaController
)

interface LegendItem {
  label: string
  color: string
}

interface Props {
  type: 'line' | 'bar' | 'doughnut' | 'pie' | 'polarArea'
  data: ChartData
  options?: ChartOptions
  title?: string
  subtitle?: string
  height?: number
  showLegend?: boolean
  responsive?: boolean
  maintainAspectRatio?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  height: 300,
  showLegend: true,
  responsive: true,
  maintainAspectRatio: false,
})

const chartCanvas = ref<HTMLCanvasElement>()
const chartInstance = ref<ChartJS | null>(null)
const legendData = ref<LegendItem[]>([])

const defaultOptions: ChartOptions = {
  responsive: props.responsive,
  maintainAspectRatio: props.maintainAspectRatio,
  plugins: {
    legend: {
      display: false, // We'll handle legend manually
    },
    tooltip: {
      backgroundColor: 'rgba(0, 0, 0, 0.8)',
      titleColor: 'white',
      bodyColor: 'white',
      borderColor: 'rgba(255, 255, 255, 0.1)',
      borderWidth: 1,
    },
  },
  scales: props.type === 'line' || props.type === 'bar' ? {
    x: {
      grid: {
        color: 'rgba(0, 0, 0, 0.1)',
      },
      ticks: {
        color: '#6B7280',
      },
    },
    y: {
      grid: {
        color: 'rgba(0, 0, 0, 0.1)',
      },
      ticks: {
        color: '#6B7280',
      },
    },
  } : undefined,
}

const createChart = () => {
  if (!chartCanvas.value) return
  
  // Ensure canvas is ready
  if (!chartCanvas.value.getContext) return
  
  const config: ChartConfiguration = {
    type: props.type,
    data: props.data,
    options: {
      ...defaultOptions,
      ...props.options,
    },
  }
  
  try {
    chartInstance.value = new ChartJS(chartCanvas.value, config)
    updateLegend()
  } catch (error) {
    console.error('Chart creation error:', error)
  }
}

const updateChart = () => {
  if (!chartInstance.value) return
  
  chartInstance.value.data = props.data
  chartInstance.value.update()
  updateLegend()
}

const updateLegend = () => {
  if (!chartInstance.value || !props.showLegend) return
  
  const datasets = chartInstance.value.data.datasets
  legendData.value = datasets.map((dataset, index) => ({
    label: dataset.label || `Dataset ${index + 1}`,
    color: Array.isArray(dataset.backgroundColor) 
      ? dataset.backgroundColor[0] as string
      : dataset.backgroundColor as string || '#3B82F6'
  }))
}

const destroyChart = () => {
  if (chartInstance.value) {
    chartInstance.value.destroy()
    chartInstance.value = null
  }
}

// Watch for data changes
watch(() => props.data, () => {
  updateChart()
}, { deep: true })

// Watch for options changes
watch(() => props.options, () => {
  if (chartInstance.value) {
    chartInstance.value.options = {
      ...defaultOptions,
      ...props.options,
    }
    chartInstance.value.update()
  }
}, { deep: true })

onMounted(() => {
  nextTick(() => {
    createChart()
  })
})

onUnmounted(() => {
  destroyChart()
})
</script>

<style scoped>
.chart-container {
  @apply bg-white rounded-lg shadow-sm border border-gray-200;
}

.chart-header {
  @apply px-6 py-4 border-b border-gray-200;
}

.chart-wrapper {
  @apply relative p-6;
}

.chart-legend {
  @apply px-6 py-4 border-t border-gray-200 bg-gray-50;
}

.chart-footer {
  @apply px-6 py-4 border-t border-gray-200 bg-gray-50;
}
</style>

