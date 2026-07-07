<template>
  <header class="navbar" :class="{ 'menu-open': menuOpen }">
    <div class="navbar__inner">

      <router-link to="/" class="navbar__logo">
        <img :src="logo" alt="Lamibois" class="navbar__logo-img" />
        <span class="navbar__logo-text">LAMIBOIS</span>
      </router-link>

      <nav class="navbar__links">
        <router-link to="/" class="navbar__link">{{ t('menu.home') }}</router-link>
        <router-link to="/produits" class="navbar__link">{{ t('menu.products') }}</router-link>
        <router-link to="/apropos" class="navbar__link">{{ t('menu.about') }}</router-link>
        <router-link to="/contact" class="navbar__link">{{ t('menu.contact') }}</router-link>
      </nav>

      <div class="navbar__actions">
        <div class="navbar__lang" ref="langWrapRef">
          <button class="navbar__lang-btn" @click="langOpen = !langOpen" aria-label="Language">
            <span class="navbar__lang-code">{{ currentLocale.toUpperCase() }}</span>
            <svg class="navbar__lang-chevron" :class="{ open: langOpen }" width="10" height="10" viewBox="0 0 10 10" fill="none">
              <path d="M2 3.5L5 6.5L8 3.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>

          <div class="navbar__lang-menu" :class="{ open: langOpen }">
            <button
              v-for="lang in languages"
              :key="lang.code"
              class="navbar__lang-item"
              :class="{ active: currentLocale === lang.code }"
              @click="setLocale(lang.code)"
            >
              <span class="navbar__lang-item-code">{{ lang.code.toUpperCase() }}</span>
              <span class="navbar__lang-item-label">{{ lang.label }}</span>
            </button>
          </div>
        </div>

        <button class="navbar__burger" :class="{ open: menuOpen }" @click="menuOpen = !menuOpen" aria-label="Menu">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>

    <div class="navbar__mobile" :class="{ open: menuOpen }">
      <router-link to="/" class="navbar__mobile-link" @click="menuOpen = false">{{ t('home') }}</router-link>
      <router-link to="/produits" class="navbar__mobile-link" @click="menuOpen = false">{{ t('products') }}</router-link>
      <router-link to="/apropos" class="navbar__mobile-link" @click="menuOpen = false">{{ t('about') }}</router-link>
      <router-link to="/contact" class="navbar__mobile-link" @click="menuOpen = false">{{ t('contact') }}</router-link>

      <div class="navbar__mobile-lang">
        <button
          v-for="lang in languages"
          :key="lang.code"
          class="navbar__mobile-lang-item"
          :class="{ active: currentLocale === lang.code }"
          @click="setLocale(lang.code); menuOpen = false"
        >
          {{ lang.code.toUpperCase() }}
        </button>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { useI18n } from 'vue-i18n'
import logo from '@/assets/lamiboislogo.png'

const { t, locale } = useI18n()
const menuOpen = ref(false)
const langOpen = ref(false)
const langWrapRef = ref(null)

const languages = [
  { code: 'fr', label: 'Français' },
  { code: 'en', label: 'English' },
  { code: 'ar', label: 'العربية' },
  {code:'es', label: 'Español' },
]

const currentLocale = computed(() => locale.value)

function setLocale(code) {
  locale.value = code
  localStorage.setItem('lang', code)
  document.documentElement.setAttribute('lang', code)
  document.documentElement.setAttribute('dir', code === 'ar' ? 'rtl' : 'ltr')
  langOpen.value = false
}

function handleClickOutside(e) {
  if (langWrapRef.value && !langWrapRef.value.contains(e.target)) {
    langOpen.value = false
  }
}

onMounted(() => {
  const saved = localStorage.getItem('lang')
  if (saved) setLocale(saved)
  document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})
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
  text-decoration: none;
}

.navbar__logo-img {
  height: 100px;
  width: auto;
  object-fit: contain;
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

.navbar__actions {
  display: flex;
  align-items: center;
  gap: 18px;
}

/* Language switcher */
.navbar__lang {
  position: relative;
}
.navbar__lang-btn {
  display: flex;
  align-items: center;
  gap: 6px;
  background: rgba(245, 240, 232, 0.06);
  border: 1px solid rgba(201, 168, 124, 0.25);
  border-radius: 20px;
  padding: 6px 12px;
  cursor: pointer;
  color: var(--cream);
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 1.5px;
  transition: border-color 0.25s, background 0.25s;
}
.navbar__lang-btn:hover {
  border-color: var(--wood);
  background: rgba(245, 240, 232, 0.1);
}
.navbar__lang-code {
  color: var(--wood);
  font-weight: 600;
}
.navbar__lang-chevron {
  color: rgba(245, 240, 232, 0.5);
  transition: transform 0.25s ease;
}
.navbar__lang-chevron.open {
  transform: rotate(180deg);
}
.navbar__lang-menu {
  position: absolute;
  top: calc(100% + 10px);
  right: 0;
  min-width: 150px;
  background: var(--forest-deep, #142214);
  border: 1px solid rgba(201, 168, 124, 0.2);
  border-radius: 10px;
  overflow: hidden;
  opacity: 0;
  visibility: hidden;
  transform: translateY(-6px);
  transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s;
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
}
.navbar__lang-menu.open {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}
.navbar__lang-item {
  display: flex;
  align-items: center;
  gap: 10px;
  width: 100%;
  padding: 10px 14px;
  background: none;
  border: none;
  cursor: pointer;
  text-align: left;
  color: rgba(245, 240, 232, 0.75);
  font-family: var(--font-mono);
  font-size: 12px;
  transition: background 0.2s, color 0.2s;
}
.navbar__lang-item:hover {
  background: rgba(245, 240, 232, 0.06);
  color: var(--cream);
}
.navbar__lang-item.active {
  color: var(--wood);
}
.navbar__lang-item-code {
  font-weight: 600;
  width: 22px;
  color: var(--wood);
}

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
  max-height: 480px;
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

.navbar__mobile-lang {
  display: flex;
  gap: 10px;
  margin-top: 20px;
}
.navbar__mobile-lang-item {
  flex: 1;
  padding: 10px 0;
  background: rgba(245, 240, 232, 0.06);
  border: 1px solid rgba(201, 168, 124, 0.2);
  border-radius: 8px;
  color: rgba(245, 240, 232, 0.7);
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 1.5px;
  cursor: pointer;
  transition: border-color 0.2s, color 0.2s;
}
.navbar__mobile-lang-item.active {
  border-color: var(--wood);
  color: var(--wood);
}

@media (max-width: 900px) {
  .navbar__links { display: none; }
  .navbar__burger { display: flex; }
  .navbar__mobile { display: flex; }
  .navbar { padding: 0 24px; }
}
</style>