<template>
  <header class="navbar" :class="{ 'menu-open': menuOpen }">
    <div class="navbar__inner">

      <router-link to="/" class="navbar__logo">
        <div class="navbar__logo-mark">
          <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="20" cy="20" r="18.5" stroke="currentColor" stroke-width="1.5"/>
            <text x="8" y="26" font-family="Cormorant Garamond, serif" font-size="16" font-weight="600" fill="currentColor">LB</text>
          </svg>
        </div>
        <span class="navbar__logo-text">LAMIBOIS</span>
      </router-link>

      <nav class="navbar__links">
        <router-link to="/" class="navbar__link">Accueil</router-link>
        <router-link to="/produits" class="navbar__link">Produits</router-link>
        <router-link to="/apropos" class="navbar__link">A propos</router-link>
        <router-link to="/contact" class="navbar__link">Contact</router-link>
      </nav>

      <button class="navbar__burger" :class="{ open: menuOpen }" @click="menuOpen = !menuOpen" aria-label="Menu">
        <span></span><span></span><span></span>
      </button>
    </div>

    <div class="navbar__mobile" :class="{ open: menuOpen }">
      <router-link to="/" class="navbar__mobile-link" @click="menuOpen = false">Accueil</router-link>
      <router-link to="/produits" class="navbar__mobile-link" @click="menuOpen = false">Produits</router-link>
      <router-link to="/apropos" class="navbar__mobile-link" @click="menuOpen = false">A propos</router-link>
      <router-link to="/contact" class="navbar__mobile-link" @click="menuOpen = false">Contact</router-link>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'
const menuOpen = ref(false)
</script>

<style scoped>
.navbar {
  position: fixed;
  top: 0; left: 0; right: 0;
  z-index: 1000;
  padding: 0 40px;
  background: rgba(26, 46, 26, 0.97);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  box-shadow: 0 1px 0 rgba(201, 168, 124, 0.15);
}
.navbar__inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 72px;
  position: relative;
}
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
.navbar__links {
  display: flex;
  gap: 36px;
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
}
.navbar__link {
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: rgba(245, 240, 232, 0.65);
  transition: color 0.25s;
  position: relative;
  cursor: pointer;
  text-decoration: none;
}
.navbar__link::after {
  content: "";
  position: absolute;
  bottom: -4px; left: 0;
  width: 0; height: 1px;
  background: var(--wood);
  transition: width 0.3s ease;
}
.navbar__link:hover { color: var(--wood); }
.navbar__link:hover::after { width: 100%; }
.navbar__burger {
  display: none;
  flex-direction: column;
  gap: 5px;
  background: none;
  padding: 4px;
  border: none;
  cursor: pointer;
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
  cursor: pointer;
  text-decoration: none;
}
.navbar__mobile-link:hover { color: var(--wood); }
@media (max-width: 900px) {
  .navbar__links { display: none; }
  .navbar__burger { display: flex; }
  .navbar__mobile { display: flex; }
  .navbar { padding: 0 24px; }
}
</style>