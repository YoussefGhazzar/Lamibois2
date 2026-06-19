<template>
  <header class="navbar" :class="{ scrolled: isScrolled, 'menu-open': menuOpen }">
    <div class="navbar__inner">

      <!-- Logo -->
      <a href="/" class="navbar__logo">
        <div class="navbar__logo-mark">
          <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="20" cy="20" r="18.5" stroke="currentColor" stroke-width="1.5"/>
            <text x="8" y="26" font-family="Cormorant Garamond, serif" font-size="16" font-weight="600" fill="currentColor">LB</text>
          </svg>
        </div>
        <span class="navbar__logo-text">LAMIBOIS</span>
      </a>

      <!-- Desktop Nav -->
      <nav class="navbar__links">
        <a href="#accueil"  class="navbar__link" @click.prevent="scrollTo('accueil')">Accueil</a>
        <a href="/produits" class="navbar__link" @click.prevent="goProducts">Produits</a>
        <a href="#apropos"  class="navbar__link" @click.prevent="scrollTo('apropos')">À propos</a>
        <a href="#contact"  class="navbar__link" @click.prevent="scrollTo('contact')">Contact</a>
      </nav>

      <!-- CTA -->
      <button class="navbar__cta" @click="scrollTo('contact')">
        <span>Demander un devis</span>
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 7h10M7 2l5 5-5 5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>

      <!-- Hamburger -->
      <button class="navbar__burger" :class="{ open: menuOpen }" @click="menuOpen = !menuOpen" aria-label="Menu">
        <span></span><span></span><span></span>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div class="navbar__mobile" :class="{ open: menuOpen }">
      <a href="#accueil"  class="navbar__mobile-link" @click="navigate('accueil')">Accueil</a>
      <a href="/produits" class="navbar__mobile-link" @click.prevent="goProducts">Produits</a>
      <a href="#apropos"  class="navbar__mobile-link" @click="navigate('apropos')">À propos</a>
      <a href="#contact"  class="navbar__mobile-link" @click="navigate('contact')">Contact</a>
      <button class="navbar__mobile-cta" @click="navigate('contact')">Demander un devis</button>
    </div>
  </header>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'

const isScrolled = ref(false)
const menuOpen   = ref(false)

const router = useRouter()
const onScroll = () => { isScrolled.value = window.scrollY > 60 }

const goProducts = () => {
  router.push('/produits')
  menuOpen.value = false
}

const scrollTo = (id) => {
  const el = document.getElementById(id)
  if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' })
  menuOpen.value = false
}
const navigate = (id) => { menuOpen.value = false; setTimeout(() => scrollTo(id), 300) }

onMounted(()  => window.addEventListener('scroll', onScroll))
onUnmounted(() => window.removeEventListener('scroll', onScroll))
</script>

<style scoped>
.navbar {
  position: fixed;
  top: 0; left: 0; right: 0;
  z-index: 1000;
  padding: 0 40px;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

.navbar__inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 80px;
  border-bottom: 1px solid transparent;
  transition: all 0.4s ease;
}

.navbar.scrolled {
  background: rgba(26, 46, 26, 0.96);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  box-shadow: 0 1px 0 rgba(201, 168, 124, 0.15);
}

.navbar.scrolled .navbar__inner {
  height: 64px;
}

/* Logo */
.navbar__logo {
  display: flex;
  align-items: center;
  gap: 12px;
  color: var(--wood);
}

.navbar__logo-mark {
  width: 38px;
  height: 38px;
  color: var(--wood);
  flex-shrink: 0;
}

.navbar__logo-text {
  font-family: var(--font-body);
  font-size: 13px;
  font-weight: 500;
  letter-spacing: 4px;
  color: var(--cream);
}

/* Links */
.navbar__links {
  display: flex;
  gap: 36px;
}

.navbar__link {
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: rgba(245, 240, 232, 0.65);
  transition: color 0.25s;
  position: relative;
}

.navbar__link::after {
  content: '';
  position: absolute;
  bottom: -4px; left: 0;
  width: 0; height: 1px;
  background: var(--wood);
  transition: width 0.3s ease;
}

.navbar__link:hover { color: var(--wood); }
.navbar__link:hover::after { width: 100%; }

/* CTA */
.navbar__cta {
  display: flex;
  align-items: center;
  gap: 8px;
  background: var(--wood);
  color: var(--forest-deep);
  font-family: var(--font-mono);
  font-size: 11px;
  font-weight: 500;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  padding: 10px 22px;
  border-radius: 2px;
  transition: background 0.25s, transform 0.2s;
}

.navbar__cta:hover {
  background: var(--wood-light);
  transform: translateY(-1px);
}

/* Burger */
.navbar__burger {
  display: none;
  flex-direction: column;
  gap: 5px;
  background: none;
  padding: 4px;
}

.navbar__burger span {
  display: block;
  width: 24px;
  height: 1.5px;
  background: var(--cream);
  transition: all 0.3s ease;
  transform-origin: center;
}

.navbar__burger.open span:nth-child(1) { transform: translateY(6.5px) rotate(45deg); }
.navbar__burger.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.navbar__burger.open span:nth-child(3) { transform: translateY(-6.5px) rotate(-45deg); }

/* Mobile Menu */
.navbar__mobile {
  display: none;
  flex-direction: column;
  background: var(--forest-deep);
  padding: 0 40px;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.4s ease, padding 0.4s ease;
}

.navbar__mobile.open {
  max-height: 400px;
  padding: 24px 40px 32px;
}

.navbar__mobile-link {
  font-family: var(--font-mono);
  font-size: 13px;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: rgba(245, 240, 232, 0.7);
  padding: 14px 0;
  border-bottom: 1px solid rgba(245, 240, 232, 0.08);
  transition: color 0.2s;
}

.navbar__mobile-link:hover { color: var(--wood); }

.navbar__mobile-cta {
  margin-top: 24px;
  background: var(--wood);
  color: var(--forest-deep);
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 2px;
  text-transform: uppercase;
  padding: 14px 24px;
  border-radius: 2px;
  width: fit-content;
}

@media (max-width: 900px) {
  .navbar__links, .navbar__cta { display: none; }
  .navbar__burger { display: flex; }
  .navbar__mobile { display: flex; }
  .navbar { padding: 0 24px; }
}
</style>
