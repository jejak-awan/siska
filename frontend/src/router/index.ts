import type { RouteRecordRaw } from 'vue-router'

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    redirect: '/dashboard',
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
    path: '/profil-sekolah/:id',
    name: 'ProfilSekolahDetail',
    component: () => import('@views/ProfilSekolahDetailView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Detail Profil Sekolah - SISKA',
    },
  },
  {
    path: '/tahun-akademik',
    name: 'TahunAkademik',
    component: () => import('@views/TahunAkademikView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Tahun Akademik - SISKA',
    },
  },
  {
    path: '/tahun-akademik/:id',
    name: 'TahunAkademikDetail',
    component: () => import('@views/TahunAkademikDetailView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Detail Tahun Akademik - SISKA',
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
    path: '/lisensi/:id',
    name: 'LisensiDetail',
    component: () => import('@views/LisensiDetailView.vue'),
    meta: {
      requiresAuth: true,
      title: 'Detail Lisensi - SISKA',
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
