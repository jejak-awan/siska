import type { RouteRecordRaw } from 'vue-router'

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    redirect: '/jenjang-selector',
  },
  {
    path: '/jenjang-selector',
    name: 'JenjangSelector',
    component: () => import('@components/JenjangSelector.vue'),
    meta: {
      requiresAuth: true,
      title: 'Pilih Jenjang - SISKA',
    },
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('@views/LoginView.vue'),
    meta: {
      requiresAuth: false,
      title: 'Login - SISKA',
    },
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: () => import('@views/DashboardView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Dashboard - SISKA',
    },
  },
  {
    path: '/profil-sekolah',
    name: 'ProfilSekolah',
    component: () => import('@views/ProfilSekolahView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Profil Sekolah - SISKA',
    },
  },
  {
    path: '/tahun-akademik',
    name: 'TahunAkademik',
    component: () => import('@views/AcademicYearView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Tahun Akademik - SISKA',
    },
  },
  {
    path: '/lisensi',
    name: 'Lisensi',
    component: () => import('@views/LisensiView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Lisensi - SISKA',
    },
  },
  {
    path: '/profile',
    name: 'Profile',
    component: () => import('@views/ProfileView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Profil - SISKA',
    },
  },
  // SD-specific routes
  {
    path: '/jenjang/sd/siswa',
    name: 'SiswaSD',
    component: () => import('@views/jenjang/sd/SiswaSDView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Manajemen Siswa SD - SISKA',
    },
  },
  {
    path: '/jenjang/sd/presensi',
    name: 'PresensiSD',
    component: () => import('@views/jenjang/sd/PresensiSDView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Presensi Siswa SD - SISKA',
    },
  },
  {
    path: '/jenjang/sd/ekstrakurikuler',
    name: 'EkstrakurikulerSD',
    component: () => import('@views/jenjang/sd/EkstrakurikulerSDView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Ekstrakurikuler SD - SISKA',
    },
  },
  {
    path: '/jenjang/sd/program-kesiswaan',
    name: 'ProgramKesiswaanSD',
    component: () => import('@views/jenjang/sd/ProgramKesiswaanSDView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Program Kesiswaan SD - SISKA',
    },
  },
  // SMP-specific routes
  {
    path: '/jenjang/smp/siswa',
    name: 'SiswaSMP',
    component: () => import('@views/jenjang/smp/SiswaSMPView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Manajemen Siswa SMP - SISKA',
    },
  },
  {
    path: '/jenjang/smp/presensi',
    name: 'PresensiSMP',
    component: () => import('@views/jenjang/smp/PresensiSMPView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Presensi Siswa SMP - SISKA',
    },
  },
  {
    path: '/jenjang/smp/ekstrakurikuler',
    name: 'EkstrakurikulerSMP',
    component: () => import('@views/jenjang/smp/EkstrakurikulerSMPView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Ekstrakurikuler SMP - SISKA',
    },
  },
  {
    path: '/jenjang/smp/program-kesiswaan',
    name: 'ProgramKesiswaanSMP',
    component: () => import('@views/jenjang/smp/ProgramKesiswaanSMPView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Program Kesiswaan SMP - SISKA',
    },
  },
  // SMA-specific routes
  {
    path: '/jenjang/sma/siswa',
    name: 'SiswaSMA',
    component: () => import('@views/jenjang/sma/SiswaSMAView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Manajemen Siswa SMA - SISKA',
    },
  },
  {
    path: '/jenjang/sma/presensi',
    name: 'PresensiSMA',
    component: () => import('@views/jenjang/sma/PresensiSMAView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Presensi Siswa SMA - SISKA',
    },
  },
  {
    path: '/jenjang/sma/organisasi',
    name: 'OrganisasiSMA',
    component: () => import('@views/jenjang/sma/OrganisasiSMAView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Organisasi SMA - SISKA',
    },
  },
  {
    path: '/jenjang/sma/program-kesiswaan',
    name: 'ProgramKesiswaanSMA',
    component: () => import('@views/jenjang/sma/ProgramKesiswaanSMAView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Program Kesiswaan SMA - SISKA',
    },
  },
  // SMK-specific routes
  {
    path: '/jenjang/smk/siswa',
    name: 'SiswaSMK',
    component: () => import('@views/jenjang/smk/SiswaSMKView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Manajemen Siswa SMK - SISKA',
    },
  },
  {
    path: '/jenjang/smk/presensi',
    name: 'PresensiSMK',
    component: () => import('@views/jenjang/smk/PresensiSMKView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Presensi Siswa SMK - SISKA',
    },
  },
  {
    path: '/jenjang/smk/kejuruan',
    name: 'KejuruanSMK',
    component: () => import('@views/jenjang/smk/KejuruanSMKView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Kejuruan SMK - SISKA',
    },
  },
  {
    path: '/jenjang/smk/program-kesiswaan',
    name: 'ProgramKesiswaanSMK',
    component: () => import('@views/jenjang/smk/ProgramKesiswaanSMKView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Program Kesiswaan SMK - SISKA',
    },
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: () => import('@views/NotFoundView.vue'),
    meta: {
      requiresAuth: false,
      title: 'Halaman Tidak Ditemukan - SISKA',
    },
  },
]

export default routes
