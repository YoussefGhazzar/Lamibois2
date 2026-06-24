import { createRouter, createWebHistory } from 'vue-router'
import HomePage from '@/views/HomePage.vue'
import ProductsPage from '@/views/ProductsPage.vue'
import ContactPage from '@/views/ContactPage.vue'
import AboutPage from '@/views/AboutPage.vue'

const routes = [
  { path: '/', name: 'home', component: HomePage },
  { path: '/produits', name: 'products', component: ProductsPage },
  { path: '/contact', name: 'contact', component: ContactPage },
  { path: '/apropos', name: 'about', component: AboutPage },
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