import { createRouter, createWebHistory } from 'vue-router'
import HomePage from '@/views/HomePage.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomePage,
  },
  // Future pages:
  // { path: '/produits', name: 'products', component: () => import('@/views/ProductsPage.vue') },
  // { path: '/a-propos', name: 'about',    component: () => import('@/views/AboutPage.vue')    },
  // { path: '/contact',  name: 'contact',  component: () => import('@/views/ContactPage.vue')  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) return savedPosition
    if (to.hash) return { el: to.hash, behavior: 'smooth' }
    return { top: 0, behavior: 'smooth' }
  },
})

export default router
