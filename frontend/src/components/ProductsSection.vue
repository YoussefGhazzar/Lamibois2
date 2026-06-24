<template>
  <section id="produits" class="products" ref="sectionRef">

    <div class="products__header">
      <div class="products__header-left" :class="{ visible: inView }">
        <p class="label">Nos gammes</p>
        <h2 class="section-title">Des panneaux pour<br><em>chaque application</em></h2>
        <p class="products__intro">
          Une sélection rigoureuse de matériaux pour répondre aux exigences
          des menuisiers, agenceurs, architectes et professionnels du bâtiment.
        </p>
      </div>

      <div class="products__filter" :class="{ visible: inView }">
        <button
          v-for="cat in categories"
          :key="cat"
          class="products__filter-btn"
          :class="{ active: activeCategory === cat }"
          @click="activeCategory = cat"
        >{{ cat }}</button>
      </div>
    </div>

    <!-- FEATURED LARGE CARD -->
    <div class="products__grid" :class="{ visible: inView }">
      <div
        v-for="(product, i) in filteredProducts"
        :key="product.id"
        class="products__card"
        :class="[product.size, { hovered: hoveredId === product.id }]"
        :style="{ transitionDelay: `${i * 0.07}s` }"
        @mouseenter="hoveredId = product.id"
        @mouseleave="hoveredId = null"
      >
        <!-- Panel Visual -->
        <div class="products__card-visual">
          <MdfPanelVisual :config="product.visual" />
          <div class="products__card-overlay"></div>
        </div>

        <!-- Hover: specs overlay -->
        <div class="products__card-specs">
          <div v-for="spec in product.specs" :key="spec.label" class="spec-row">
            <span class="spec-label">{{ spec.label }}</span>
            <span class="spec-value">{{ spec.value }}</span>
          </div>
        </div>

        <!-- Info -->
        <div class="products__card-info">
          <div>
            <span class="products__card-tag">{{ product.category }}</span>
            <h3 class="products__card-name">{{ product.name }}</h3>
            <p class="products__card-desc">{{ product.desc }}</p>
          </div>
          <button class="products__card-btn" @click="$router.push(`/produits`)">
            Voir la fiche
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
              <path d="M2 6h8M6 2l4 4-4 4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
        </div>

        <!-- Corner badge for featured -->
        <div v-if="product.badge" class="products__badge">{{ product.badge }}</div>
      </div>
    </div>

    <!-- View all CTA -->
    <div class="products__footer" :class="{ visible: inView }">
      <button class="products__view-all" @click="$router.push(`/produits`)">
        Voir tout le catalogue
        <span class="products__view-arrow">→</span>
      </button>
    </div>

  </section>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import MdfPanelVisual from './MdfPanelVisual.vue'

const sectionRef     = ref(null)
const inView         = ref(false)
const hoveredId      = ref(null)
const activeCategory = ref('Tous')

const categories = ['Tous', 'MDF Mélaminé', 'Contreplaqué', 'Bois Massif', 'OSB']

const products = [
  {
    id: 1, size: 'large',
    name: 'MDF Mélaminé Blanc Perle',
    category: 'MDF Mélaminé', badge: 'Best seller',
    desc: 'Surface lisse et uniforme, idéale pour l\'agencement intérieur et la fabrication de meubles.',
    visual: { type: 'melamine', color1: '#F5F0E8', color2: '#E8E2D6', color3: '#DDD7CC', lines: 'light' },
    specs: [
      { label: 'Épaisseur', value: '16 / 18 / 22 mm' },
      { label: 'Format', value: '2440 × 1220 mm' },
      { label: 'Finition', value: 'Double face' },
      { label: 'Norme', value: 'E1 / CARB P2' },
    ]
  },
  {
    id: 2, size: 'medium',
    name: 'MDF Mélaminé Chêne Naturel',
    category: 'MDF Mélaminé',
    desc: 'Décor bois authentique avec veiné naturel. Chaleur et élégance pour vos agencements.',
    visual: { type: 'melamine', color1: '#C4975A', color2: '#A87840', color3: '#8B6030', lines: 'wood' },
    specs: [
      { label: 'Épaisseur', value: '16 / 18 mm' },
      { label: 'Format', value: '2440 × 1220 mm' },
      { label: 'Finition', value: 'Texturé bois' },
      { label: 'Norme', value: 'E1' },
    ]
  },
  {
    id: 3, size: 'medium',
    name: 'MDF Mélaminé Wengé',
    category: 'MDF Mélaminé', badge: 'Premium',
    desc: 'Décor wengé foncé pour des intérieurs contemporains et contrastés.',
    visual: { type: 'melamine', color1: '#3D2B1F', color2: '#2A1D14', color3: '#1A1008', lines: 'dark' },
    specs: [
      { label: 'Épaisseur', value: '18 / 22 mm' },
      { label: 'Format', value: '2440 × 1220 mm' },
      { label: 'Finition', value: 'Satiné' },
      { label: 'Norme', value: 'E1' },
    ]
  },
  {
    id: 4, size: 'medium',
    name: 'Contreplaqué Peuplier',
    category: 'Contreplaqué',
    desc: 'Léger et résistant, idéal pour le fond de meuble, l\'emballage et la construction légère.',
    visual: { type: 'plywood', color1: '#D4B896', color2: '#C4A07A', color3: '#B89060', lines: 'plywood' },
    specs: [
      { label: 'Épaisseur', value: '4 / 8 / 12 / 18 mm' },
      { label: 'Format', value: '2500 × 1220 mm' },
      { label: 'Qualité', value: 'BB/BB' },
      { label: 'Norme', value: 'CE EN 636' },
    ]
  },
  {
    id: 5, size: 'medium',
    name: 'MDF Mélaminé Gris Béton',
    category: 'MDF Mélaminé',
    desc: 'Aspect béton tendance pour des agencements modernes et industriels.',
    visual: { type: 'melamine', color1: '#9A9590', color2: '#7A7570', color3: '#5A5550', lines: 'concrete' },
    specs: [
      { label: 'Épaisseur', value: '16 / 18 mm' },
      { label: 'Format', value: '2440 × 1220 mm' },
      { label: 'Finition', value: 'Mat structuré' },
      { label: 'Norme', value: 'E1' },
    ]
  },
  {
    id: 6, size: 'medium',
    name: 'Bois Massif Hêtre',
    category: 'Bois Massif', badge: 'Noble',
    desc: 'Bois massif de qualité supérieure pour l\'ébénisterie et la fabrication de meubles haut de gamme.',
    visual: { type: 'solid', color1: '#E8C898', color2: '#D4A870', color3: '#C09050', lines: 'solid' },
    specs: [
      { label: 'Section', value: 'Sur mesure' },
      { label: 'Longueur', value: 'Jusqu\'à 4000 mm' },
      { label: 'Séchage', value: 'KD 8-12%' },
      { label: 'Classe', value: 'A/B' },
    ]
  },
]

const filteredProducts = computed(() => {
  if (activeCategory.value === 'Tous') return products
  return products.filter(p => p.category === activeCategory.value)
})

// Intersection Observer
let observer
onMounted(() => {
  observer = new IntersectionObserver(
    ([entry]) => { if (entry.isIntersecting) inView.value = true },
    { threshold: 0.1 }
  )
  if (sectionRef.value) observer.observe(sectionRef.value)
})
onUnmounted(() => observer?.disconnect())
</script>

<style scoped>
.products {
  padding: 120px 60px;
  background: var(--cream);
}

/* ── HEADER ── */
.products__header {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-bottom: 56px;
  gap: 40px;
  flex-wrap: wrap;
}

.products__header-left {
  opacity: 0;
  transform: translateY(24px);
  transition: opacity 0.7s ease, transform 0.7s ease;
}
.products__header-left.visible { opacity: 1; transform: translateY(0); }

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
  font-size: clamp(32px, 4vw, 48px);
  font-weight: 300;
  color: var(--forest);
  line-height: 1.15;
  margin-bottom: 16px;
}

.section-title em {
  font-style: italic;
  color: var(--wood);
}

.products__intro {
  font-size: 14px;
  font-weight: 300;
  line-height: 1.8;
  color: var(--mist);
  max-width: 400px;
}

/* Filter */
.products__filter {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
  opacity: 0;
  transform: translateY(16px);
  transition: opacity 0.7s ease 0.2s, transform 0.7s ease 0.2s;
}
.products__filter.visible { opacity: 1; transform: translateY(0); }

.products__filter-btn {
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  padding: 9px 18px;
  border-radius: 2px;
  border: 1px solid rgba(45, 74, 45, 0.2);
  background: transparent;
  color: var(--mist);
  cursor: pointer;
  transition: all 0.25s;
}

.products__filter-btn:hover {
  border-color: var(--wood);
  color: var(--forest);
}

.products__filter-btn.active {
  background: var(--forest);
  border-color: var(--forest);
  color: var(--cream);
}

/* ── GRID ── */
.products__grid {
  display: grid;
  grid-template-columns: repeat(6, 1fr);
  grid-template-rows: auto;
  gap: 14px;
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 0.7s ease 0.3s, transform 0.7s ease 0.3s;
}
.products__grid.visible { opacity: 1; transform: translateY(0); }

.products__card {
  position: relative;
  border-radius: 4px;
  overflow: hidden;
  cursor: pointer;
  background: var(--linen);
  border: 1px solid rgba(45, 74, 45, 0.08);
  transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
}

.products__card.large  { grid-column: span 3; grid-row: span 2; min-height: 480px; }
.products__card.medium { grid-column: span 3; min-height: 230px; }

.products__card:hover, .products__card.hovered {
  transform: translateY(-4px);
  box-shadow: 0 16px 48px rgba(45, 74, 45, 0.15);
}

/* Visual */
.products__card-visual {
  position: absolute;
  inset: 0;
  transition: transform 0.5s ease;
}

.products__card:hover .products__card-visual {
  transform: scale(1.04);
}

.products__card-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg,
    rgba(17, 29, 17, 0) 30%,
    rgba(17, 29, 17, 0.75) 100%
  );
  transition: opacity 0.4s;
}

/* Specs (hover reveal) */
.products__card-specs {
  position: absolute;
  top: 0; left: 0; right: 0;
  padding: 20px;
  display: flex;
  flex-direction: column;
  gap: 8px;
  background: linear-gradient(180deg, rgba(17,29,17,0.6) 0%, transparent 100%);
  opacity: 0;
  transform: translateY(-10px);
  transition: opacity 0.35s ease, transform 0.35s ease;
  pointer-events: none;
}

.products__card:hover .products__card-specs {
  opacity: 1;
  transform: translateY(0);
}

.spec-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.spec-label {
  font-family: var(--font-mono);
  font-size: 9px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: rgba(245, 240, 232, 0.5);
}

.spec-value {
  font-family: var(--font-mono);
  font-size: 10px;
  color: var(--wood-light);
}

/* Info */
.products__card-info {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  padding: 24px;
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  gap: 12px;
}

.products__card-tag {
  display: inline-block;
  font-family: var(--font-mono);
  font-size: 9px;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--wood-light);
  margin-bottom: 6px;
}

.products__card-name {
  font-family: var(--font-display);
  font-size: 22px;
  font-weight: 400;
  color: var(--cream);
  line-height: 1.2;
  margin-bottom: 4px;
}

.products__card.large .products__card-name { font-size: 32px; }

.products__card-desc {
  font-size: 12px;
  font-weight: 300;
  color: rgba(245, 240, 232, 0.6);
  line-height: 1.6;
  max-width: 280px;
  opacity: 0;
  transform: translateY(6px);
  transition: opacity 0.3s ease, transform 0.3s ease;
}

.products__card:hover .products__card-desc {
  opacity: 1;
  transform: translateY(0);
}

.products__card-btn {
  display: flex;
  align-items: center;
  gap: 6px;
  flex-shrink: 0;
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--wood);
  background: rgba(201, 168, 124, 0.12);
  border: 1px solid rgba(201, 168, 124, 0.3);
  padding: 8px 14px;
  border-radius: 2px;
  white-space: nowrap;
  opacity: 0;
  transform: translateY(6px);
  transition: opacity 0.3s ease, transform 0.3s ease, background 0.25s;
}

.products__card:hover .products__card-btn {
  opacity: 1;
  transform: translateY(0);
}

.products__card-btn:hover {
  background: var(--wood);
  color: var(--forest-deep);
  border-color: var(--wood);
}

/* Badge */
.products__badge {
  position: absolute;
  top: 16px;
  right: 16px;
  font-family: var(--font-mono);
  font-size: 9px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  background: var(--wood);
  color: var(--forest-deep);
  padding: 5px 12px;
  border-radius: 1px;
}

/* Footer */
.products__footer {
  margin-top: 48px;
  display: flex;
  justify-content: center;
  opacity: 0;
  transform: translateY(16px);
  transition: opacity 0.6s ease 0.5s, transform 0.6s ease 0.5s;
}
.products__footer.visible { opacity: 1; transform: translateY(0); }

.products__view-all {
  display: flex;
  align-items: center;
  gap: 12px;
  font-family: var(--font-mono);
  font-size: 12px;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--forest);
  background: transparent;
  padding: 14px 32px;
  border: 1px solid rgba(45, 74, 45, 0.3);
  border-radius: 2px;
  transition: all 0.3s ease;
}

.products__view-all:hover {
  background: var(--forest);
  color: var(--cream);
  border-color: var(--forest);
}

.products__view-arrow {
  transition: transform 0.3s ease;
}
.products__view-all:hover .products__view-arrow { transform: translateX(4px); }

@media (max-width: 900px) {
  .products { padding: 80px 24px; }
  .products__card.large  { grid-column: span 6; }
  .products__card.medium { grid-column: span 6; }
  .products__header { flex-direction: column; align-items: flex-start; }
}

@media (min-width: 901px) and (max-width: 1200px) {
  .products__card.large  { grid-column: span 4; }
  .products__card.medium { grid-column: span 2; }
}
</style>
