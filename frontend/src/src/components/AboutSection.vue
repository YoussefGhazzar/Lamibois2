<template>
  <section id="apropos" class="about" ref="sectionRef">

    <div class="about__inner">

      <!-- Left: Visual -->
      <div class="about__visual" :class="{ visible: inView }">
        <div class="about__image-main">
          <!-- Simulated wood factory / showroom scene -->
          <svg viewBox="0 0 520 580" fill="none" xmlns="http://www.w3.org/2000/svg" class="about__svg">
            <defs>
              <linearGradient id="room-bg" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#1A2E1A"/>
                <stop offset="100%" stop-color="#0E1E0E"/>
              </linearGradient>
              <linearGradient id="floor-g" x1="0%" y1="0%" x2="0%" y2="100%">
                <stop offset="0%" stop-color="#2A1D14"/>
                <stop offset="100%" stop-color="#1A1008"/>
              </linearGradient>
              <linearGradient id="panel-stack" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="#D4B896"/>
                <stop offset="50%" stop-color="#C4A870"/>
                <stop offset="100%" stop-color="#B49060"/>
              </linearGradient>
              <linearGradient id="panel-dark" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="#3D2B1F"/>
                <stop offset="100%" stop-color="#2A1D14"/>
              </linearGradient>
              <linearGradient id="panel-white" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="#F5F0E8"/>
                <stop offset="100%" stop-color="#E8E0D0"/>
              </linearGradient>
              <filter id="shadow">
                <feDropShadow dx="0" dy="8" stdDeviation="12" flood-color="rgba(0,0,0,0.4)"/>
              </filter>
            </defs>

            <!-- Background room -->
            <rect width="520" height="580" fill="url(#room-bg)"/>

            <!-- Floor -->
            <polygon points="0,420 520,380 520,580 0,580" fill="url(#floor-g)"/>
            <!-- Floor grain -->
            <line x1="0" y1="450" x2="520" y2="422" stroke="#3D2B1F" stroke-width="1.5" opacity="0.4"/>
            <line x1="0" y1="490" x2="520" y2="462" stroke="#3D2B1F" stroke-width="1.5" opacity="0.35"/>
            <line x1="0" y1="530" x2="520" y2="502" stroke="#3D2B1F" stroke-width="1.5" opacity="0.3"/>

            <!-- Wall panels background -->
            <rect x="0" y="0" width="520" height="430" fill="#142014" opacity="0.5"/>
            <!-- Vertical wall slats -->
            <rect x="30"  y="0" width="18" height="430" fill="#1A2E1A" opacity="0.8"/>
            <rect x="70"  y="0" width="18" height="430" fill="#1A2E1A" opacity="0.8"/>
            <rect x="110" y="0" width="18" height="430" fill="#1A2E1A" opacity="0.8"/>
            <rect x="160" y="0" width="18" height="430" fill="#1A2E1A" opacity="0.8"/>
            <rect x="210" y="0" width="18" height="430" fill="#1A2E1A" opacity="0.8"/>
            <rect x="260" y="0" width="18" height="430" fill="#1A2E1A" opacity="0.8"/>
            <rect x="310" y="0" width="18" height="430" fill="#1A2E1A" opacity="0.8"/>
            <rect x="360" y="0" width="18" height="430" fill="#1A2E1A" opacity="0.8"/>
            <rect x="410" y="0" width="18" height="430" fill="#1A2E1A" opacity="0.8"/>
            <rect x="460" y="0" width="18" height="430" fill="#1A2E1A" opacity="0.8"/>

            <!-- Stacked panels group (center) -->
            <g filter="url(#shadow)">
              <!-- Stack of panels leaning -->
              <!-- Panel 1: Oak -->
              <rect x="80" y="180" width="300" height="22" rx="1" fill="url(#panel-stack)" transform="rotate(-2, 230, 191)"/>
              <rect x="80" y="180" width="300" height="3"  rx="0" fill="#8B6030" opacity="0.4" transform="rotate(-2, 230, 191)"/>

              <!-- Panel 2: White -->
              <rect x="85" y="200" width="300" height="22" rx="1" fill="url(#panel-white)" transform="rotate(-2, 235, 211)"/>
              <rect x="85" y="200" width="300" height="3"  rx="0" fill="#C0BBAE" opacity="0.3" transform="rotate(-2, 235, 211)"/>

              <!-- Panel 3: Dark -->
              <rect x="90" y="220" width="300" height="22" rx="1" fill="url(#panel-dark)" transform="rotate(-2, 240, 231)"/>
              <rect x="90" y="220" width="300" height="3"  rx="0" fill="#0A0604" opacity="0.6" transform="rotate(-2, 240, 231)"/>

              <!-- Panel 4: Oak -->
              <rect x="95" y="240" width="300" height="22" rx="1" fill="url(#panel-stack)" transform="rotate(-2, 245, 251)"/>
              <rect x="95" y="240" width="300" height="3"  rx="0" fill="#8B6030" opacity="0.4" transform="rotate(-2, 245, 251)"/>

              <!-- Panel 5: White -->
              <rect x="100" y="260" width="300" height="22" rx="1" fill="url(#panel-white)" transform="rotate(-2, 250, 271)"/>

              <!-- Panel 6: Dark -->
              <rect x="105" y="280" width="300" height="22" rx="1" fill="url(#panel-dark)" transform="rotate(-2, 255, 291)"/>

              <!-- Panel 7: Oak -->
              <rect x="110" y="300" width="300" height="22" rx="1" fill="url(#panel-stack)" transform="rotate(-2, 260, 311)"/>
            </g>

            <!-- Vertical stacked panels on left -->
            <g>
              <rect x="40"  y="220" width="14" height="180" rx="1" fill="#D4B896"/>
              <rect x="56"  y="220" width="14" height="180" rx="1" fill="#2A1D14"/>
              <rect x="72"  y="220" width="14" height="180" rx="1" fill="#F0ECE4"/>
              <rect x="88"  y="220" width="14" height="180" rx="1" fill="#C4975A"/>
              <rect x="104" y="220" width="14" height="180" rx="1" fill="#3D2B1F"/>
              <rect x="120" y="220" width="14" height="180" rx="1" fill="#E8E0D0"/>
              <!-- Edge lines -->
              <line x1="54"  y1="220" x2="54"  y2="400" stroke="#2D1A10" stroke-width="1" opacity="0.6"/>
              <line x1="70"  y1="220" x2="70"  y2="400" stroke="#2D1A10" stroke-width="1" opacity="0.6"/>
              <line x1="86"  y1="220" x2="86"  y2="400" stroke="#2D1A10" stroke-width="1" opacity="0.6"/>
              <line x1="102" y1="220" x2="102" y2="400" stroke="#2D1A10" stroke-width="1" opacity="0.6"/>
              <line x1="118" y1="220" x2="118" y2="400" stroke="#2D1A10" stroke-width="1" opacity="0.6"/>
            </g>

            <!-- Spotlight from above -->
            <ellipse cx="260" cy="180" rx="160" ry="40" fill="#C9A87C" opacity="0.06"/>

            <!-- Logo watermark bottom right -->
            <text x="380" y="560" font-family="Cormorant Garamond, serif" font-size="11" fill="rgba(201,168,124,0.3)" letter-spacing="2">LAMIBOIS</text>
          </svg>
        </div>

        <!-- Floating stat card -->
        <div class="about__floating-card">
          <p class="about__floating-num">15<span>+</span></p>
          <p class="about__floating-label">Années d'expertise</p>
        </div>

        <!-- Second accent image -->
        <div class="about__image-accent">
          <svg viewBox="0 0 200 140" xmlns="http://www.w3.org/2000/svg">
            <rect width="200" height="140" fill="#2D4A2D"/>
            <rect x="20" y="20" width="30" height="100" rx="2" fill="#C4975A" opacity="0.9"/>
            <rect x="55" y="20" width="30" height="100" rx="2" fill="#F0ECE4" opacity="0.9"/>
            <rect x="90" y="20" width="30" height="100" rx="2" fill="#3D2B1F" opacity="0.9"/>
            <rect x="125" y="20" width="30" height="100" rx="2" fill="#C4975A" opacity="0.7"/>
            <rect x="160" y="20" width="20" height="100" rx="2" fill="#F0ECE4" opacity="0.6"/>
            <line x1="50"  y1="20" x2="50"  y2="120" stroke="#0A0604" stroke-width="1.5" opacity="0.5"/>
            <line x1="85"  y1="20" x2="85"  y2="120" stroke="#0A0604" stroke-width="1.5" opacity="0.5"/>
            <line x1="120" y1="20" x2="120" y2="120" stroke="#0A0604" stroke-width="1.5" opacity="0.5"/>
            <line x1="155" y1="20" x2="155" y2="120" stroke="#0A0604" stroke-width="1.5" opacity="0.5"/>
            <text x="10" y="135" font-family="DM Mono, monospace" font-size="6" fill="rgba(201,168,124,0.6)" letter-spacing="1">GAMME DE COULEURS</text>
          </svg>
        </div>
      </div>

      <!-- Right: Content -->
      <div class="about__content" :class="{ visible: inView }">
        <p class="label">À propos de Lamibois</p>
        <h2 class="section-title">
          L'art du bois au<br>
          service des <em>artisans</em>
        </h2>

        <p class="about__text">
          Depuis plus de 15 ans, Lamibois est le partenaire de référence des professionnels
          du bois au Maroc. Nous distribuons une gamme complète de panneaux de qualité
          certifiée — MDF mélaminé, contreplaqué, bois massif — directement aux menuisiers,
          architectes d'intérieur et entreprises d'agencement.
        </p>

        <p class="about__text">
          Notre engagement est simple : fournir des matériaux de premier choix,
          disponibles immédiatement, avec un conseil technique adapté à chaque projet.
        </p>

        <!-- Values -->
        <div class="about__values">
          <div v-for="val in values" :key="val.title" class="about__value">
            <div class="about__value-icon">{{ val.icon }}</div>
            <div>
              <h4 class="about__value-title">{{ val.title }}</h4>
              <p class="about__value-desc">{{ val.desc }}</p>
            </div>
          </div>
        </div>

        <button class="about__cta" @click="scrollTo('contact')">
          Contacter notre équipe
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
            <path d="M2 7h10M7 2l5 5-5 5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const sectionRef = ref(null)
const inView     = ref(false)

const scrollTo = (id) => document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' })

const values = [
  { icon: '◈', title: 'Qualité certifiée',      desc: 'Tous nos produits respectent les normes européennes E1 et CARB.' },
  { icon: '◎', title: 'Stock permanent',         desc: '200+ références disponibles immédiatement dans notre entrepôt.' },
  { icon: '◆', title: 'Expertise technique',     desc: 'Notre équipe vous conseille dans le choix du bon matériau.' },
]

let observer
onMounted(() => {
  observer = new IntersectionObserver(
    ([e]) => { if (e.isIntersecting) inView.value = true },
    { threshold: 0.15 }
  )
  if (sectionRef.value) observer.observe(sectionRef.value)
})
onUnmounted(() => observer?.disconnect())
</script>

<style scoped>
.about {
  padding: 120px 60px;
  background: var(--linen);
  overflow: hidden;
}

.about__inner {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 80px;
  align-items: center;
  max-width: 1200px;
  margin: 0 auto;
}

/* ── VISUAL ── */
.about__visual {
  position: relative;
  opacity: 0;
  transform: translateX(-30px);
  transition: opacity 0.9s ease, transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
}
.about__visual.visible { opacity: 1; transform: translateX(0); }

.about__image-main {
  border-radius: 4px;
  overflow: hidden;
  box-shadow: 0 24px 72px rgba(26, 46, 26, 0.25);
  aspect-ratio: 520 / 580;
}

.about__svg { width: 100%; height: 100%; display: block; }

.about__floating-card {
  position: absolute;
  bottom: 32px;
  right: -24px;
  background: var(--forest);
  padding: 20px 28px;
  border-radius: 3px;
  box-shadow: 0 12px 40px rgba(17, 29, 17, 0.4);
}

.about__floating-num {
  font-family: var(--font-display);
  font-size: 48px;
  font-weight: 300;
  color: var(--wood);
  line-height: 1;
}

.about__floating-num span {
  font-size: 28px;
  color: var(--wood-light);
}

.about__floating-label {
  font-family: var(--font-mono);
  font-size: 9px;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: rgba(245, 240, 232, 0.55);
  margin-top: 6px;
}

.about__image-accent {
  position: absolute;
  top: 24px;
  right: -32px;
  width: 160px;
  border-radius: 3px;
  overflow: hidden;
  box-shadow: 0 8px 24px rgba(0,0,0,0.3);
}

.about__image-accent svg { width: 100%; display: block; }

/* ── CONTENT ── */
.about__content {
  opacity: 0;
  transform: translateX(30px);
  transition: opacity 0.9s ease 0.2s, transform 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.2s;
}
.about__content.visible { opacity: 1; transform: translateX(0); }

.label {
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: var(--wood);
  margin-bottom: 12px;
  display: flex;
  align-items: center;
  gap: 12px;
}

.label::before {
  content: '';
  display: block;
  width: 24px; height: 1px;
  background: var(--wood);
}

.section-title {
  font-family: var(--font-display);
  font-size: clamp(32px, 3.5vw, 46px);
  font-weight: 300;
  color: var(--forest);
  line-height: 1.15;
  margin-bottom: 28px;
}

.section-title em { font-style: italic; color: var(--wood); }

.about__text {
  font-size: 14px;
  font-weight: 300;
  line-height: 1.9;
  color: var(--mist);
  margin-bottom: 20px;
}

/* Values */
.about__values {
  margin: 36px 0;
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.about__value {
  display: flex;
  gap: 18px;
  align-items: flex-start;
}

.about__value-icon {
  width: 36px;
  height: 36px;
  border-radius: 2px;
  background: var(--forest);
  color: var(--wood);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  flex-shrink: 0;
  margin-top: 2px;
}

.about__value-title {
  font-family: var(--font-display);
  font-size: 18px;
  font-weight: 400;
  color: var(--forest);
  margin-bottom: 4px;
}

.about__value-desc {
  font-size: 13px;
  font-weight: 300;
  line-height: 1.7;
  color: var(--mist);
}

.about__cta {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: var(--forest);
  color: var(--cream);
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  padding: 15px 28px;
  border-radius: 2px;
  transition: background 0.25s, transform 0.2s;
  margin-top: 8px;
}

.about__cta:hover {
  background: var(--forest-dark);
  transform: translateY(-2px);
}

@media (max-width: 900px) {
  .about { padding: 80px 24px; }
  .about__inner { grid-template-columns: 1fr; gap: 48px; }
  .about__floating-card { right: 16px; }
  .about__image-accent { display: none; }
}
</style>
