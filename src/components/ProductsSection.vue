<template>
  <section id="produits" class="products" ref="sectionRef" :class="{ 'products--rtl': isRTL }">

    <div class="products__header">
      <div class="products__header-left" :class="{ visible: inView }">
        <p class="label">{{ t('products.label') }}</p>
        <h2 class="section-title">{{ t('products.title_line1') }}<br><em>{{ t('products.title_em') }}</em></h2>
        <p class="products__intro">{{ t('products.intro') }}</p>
      </div>

      <div class="products__filter" :class="{ visible: inView }">
        <button
          v-for="cat in categories"
          :key="cat"
          class="products__filter-btn"
          :class="{ active: activeCategory === cat }"
          @click="activeCategory = cat"
        >{{ `${cat}` }}</button>
      </div>
    </div>

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
        <!-- Real Image -->
        <div class="products__card-visual">
          <img :src="product.image" :alt="t(`products.items.${product.id}.name`)" class="products__card-img" />
          <div class="products__card-overlay"></div>
        </div>

        <!-- Hover: specs overlay -->
        <div class="products__card-specs">
          <div v-for="spec in product.specs" :key="spec.labelKey" class="spec-row">
            <span class="spec-label">{{ t(`products.specs.${spec.labelKey}`) }}</span>
            <span class="spec-value">{{ t(`products.items.${product.id}.specs.${spec.labelKey}`) }}</span>
          </div>
        </div>

        <!-- Info -->
        <div class="products__card-info">
          <div>
            <span class="products__card-tag">{{ `products.categories.${product.categoryKey}` }}</span>
            <h3 class="products__card-name">{{ t(`products.items.${product.id}.name`) }}</h3>
            <p class="products__card-desc">{{ t(`products.items.${product.id}.desc`) }}</p>
          </div>
          <button class="products__card-btn" @click="$router.push('/produits')">
            {{ t('products.view_sheet') }}
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
              <path d="M2 6h8M6 2l4 4-4 4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
        </div>

        <!-- Badge -->
        <div v-if="product.badgeKey" class="products__badge">{{ t(`products.badges.${product.badgeKey}`) }}</div>
      </div>
    </div>

    <!-- View all CTA -->
    <div class="products__footer" :class="{ visible: inView }">
      <button class="products__view-all" @click="$router.push('/produits')">
        {{ t('products.view_all') }}
        <span class="products__view-arrow">→</span>
      </button>
    </div>

  </section>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useI18n } from 'vue-i18n'

import imgMelamine  from '@/assets/products/panneau_melamine.png'
import imgMDFBrut   from '@/assets/products/panneaux_MDFbrut.png'
import imgHydrofuge from '@/assets/products/Hydrofuge_HDF.png'
import imgHighGloss from '@/assets/products/panneaux_high_gloss_mdf.png'
import imgCompacto  from '@/assets/products/panneau_compacto.png'
import imgStratidecor from '@/assets/products/stratidecor.png'

const { t, locale } = useI18n()

const sectionRef     = ref(null)
const inView         = ref(false)
const hoveredId      = ref(null)
const activeCategory = ref('all')

const isRTL = computed(() => locale.value === 'ar')

const categories = ['all', 'mdf_melamine', 'hpl', 'laminate']

const products = [
  {
    id: 1, size: 'large', categoryKey: 'mdf_melamine', badgeKey: 'bestseller',
    image: imgMelamine,
    specs: [
      { labelKey: 'thickness' },
      { labelKey: 'format' },
      { labelKey: 'decors' },
      { labelKey: 'standard' },
    ]
  },
  {
    id: 2, size: 'medium', categoryKey: 'mdf_melamine',
    image: imgMDFBrut,
    specs: [
      { labelKey: 'thickness' },
      { labelKey: 'format' },
      { labelKey: 'density' },
      { labelKey: 'standard' },
    ]
  },
  {
    id: 3, size: 'medium', categoryKey: 'mdf_melamine', badgeKey: 'resistant',
    image: imgHydrofuge,
    specs: [
      { labelKey: 'thickness' },
      { labelKey: 'format' },
      { labelKey: 'treatment' },
      { labelKey: 'standard' },
    ]
  },
  {
    id: 4, size: 'medium', categoryKey: 'mdf_melamine', badgeKey: 'premium',
    image: imgHighGloss,
    specs: [
      { labelKey: 'thickness' },
      { labelKey: 'format' },
      { labelKey: 'finish' },
      { labelKey: 'colors' },
    ]
  },
  {
    id: 5, size: 'medium', categoryKey: 'hpl', badgeKey: 'high_performance',
    image: imgCompacto,
    specs: [
      { labelKey: 'thickness' },
      { labelKey: 'format' },
      { labelKey: 'resistance' },
      { labelKey: 'usage' },
    ]
  },
  {
    id: 6, size: 'medium', categoryKey: 'laminate',
    image: imgStratidecor,
    specs: [
      { labelKey: 'thickness' },
      { labelKey: 'format' },
      { labelKey: 'decors' },
      { labelKey: 'finish' },
    ]
  },
]

const filteredProducts = computed(() => {
  if (activeCategory.value === 'all') return products
  return products.filter(p => p.categoryKey === activeCategory.value)
})

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

.section-title em { font-style: italic; color: var(--wood); }

.products__intro {
  font-size: 14px;
  font-weight: 300;
  line-height: 1.8;
  color: var(--mist);
  max-width: 400px;
}

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

.products__filter-btn:hover { border-color: var(--wood); color: var(--forest); }
.products__filter-btn.active { background: var(--forest); border-color: var(--forest); color: var(--cream); }

.products__grid {
  display: grid;
  grid-template-columns: repeat(6, 1fr);
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

.products__card-visual {
  position: absolute;
  inset: 0;
  overflow: hidden;
}

.products__card-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.5s ease;
}

.products__card:hover .products__card-img { transform: scale(1.05); }

.products__card-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, rgba(17,29,17,0) 30%, rgba(17,29,17,0.82) 100%);
}

.products__card-specs {
  position: absolute;
  top: 0; left: 0; right: 0;
  padding: 20px;
  display: flex;
  flex-direction: column;
  gap: 8px;
  background: linear-gradient(180deg, rgba(17,29,17,0.7) 0%, transparent 100%);
  opacity: 0;
  transform: translateY(-10px);
  transition: opacity 0.35s ease, transform 0.35s ease;
  pointer-events: none;
}

.products__card:hover .products__card-specs { opacity: 1; transform: translateY(0); }

.spec-row { display: flex; justify-content: space-between; align-items: center; }

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

.products__card:hover .products__card-desc { opacity: 1; transform: translateY(0); }

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
  cursor: pointer;
}

.products__card:hover .products__card-btn { opacity: 1; transform: translateY(0); }
.products__card-btn:hover { background: var(--wood); color: var(--forest-deep); border-color: var(--wood); }

.products__badge {
  position: absolute;
  top: 16px; right: 16px;
  font-family: var(--font-mono);
  font-size: 9px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  background: var(--wood);
  color: var(--forest-deep);
  padding: 5px 12px;
  border-radius: 1px;
}

.products--rtl .products__badge {
  right: auto;
  left: 16px;
}

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
  cursor: pointer;
  transition: all 0.3s ease;
}

.products__view-all:hover { background: var(--forest); color: var(--cream); border-color: var(--forest); }
.products__view-arrow { transition: transform 0.3s ease; }
.products__view-all:hover .products__view-arrow { transform: translateX(4px); }
.products--rtl .products__view-all:hover .products__view-arrow { transform: translateX(-4px); }

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