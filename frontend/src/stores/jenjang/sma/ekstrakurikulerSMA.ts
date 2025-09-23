import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useSiswasmaStore = defineStore('ekstrakurikulersma', () => {
  // State
  const students = ref([])
  const isLoading = ref(false)
  const error = ref(null)
  const pagination = ref({
    current_page: 1,
    last_page: 1,
    per_page: 10,
    total: 0
  })

  // Getters
  const hasData = computed(() => students.value.length > 0)
  const totalStudents = computed(() => pagination.value.total)

  // Actions
  async function loadStudents(params = {}) {
    try {
      isLoading.value = true
      error.value = null

      // Mock data for now
      const mockStudents = [
        {
          id: 1,
          nis: 'sma001',
          nisn: '1234567890',
          nama: 'Ahmad Rizki',
          kelas: '1A',
          tanggal_lahir: '2018-01-15',
          jenis_kelamin: 'L',
          alamat: 'Jl. Merdeka No. 1',
          telepon: '081234567890',
          nama_orang_tua: 'Budi Rizki',
          telepon_orang_tua: '081234567891',
          status: 'aktif',
          created_at: '2024-01-01T00:00:00Z',
          updated_at: '2024-01-01T00:00:00Z'
        },
        {
          id: 2,
          nis: 'sma002',
          nisn: '1234567891',
          nama: 'Siti Aminah',
          kelas: '1A',
          tanggal_lahir: '2018-03-20',
          jenis_kelamin: 'P',
          alamat: 'Jl. Sudirman No. 2',
          telepon: '081234567892',
          nama_orang_tua: 'Sari Aminah',
          telepon_orang_tua: '081234567893',
          status: 'aktif',
          created_at: '2024-01-01T00:00:00Z',
          updated_at: '2024-01-01T00:00:00Z'
        }
      ]

      students.value = mockStudents
      pagination.value = {
        current_page: 1,
        last_page: 1,
        per_page: 10,
        total: mockStudents.length
      }
    } catch (err) {
      console.error('Error loading students:', err)
      error.value = err.message || 'Gagal memuat data siswa'
    } finally {
      isLoading.value = false
    }
  }

  async function createStudent(data) {
    try {
      isLoading.value = true
      // Mock create - in real app, this would call API
      const newStudent = {
        id: Date.now(),
        ...data,
        status: 'aktif',
        created_at: new Date().toISOString(),
        updated_at: new Date().toISOString()
      }
      students.value.unshift(newStudent)
      pagination.value.total += 1
      return newStudent
    } catch (err) {
      console.error('Error creating student:', err)
      error.value = err.message || 'Gagal membuat data siswa'
      throw err
    } finally {
      isLoading.value = false
    }
  }

  async function updateStudent(id, data) {
    try {
      isLoading.value = true
      const index = students.value.findIndex(student => student.id === id)
      if (index !== -1) {
        students.value[index] = {
          ...students.value[index],
          ...data,
          updated_at: new Date().toISOString()
        }
      }
      return students.value[index]
    } catch (err) {
      console.error('Error updating student:', err)
      error.value = err.message || 'Gagal memperbarui data siswa'
      throw err
    } finally {
      isLoading.value = false
    }
  }

  async function deleteStudent(id) {
    try {
      isLoading.value = true
      const index = students.value.findIndex(student => student.id === id)
      if (index !== -1) {
        students.value.splice(index, 1)
        pagination.value.total -= 1
      }
    } catch (err) {
      console.error('Error deleting student:', err)
      error.value = err.message || 'Gagal menghapus data siswa'
      throw err
    } finally {
      isLoading.value = false
    }
  }

  function reset() {
    students.value = []
    isLoading.value = false
    error.value = null
    pagination.value = {
      current_page: 1,
      last_page: 1,
      per_page: 10,
      total: 0
    }
  }

  return {
    // State
    students,
    isLoading,
    error,
    pagination,
    // Getters
    hasData,
    totalStudents,
    // Actions
    loadStudents,
    createStudent,
    updateStudent,
    deleteStudent,
    reset
  }
})
