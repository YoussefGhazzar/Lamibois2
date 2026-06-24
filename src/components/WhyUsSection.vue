<template>
  <section class="why" ref="sectionRef">

    <!-- Background texture -->
    <div class="why__bg">
      <div class="why__bg-panels">
        <div v-for="i in 8" :key="i" class="why__bg-panel" :style="panelStyle(i)"></div>
      </div>
      <div class="why__bg-overlay"></div>
    </div>

    <div class="why__inner">

      <!-- Header -->
      <div class="why__header" :class="{ visible: inView }">
        <p class="why__label">Pourquoi Lamibois</p>
        <h2 class="why__title">Un partenaire de confiance<br>pour les <em>professionnels</em></h2>
      </div>

      <!-- Cards grid -->
      <div class="why__grid">
        <div
          v-for="(card, i) in cards"
          :key="card.id"
          class="why__card"
          :class="{ visible: inView }"
          :style="{ transitionDelay: `${0.2 + i * 0.12}s` }"
        >
          <div class="why__card-num">{{ card.num }}</div>
          <div class="why__card-icon">{{ card.icon }}</div>
          <h3 class="why__card-title">{{ card.title }}</h3>
          <p class="why__card-body">{{ card.body }}</p>
          <div class="why__card-bar"></div>
        </div>
      </div>

      <!-- Bottom CTA -->
      <div class="why__bottom" :class="{ visible: inView }">
        <div class="why__bottom-text">
          <p>Vous avez des questions sur nos produits ou délais ?</p>
        </div>
        <button class="why__bottom-btn" @click="$router.push('/contact')">
          Parler à un expert →
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

const cards = [
  {
    id: 1, num: '01', icon: '▣',
    title: 'Stock permanent',
    body: 'Plus de 200 références disponibles immédiatement. Aucune rupture sur nos gammes standards, zéro attente pour vos chantiers.'
  },
  {
    id: 2, num: '02', icon: '◈',
    title: 'Qualité certifiée',
    body: 'Tous nos panneaux respectent les normes E1 et CARB P2. Chaque lot est contrôlé à la réception pour garantir une qualité constante.'
  },
  {
    id: 3, num: '03', icon: '◎',
    title: 'Livraison 48h',
    body: 'Livraison rapide sur tout le Maroc. Notre flotte de transport assure une manutention soignée de vos panneaux jusqu\'au chantier.'
  },
  {
    id: 4, num: '04', icon: '◆',
    title: 'Conseil technique',
    body: 'Notre équipe technique vous accompagne dans le choix du matériau le plus adapté à votre projet. Devis personnalisé sous 24h.'
  },
  {
    id: 5, num: '05', icon: '◉',
    title: 'Coupe sur mesure',
    body: 'Service de découpe à la commande pour optimiser votre matière et réduire les chutes. Précision au millimètre.'
  },
  {
    id: 6, num: '06', icon: '◇',
    title: 'Tarifs professionnels',
    body: 'Des prix adaptés aux volumes professionnels avec des remises progressives selon votre consommation mensuelle.'
  },
]

const panelStyle = (i) => {
  const colors = ['#D4B896', '#F0ECE4', '#3D2B1F', '#C4975A', '#E8E0D0', '#2A1D14', '#B49060', '#F5F0E8']
  return {
    background: `linear-gradient(180deg, ${colors[(i - 1) % colors.length]}, ${colors[i % colors.length]})`,
    opacity: 0.06 + (i % 3) * 0.02
  }
}

let observer
onMounted(() => {
  observer = new IntersectionObserver(
    ([e]) => { if (e.isIntersecting) inView.value = true },
    { threshold: 0.1 }
  )
  if (sectionRef.value) observer.observe(sectionRef.value)
})
onUnmounted(() => observer?.disconnect())
</script>

<style scoped>
.why {
  position: relative;
  padding: 120px 60px;
  overflow: hidden;
}

/* Background */
.why__bg {
  position: absolute;
  inset: 0;
  z-index: 0;
}

.why__bg-panels {
  position: absolute;
  inset: 0;
  display: grid;
  grid-template-columns: repeat(8, 1fr);
}

.why__bg-panel { height: 100%; }

.why__bg-overlay {
  position: absolute;
  inset: 0;
  background: var(--forest-deep);
  opacity: 0.96;
}

.why__inner {
  position: relative;
  z-index: 1;
  max-width: 1200px;
  margin: 0 auto;
}

/* Header */
.why__header {
  text-align: center;
  margin-bottom: 72px;
  opacity: 0;
  transform: translateY(24px);
  transition: opacity 0.7s ease, transform 0.7s ease;
}
.why__header.visible { opacity: 1; transform: translateY(0); }

.why__label {
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: var(--wood);
  margin-bottom: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 16px;
}

.why__label::before, .why__label::after {
  content: '';
  display: block;
  width: 40px; height: 1px;
  background: rgba(201, 168, 124, 0.4);
}

.why__title {
  font-family: var(--font-display);
  font-size: clamp(32px, 4vw, 50px);
  font-weight: 300;
  color: var(--cream);
  line-height: 1.15;
}

.why__title em { font-style: italic; color: var(--wood); }

/* Grid */
.why__grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2px;
  margin-bottom: 64px;
}

.why__card {
  padding: 44px 36px;
  background: rgba(255, 255, 255, 0.03);
  border: 1px solid rgba(201, 168, 124, 0.08);
  position: relative;
  overflow: hidden;
  opacity: 0;
  transform: translateY(24px);
  transition: opacity 0.6s ease, transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), background 0.3s ease;
  cursor: default;
}

.why__card.visible { opacity: 1; transform: translateY(0); }

.why__card:hover {
  background: rgba(201, 168, 124, 0.06);
}

.why__card:hover .why__card-bar {
  transform: scaleX(1);
}

.why__card-num {
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 2px;
  color: rgba(201, 168, 124, 0.4);
  margin-bottom: 20px;
}

.why__card-icon {
  font-size: 20px;
  color: var(--wood);
  margin-bottom: 16px;
  opacity: 0.8;
}

.why__card-title {
  font-family: var(--font-display);
  font-size: 24px;
  font-weight: 400;
  color: var(--cream);
  margin-bottom: 14px;
  line-height: 1.2;
}

.why__card-body {
  font-size: 13px;
  font-weight: 300;
  line-height: 1.85;
  color: rgba(245, 240, 232, 0.5);
}

.why__card-bar {
  position: absolute;
  bottom: 0; left: 0;
  width: 100%; height: 2px;
  background: linear-gradient(90deg, var(--wood), transparent);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.4s ease;
}

/* Bottom CTA */
.why__bottom {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 32px 40px;
  background: rgba(201, 168, 124, 0.08);
  border: 1px solid rgba(201, 168, 124, 0.15);
  border-radius: 3px;
  opacity: 0;
  transform: translateY(16px);
  transition: opacity 0.6s ease 0.7s, transform 0.6s ease 0.7s;
}
.why__bottom.visible { opacity: 1; transform: translateY(0); }

.why__bottom-text p {
  font-size: 15px;
  font-weight: 300;
  color: rgba(245, 240, 232, 0.65);
}

.why__bottom-btn {
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 2px;
  text-transform: uppercase;
  background: var(--wood);
  color: var(--forest-deep);
  padding: 13px 28px;
  border-radius: 2px;
  white-space: nowrap;
  transition: background 0.25s, transform 0.2s;
}

.why__bottom-btn:hover {
  background: var(--wood-light);
  transform: translateY(-2px);
}

@media (max-width: 900px) {
  .why { padding: 80px 24px; }
  .why__grid { grid-template-columns: 1fr; }
  .why__bottom { flex-direction: column; gap: 20px; text-align: center; }
}

@media (min-width: 901px) and (max-width: 1100px) {
  .why__grid { grid-template-columns: repeat(2, 1fr); }
}
</style>
