<template>
  <section id="accueil" class="hero">

    <!-- Background: animated wood panels -->
    <div class="hero__bg">
      <div class="hero__panels">
        <div v-for="i in 6" :key="i" class="hero__panel" :class="`hero__panel--${i}`"></div>
      </div>
      <div class="hero__overlay"></div>
      <div class="hero__grain"></div>
    </div>

    <!-- Floating product badge -->
    <div class="hero__badge" :class="{ visible: badgeVisible }">
      <div class="hero__badge-dot"></div>
      <span>Stock disponible · Livraison 48h</span>
    </div>

    <!-- Content -->
    <div class="hero__content" :class="{ visible: contentVisible }">
      <p class="hero__eyebrow">
        <span class="hero__eyebrow-line"></span>
        Distributeur B2B de panneaux bois
      </p>

      <h1 class="hero__title">
        La matière<br>
        <em>noble</em> au service<br>
        de vos projets
      </h1>

      <p class="hero__subtitle">
        MDF mélaminé, contreplaqué, bois massif — des matériaux de qualité
        certifiée, disponibles immédiatement pour les professionnels.
      </p>

      <div class="hero__actions">
        <button class="btn-primary" @click="scrollTo('produits')">
          Découvrir nos produits
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path d="M3 8h10M8 3l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
        <button class="btn-ghost" @click="scrollTo('contact')">Nous contacter</button>
      </div>

      <!-- Scroll hint -->
      <div class="hero__scroll">
        <div class="hero__scroll-line"></div>
        <span>Défiler</span>
      </div>
    </div>

    <!-- Right: product cards strip -->
    <div class="hero__cards" :class="{ visible: cardsVisible }">
      <div
        v-for="(card, i) in productCards"
        :key="i"
        class="hero__card"
        :style="{ transitionDelay: `${0.6 + i * 0.1}s` }"
      >
        <div class="hero__card-visual" :style="card.style"></div>
        <div class="hero__card-info">
          <span class="hero__card-tag">{{ card.tag }}</span>
          <p class="hero__card-name">{{ card.name }}</p>
        </div>
        <div class="hero__card-shine"></div>
      </div>
    </div>

    <!-- Bottom stats bar -->
    <div class="hero__stats">
      <div v-for="(stat, i) in stats" :key="i" class="hero__stat">
        <strong>{{ stat.value }}</strong>
        <span>{{ stat.label }}</span>
      </div>
    </div>

  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const contentVisible = ref(false)
const cardsVisible   = ref(false)
const badgeVisible   = ref(false)

const scrollTo = (id) => {
  document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' })
}

const stats = [
  { value: '15+', label: 'Années d\'expérience' },
  { value: '200+', label: 'Références produits' },
  { value: '500+', label: 'Clients professionnels' },
  { value: '48h', label: 'Délai de livraison' },
]

const productCards = [
  {
    name: 'MDF Mélaminé Blanc',
    tag: 'Bestseller',
    style: {
      background: 'linear-gradient(135deg, #F0ECE4 0%, #E8E0D0 40%, #D8CFC0 100%)',
    }
  },
  {
    name: 'MDF Mélaminé Chêne',
    tag: 'Naturel',
    style: {
      background: 'linear-gradient(135deg, #C4975A 0%, #A87840 40%, #8B6030 100%)',
    }
  },
  {
    name: 'MDF Mélaminé Wengé',
    tag: 'Premium',
    style: {
      background: 'linear-gradient(135deg, #3D2B1F 0%, #2A1D14 50%, #1A1008 100%)',
    }
  },
]

onMounted(() => {
  setTimeout(() => { contentVisible.value = true }, 200)
  setTimeout(() => { cardsVisible.value = true },   500)
  setTimeout(() => { badgeVisible.value = true },   1000)
})
</script>

<style scoped>
.hero {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  overflow: hidden;
  padding: 0 60px;
}

/* ── BACKGROUND ── */
.hero__bg {
  position: absolute;
  inset: 0;
  z-index: 0;
}

.hero__panels {
  position: absolute;
  inset: 0;
  display: grid;
  grid-template-columns: repeat(6, 1fr);
  gap: 2px;
  transform: skewX(-8deg) scale(1.15);
}

.hero__panel {
  height: 100%;
  animation: panelShift 12s ease-in-out infinite alternate;
}

.hero__panel--1 { background: linear-gradient(180deg, #2A1D14 0%, #3D2B1F 40%, #2A1D14 100%); animation-delay: 0s; }
.hero__panel--2 { background: linear-gradient(180deg, #A87840 0%, #C4975A 40%, #8B6030 100%); animation-delay: 0.3s; }
.hero__panel--3 { background: linear-gradient(180deg, #F0ECE4 0%, #E0D8C8 40%, #D0C8B8 100%); animation-delay: 0.6s; }
.hero__panel--4 { background: linear-gradient(180deg, #3D2B1F 0%, #5C3D25 40%, #3D2B1F 100%); animation-delay: 0.9s; }
.hero__panel--5 { background: linear-gradient(180deg, #C4975A 0%, #A87840 40%, #C4975A 100%); animation-delay: 1.2s; }
.hero__panel--6 { background: linear-gradient(180deg, #E8E0D0 0%, #F0ECE4 40%, #D8D0C0 100%); animation-delay: 1.5s; }

@keyframes panelShift {
  0%   { transform: translateY(0px); }
  100% { transform: translateY(-20px); }
}

.hero__overlay {
  position: absolute;
  inset: 0;
  background:
    linear-gradient(90deg,
      rgba(17, 29, 17, 0.97) 0%,
      rgba(17, 29, 17, 0.88) 40%,
      rgba(17, 29, 17, 0.50) 65%,
      rgba(17, 29, 17, 0.20) 100%
    );
}

.hero__grain {
  position: absolute;
  inset: 0;
  opacity: 0.04;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
  background-size: 200px 200px;
  pointer-events: none;
}

/* ── BADGE ── */
.hero__badge {
  position: absolute;
  top: 120px;
  right: 60px;
  display: flex;
  align-items: center;
  gap: 10px;
  background: rgba(201, 168, 124, 0.12);
  border: 1px solid rgba(201, 168, 124, 0.3);
  backdrop-filter: blur(12px);
  padding: 10px 18px;
  border-radius: 40px;
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 1.5px;
  color: var(--wood-light);
  z-index: 10;
  opacity: 0;
  transform: translateY(-8px);
  transition: all 0.6s ease;
}

.hero__badge.visible { opacity: 1; transform: translateY(0); }

.hero__badge-dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: #4CAF50;
  box-shadow: 0 0 8px rgba(76, 175, 80, 0.6);
  animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
  0%, 100% { box-shadow: 0 0 8px rgba(76, 175, 80, 0.6); }
  50%       { box-shadow: 0 0 16px rgba(76, 175, 80, 0.9); }
}

/* ── CONTENT ── */
.hero__content {
  position: relative;
  z-index: 5;
  max-width: 560px;
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 0.9s ease, transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
}

.hero__content.visible { opacity: 1; transform: translateY(0); }

.hero__eyebrow {
  display: flex;
  align-items: center;
  gap: 14px;
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 2.5px;
  text-transform: uppercase;
  color: var(--wood);
  margin-bottom: 28px;
}

.hero__eyebrow-line {
  display: block;
  width: 32px;
  height: 1px;
  background: var(--wood);
  flex-shrink: 0;
}

.hero__title {
  font-family: var(--font-display);
  font-size: clamp(52px, 6vw, 80px);
  font-weight: 300;
  line-height: 1.05;
  color: var(--cream);
  margin-bottom: 28px;
  letter-spacing: -0.5px;
}

.hero__title em {
  font-style: italic;
  color: var(--wood);
}

.hero__subtitle {
  font-size: 15px;
  font-weight: 300;
  line-height: 1.8;
  color: rgba(245, 240, 232, 0.65);
  max-width: 420px;
  margin-bottom: 44px;
}

/* ── ACTIONS ── */
.hero__actions {
  display: flex;
  gap: 16px;
  align-items: center;
  flex-wrap: wrap;
}

.btn-primary {
  display: flex;
  align-items: center;
  gap: 10px;
  background: var(--wood);
  color: var(--forest-deep);
  font-family: var(--font-mono);
  font-size: 11px;
  font-weight: 500;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  padding: 15px 28px;
  border-radius: 2px;
  transition: background 0.25s, transform 0.2s, box-shadow 0.25s;
  box-shadow: 0 4px 24px rgba(201, 168, 124, 0.25);
}

.btn-primary:hover {
  background: var(--wood-light);
  transform: translateY(-2px);
  box-shadow: 0 8px 32px rgba(201, 168, 124, 0.35);
}

.btn-ghost {
  background: transparent;
  color: rgba(245, 240, 232, 0.8);
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  padding: 15px 24px;
  border: 1px solid rgba(245, 240, 232, 0.25);
  border-radius: 2px;
  transition: border-color 0.25s, color 0.25s, transform 0.2s;
}

.btn-ghost:hover {
  border-color: var(--wood);
  color: var(--wood);
  transform: translateY(-2px);
}

/* ── SCROLL HINT ── */
.hero__scroll {
  display: flex;
  align-items: center;
  gap: 14px;
  margin-top: 56px;
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: rgba(245, 240, 232, 0.35);
}

.hero__scroll-line {
  width: 1px;
  height: 40px;
  background: linear-gradient(180deg, var(--wood) 0%, transparent 100%);
  animation: scrollLine 2s ease-in-out infinite;
}

@keyframes scrollLine {
  0%, 100% { opacity: 0.4; transform: scaleY(1); }
  50%       { opacity: 1;   transform: scaleY(1.2); }
}

/* ── PRODUCT CARDS ── */
.hero__cards {
  position: absolute;
  right: 60px;
  top: 50%;
  transform: translateY(-40%);
  z-index: 5;
  display: flex;
  flex-direction: column;
  gap: 14px;
  opacity: 0;
  transition: opacity 0.8s ease;
}

.hero__cards.visible { opacity: 1; }

.hero__card {
  position: relative;
  width: 200px;
  height: 80px;
  border-radius: 4px;
  overflow: hidden;
  cursor: pointer;
  border: 1px solid rgba(255,255,255,0.08);
  opacity: 0;
  transform: translateX(30px);
  transition: opacity 0.6s ease, transform 0.6s cubic-bezier(0.16,1,0.3,1), box-shadow 0.3s ease;
}

.hero__cards.visible .hero__card {
  opacity: 1;
  transform: translateX(0);
}

.hero__card:hover {
  box-shadow: 0 8px 32px rgba(0,0,0,0.4);
  transform: translateX(-4px) scale(1.02);
}

.hero__card-visual {
  position: absolute;
  inset: 0;
  /* Simulate wood grain lines */
  background-image: repeating-linear-gradient(
    175deg,
    transparent 0px,
    transparent 8px,
    rgba(0,0,0,0.06) 8px,
    rgba(0,0,0,0.06) 9px
  );
  background-size: 100% 100%;
}

.hero__card-info {
  position: absolute;
  inset: 0;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  padding: 12px 14px;
  background: linear-gradient(180deg, transparent 30%, rgba(0,0,0,0.55) 100%);
}

.hero__card-tag {
  font-family: var(--font-mono);
  font-size: 9px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--wood-light);
  margin-bottom: 3px;
}

.hero__card-name {
  font-size: 12px;
  font-weight: 400;
  color: var(--cream);
  line-height: 1.3;
}

.hero__card-shine {
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, transparent 60%);
  pointer-events: none;
}

/* ── STATS ── */
.hero__stats {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  z-index: 5;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  border-top: 1px solid rgba(201, 168, 124, 0.15);
  background: rgba(17, 29, 17, 0.7);
  backdrop-filter: blur(16px);
}

.hero__stat {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 22px 20px;
  border-right: 1px solid rgba(201, 168, 124, 0.1);
  gap: 4px;
}

.hero__stat:last-child { border-right: none; }

.hero__stat strong {
  font-family: var(--font-display);
  font-size: 30px;
  font-weight: 400;
  color: var(--wood);
  line-height: 1;
}

.hero__stat span {
  font-family: var(--font-mono);
  font-size: 9px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: rgba(245, 240, 232, 0.45);
}

/* ── RESPONSIVE ── */
@media (max-width: 1100px) {
  .hero__cards { display: none; }
  .hero { padding: 0 40px; }
}

@media (max-width: 700px) {
  .hero { padding: 100px 24px 0; min-height: 100svh; }
  .hero__title { font-size: 44px; }
  .hero__stats { grid-template-columns: repeat(2, 1fr); }
  .hero__stat:nth-child(2) { border-right: none; }
  .hero__badge { display: none; }
}
</style>
