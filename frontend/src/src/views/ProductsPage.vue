<template>
  <div class="products-page">
    <TheNavbar />

    <!-- PAGE HERO -->
    <section class="page-hero">
      <div class="page-hero__bg">
        <img src="@/assets/products/bois_dur.png" alt="Entrepôt Lamibois" class="page-hero__img" />
        <div class="page-hero__overlay"></div>
      </div>
      <div class="page-hero__content">
        <p class="page-hero__eyebrow">
          <span class="page-hero__eyebrow-line"></span>
          Catalogue complet
        </p>
        <h1 class="page-hero__title">Nos <em>Produits</em></h1>
        <p class="page-hero__sub">
          Une gamme complète de panneaux de qualité certifiée pour tous vos projets professionnels.
        </p>
      </div>
      <!-- Breadcrumb -->
      <div class="page-hero__breadcrumb">
        <span @click="goHome">Accueil</span>
        <span class="sep">→</span>
        <span class="current">Produits</span>
      </div>
    </section>

    <!-- FILTER BAR -->
    <div class="filter-bar">
      <div class="filter-bar__inner">
        <button
          v-for="cat in categories"
          :key="cat"
          class="filter-bar__btn"
          :class="{ active: activeCategory === cat }"
          @click="activeCategory = cat"
        >
          {{ cat }}
          <span class="filter-bar__count">{{ countByCategory(cat) }}</span>
        </button>
      </div>
    </div>

    <!-- PRODUCTS GRID -->
    <section class="catalog">
      <div class="catalog__inner">

        <!-- Results info -->
        <div class="catalog__meta">
          <p class="catalog__count">
            <span>{{ filteredProducts.length }}</span> produit{{ filteredProducts.length > 1 ? 's' : '' }} trouvé{{ filteredProducts.length > 1 ? 's' : '' }}
          </p>
        </div>

        <!-- Grid -->
        <div class="catalog__grid">
          <div
            v-for="(product, i) in filteredProducts"
            :key="product.id"
            class="catalog__card"
            :class="{ featured: product.featured }"
            :style="{ animationDelay: `${i * 0.08}s` }"
          >
            <!-- Image -->
            <div class="catalog__card-img-wrap">
              <img
                :src="product.image"
                :alt="product.name"
                class="catalog__card-img"
              />
              <div class="catalog__card-overlay"></div>

              <!-- Badge -->
              <div v-if="product.badge" class="catalog__card-badge">{{ product.badge }}</div>

              <!-- Hover specs -->
              <div class="catalog__card-specs">
                <div v-for="spec in product.specs" :key="spec.label" class="spec-row">
                  <span class="spec-label">{{ spec.label }}</span>
                  <span class="spec-value">{{ spec.value }}</span>
                </div>
                <button class="catalog__card-devis" @click="goContact">
                  Demander un devis →
                </button>
              </div>
            </div>

            <!-- Info -->
            <div class="catalog__card-info">
              <span class="catalog__card-cat">{{ product.category }}</span>
              <h3 class="catalog__card-name">{{ product.name }}</h3>
              <p class="catalog__card-desc">{{ product.desc }}</p>
              <div class="catalog__card-footer">
                <div class="catalog__card-tags">
                  <span v-for="tag in product.tags" :key="tag" class="tag">{{ tag }}</span>
                </div>
                <button class="catalog__card-btn" @click="goContact">
                  Devis
                  <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                    <path d="M2 6h8M6 2l4 4-4 4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Empty state -->
        <div v-if="filteredProducts.length === 0" class="catalog__empty">
          <p>Aucun produit dans cette catégorie.</p>
        </div>

      </div>
    </section>

    <!-- CTA BAND -->
    <div class="cta-band">
      <div class="cta-band__inner">
        <div>
          <h2 class="cta-band__title">Vous ne trouvez pas ce qu'il vous faut ?</h2>
          <p class="cta-band__sub">Notre équipe peut vous sourcer des matériaux sur mesure.</p>
        </div>
        <button class="cta-band__btn" @click="goContact">Contacter notre équipe →</button>
      </div>
    </div>

    <TheFooter />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import TheNavbar from '@/components/TheNavbar.vue'
import TheFooter from '@/components/TheFooter.vue'

import imgHydrofuge   from '@/assets/products/Hydrofuge_HDF.png'
import imgBoisDur     from '@/assets/products/bois_dur.png'
import imgCompacto    from '@/assets/products/panneau_compacto.png'
import imgHighGloss   from '@/assets/products/panneaux_high_gloss_mdf.png'
import imgStratidecor from '@/assets/products/stratidecor.png'
import imgMDFBrut     from '@/assets/products/panneaux_MDFbrut.png'

const router = useRouter()
const goHome    = () => router.push('/')
const goContact = () => router.push('/#contact')

const activeCategory = ref('Tous')

const categories = ['Tous', 'MDF', 'HPL', 'Stratifié', 'Bois']

const products = [
  {
    id: 1,
    name: 'MDF Brut',
    category: 'MDF',
    featured: true,
    badge: 'Bestseller',
    image: imgMDFBrut,
    desc: 'Panneau MDF brut haute densité, surface lisse et homogène. Base idéale pour la peinture, le placage ou la stratification.',
    specs: [
      { label: 'Épaisseur', value: '8 / 12 / 16 / 18 / 22 mm' },
      { label: 'Format',    value: '2440 × 1220 mm' },
      { label: 'Densité',   value: '700 – 800 kg/m³' },
      { label: 'Norme',     value: 'E1 / CARB P2' },
    ],
    tags: ['Intérieur', 'Peinture', 'Placage'],
  },
  {
    id: 2,
    name: 'MDF Hydrofuge HDF',
    category: 'MDF',
    featured: false,
    badge: 'Résistant',
    image: imgHydrofuge,
    desc: 'Panneau MDF traité hydrofuge (vert), résistant à l\'humidité. Idéal pour les pièces humides, salles de bain et cuisines.',
    specs: [
      { label: 'Épaisseur', value: '12 / 16 / 18 mm' },
      { label: 'Format',    value: '2440 × 1220 mm' },
      { label: 'Traitement', value: 'Hydrofuge intégral' },
      { label: 'Norme',     value: 'E1 / H3' },
    ],
    tags: ['Humidité', 'Cuisine', 'Salle de bain'],
  },
  {
    id: 3,
    name: 'MDF Haute Brillance',
    category: 'MDF',
    featured: false,
    badge: 'Premium',
    image: imgHighGloss,
    desc: 'Surface ultra-brillante laquée en usine. Effet miroir haute résistance aux rayures, parfait pour les façades de cuisine et dressing modernes.',
    specs: [
      { label: 'Épaisseur', value: '18 mm' },
      { label: 'Format',    value: '2800 × 1220 mm' },
      { label: 'Finition',  value: 'Laqué brillant UV' },
      { label: 'Couleurs',  value: 'Blanc, Noir, Gris, Bleu…' },
    ],
    tags: ['Façades', 'Cuisine', 'Dressing'],
  },
  {
    id: 4,
    name: 'Panneau HPL Compacto',
    category: 'HPL',
    featured: true,
    badge: 'Haute performance',
    image: imgCompacto,
    desc: 'Stratifié HPL compact haute pression, extrêmement résistant aux chocs, à l\'humidité et aux agents chimiques. Idéal pour les espaces collectifs.',
    specs: [
      { label: 'Épaisseur', value: '6 / 8 / 10 / 12 mm' },
      { label: 'Format',    value: '3050 × 1300 mm' },
      { label: 'Résistance', value: 'Chocs · Eau · UV' },
      { label: 'Usage',     value: 'Intérieur / Extérieur' },
    ],
    tags: ['Collectif', 'Extérieur', 'Résistant'],
  },
  {
    id: 5,
    name: 'Stratidécor',
    category: 'Stratifié',
    featured: false,
    badge: null,
    image: imgStratidecor,
    desc: 'Panneau décoratif stratifié avec décor bois ou pierre appliqué. Large gamme de décors pour l\'agencement intérieur haut de gamme.',
    specs: [
      { label: 'Épaisseur', value: '18 / 22 mm' },
      { label: 'Format',    value: '2800 × 2070 mm' },
      { label: 'Décors',    value: '+200 références' },
      { label: 'Finition',  value: 'Mat / Satiné / Brossé' },
    ],
    tags: ['Décoration', 'Agencement', 'Haut de gamme'],
  },
  {
    id: 6,
    name: 'Bois Dur — Stock entrepôt',
    category: 'Bois',
    featured: false,
    badge: 'En stock',
    image: imgBoisDur,
    desc: 'Large gamme de bois durs disponibles en stock : chêne, hêtre, frêne, noyer. Qualité ébénisterie pour meubles et agencements nobles.',
    specs: [
      { label: 'Essences',  value: 'Chêne · Hêtre · Frêne · Noyer' },
      { label: 'Sections',  value: 'Sur mesure' },
      { label: 'Séchage',   value: 'KD 8–12%' },
      { label: 'Qualité',   value: 'A / A-B' },
    ],
    tags: ['Massif', 'Ébénisterie', 'Noble'],
  },
]

const countByCategory = (cat) => {
  if (cat === 'Tous') return products.length
  return products.filter(p => p.category === cat).length
}

const filteredProducts = computed(() => {
  if (activeCategory.value === 'Tous') return products
  return products.filter(p => p.category === activeCategory.value)
})
</script>

<style scoped>
.products-page {
  background: var(--cream);
  min-height: 100vh;
}

/* ── PAGE HERO ── */
.page-hero {
  position: relative;
  height: 420px;
  display: flex;
  align-items: center;
  overflow: hidden;
}

.page-hero__bg {
  position: absolute;
  inset: 0;
}

.page-hero__img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center 40%;
  display: block;
}

.page-hero__overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(
    90deg,
    rgba(17, 29, 17, 0.92) 0%,
    rgba(17, 29, 17, 0.70) 50%,
    rgba(17, 29, 17, 0.40) 100%
  );
}

.page-hero__content {
  position: relative;
  z-index: 2;
  padding: 0 60px;
  margin-top: 40px;
}

.page-hero__eyebrow {
  display: flex;
  align-items: center;
  gap: 14px;
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 2.5px;
  text-transform: uppercase;
  color: var(--wood);
  margin-bottom: 20px;
}

.page-hero__eyebrow-line {
  display: block;
  width: 32px; height: 1px;
  background: var(--wood);
}

.page-hero__title {
  font-family: var(--font-display);
  font-size: clamp(48px, 6vw, 80px);
  font-weight: 300;
  color: var(--cream);
  line-height: 1.05;
  margin-bottom: 16px;
}

.page-hero__title em { font-style: italic; color: var(--wood); }

.page-hero__sub {
  font-size: 15px;
  font-weight: 300;
  color: rgba(245, 240, 232, 0.65);
  max-width: 480px;
  line-height: 1.7;
}

.page-hero__breadcrumb {
  position: absolute;
  bottom: 24px;
  left: 60px;
  z-index: 2;
  display: flex;
  align-items: center;
  gap: 10px;
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
}

.page-hero__breadcrumb span {
  color: rgba(245, 240, 232, 0.45);
  cursor: pointer;
  transition: color 0.2s;
}

.page-hero__breadcrumb span:hover { color: var(--wood); }
.page-hero__breadcrumb .current { color: var(--wood); cursor: default; }
.page-hero__breadcrumb .sep { color: rgba(245, 240, 232, 0.25); cursor: default; }

/* ── FILTER BAR ── */
.filter-bar {
  position: sticky;
  top: 64px;
  z-index: 100;
  background: var(--white);
  border-bottom: 1px solid rgba(45, 74, 45, 0.1);
  box-shadow: 0 2px 16px rgba(45, 74, 45, 0.06);
}

.filter-bar__inner {
  display: flex;
  align-items: center;
  gap: 4px;
  padding: 0 60px;
  overflow-x: auto;
}

.filter-bar__btn {
  display: flex;
  align-items: center;
  gap: 8px;
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--mist);
  background: transparent;
  padding: 18px 20px;
  border: none;
  border-bottom: 2px solid transparent;
  cursor: pointer;
  white-space: nowrap;
  transition: color 0.25s, border-color 0.25s;
}

.filter-bar__btn:hover { color: var(--forest); }

.filter-bar__btn.active {
  color: var(--forest);
  border-bottom-color: var(--wood);
}

.filter-bar__count {
  background: rgba(45, 74, 45, 0.08);
  color: var(--mist);
  font-size: 9px;
  padding: 2px 7px;
  border-radius: 10px;
  transition: background 0.25s, color 0.25s;
}

.filter-bar__btn.active .filter-bar__count {
  background: var(--wood);
  color: var(--forest-deep);
}

/* ── CATALOG ── */
.catalog {
  padding: 64px 0 100px;
}

.catalog__inner {
  max-width: 1360px;
  margin: 0 auto;
  padding: 0 60px;
}

.catalog__meta {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 36px;
}

.catalog__count {
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 1.5px;
  color: var(--mist);
  text-transform: uppercase;
}

.catalog__count span {
  color: var(--forest);
  font-size: 14px;
}

/* Grid */
.catalog__grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
}

/* Card */
.catalog__card {
  background: var(--white);
  border-radius: 4px;
  overflow: hidden;
  border: 1px solid rgba(45, 74, 45, 0.07);
  transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s ease;
  animation: fadeUp 0.5s ease both;
}

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}

.catalog__card:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 60px rgba(45, 74, 45, 0.13);
}

.catalog__card.featured {
  grid-column: span 1;
  border-color: rgba(201, 168, 124, 0.25);
}

/* Image */
.catalog__card-img-wrap {
  position: relative;
  height: 260px;
  overflow: hidden;
}

.catalog__card-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.5s ease;
}

.catalog__card:hover .catalog__card-img {
  transform: scale(1.05);
}

.catalog__card-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, transparent 40%, rgba(17, 29, 17, 0.5) 100%);
  transition: opacity 0.3s;
}

/* Badge */
.catalog__card-badge {
  position: absolute;
  top: 16px;
  left: 16px;
  font-family: var(--font-mono);
  font-size: 9px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  background: var(--wood);
  color: var(--forest-deep);
  padding: 5px 12px;
  border-radius: 2px;
  font-weight: 500;
}

/* Hover specs overlay */
.catalog__card-specs {
  position: absolute;
  inset: 0;
  background: rgba(17, 29, 17, 0.88);
  backdrop-filter: blur(4px);
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 28px;
  gap: 12px;
  opacity: 0;
  transform: translateY(8px);
  transition: opacity 0.3s ease, transform 0.3s ease;
}

.catalog__card:hover .catalog__card-specs {
  opacity: 1;
  transform: translateY(0);
}

.spec-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-bottom: 10px;
  border-bottom: 1px solid rgba(201, 168, 124, 0.12);
}

.spec-row:last-of-type { border-bottom: none; }

.spec-label {
  font-family: var(--font-mono);
  font-size: 9px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: rgba(245, 240, 232, 0.5);
}

.spec-value {
  font-family: var(--font-mono);
  font-size: 11px;
  color: var(--wood-light);
  text-align: right;
  max-width: 55%;
}

.catalog__card-devis {
  margin-top: 8px;
  width: 100%;
  background: var(--wood);
  color: var(--forest-deep);
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  padding: 12px;
  border-radius: 2px;
  cursor: pointer;
  transition: background 0.25s;
  border: none;
}

.catalog__card-devis:hover { background: var(--wood-light); }

/* Info */
.catalog__card-info {
  padding: 24px;
}

.catalog__card-cat {
  font-family: var(--font-mono);
  font-size: 9px;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--wood);
  display: block;
  margin-bottom: 8px;
}

.catalog__card-name {
  font-family: var(--font-display);
  font-size: 22px;
  font-weight: 400;
  color: var(--forest);
  margin-bottom: 10px;
  line-height: 1.2;
}

.catalog__card-desc {
  font-size: 13px;
  font-weight: 300;
  line-height: 1.75;
  color: var(--mist);
  margin-bottom: 16px;
}

.catalog__card-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
}

.catalog__card-tags {
  display: flex;
  gap: 6px;
  flex-wrap: wrap;
}

.tag {
  font-family: var(--font-mono);
  font-size: 9px;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: var(--forest);
  background: rgba(45, 74, 45, 0.07);
  border: 1px solid rgba(45, 74, 45, 0.12);
  padding: 4px 10px;
  border-radius: 2px;
}

.catalog__card-btn {
  display: flex;
  align-items: center;
  gap: 6px;
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  background: var(--forest);
  color: var(--cream);
  padding: 9px 16px;
  border-radius: 2px;
  border: none;
  cursor: pointer;
  white-space: nowrap;
  transition: background 0.25s, transform 0.2s;
  flex-shrink: 0;
}

.catalog__card-btn:hover {
  background: var(--forest-dark);
  transform: translateY(-1px);
}

/* Empty */
.catalog__empty {
  text-align: center;
  padding: 80px;
  font-family: var(--font-mono);
  font-size: 13px;
  color: var(--mist);
  letter-spacing: 1px;
}

/* ── CTA BAND ── */
.cta-band {
  background: var(--forest);
  padding: 56px 60px;
}

.cta-band__inner {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 40px;
  flex-wrap: wrap;
}

.cta-band__title {
  font-family: var(--font-display);
  font-size: clamp(24px, 3vw, 36px);
  font-weight: 300;
  color: var(--cream);
  margin-bottom: 8px;
}

.cta-band__sub {
  font-size: 14px;
  font-weight: 300;
  color: rgba(245, 240, 232, 0.55);
}

.cta-band__btn {
  background: var(--wood);
  color: var(--forest-deep);
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  padding: 15px 32px;
  border-radius: 2px;
  border: none;
  cursor: pointer;
  white-space: nowrap;
  transition: background 0.25s, transform 0.2s;
}

.cta-band__btn:hover {
  background: var(--wood-light);
  transform: translateY(-2px);
}

/* ── RESPONSIVE ── */
@media (max-width: 1100px) {
  .catalog__grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 700px) {
  .page-hero { height: 320px; }
  .page-hero__content { padding: 0 24px; }
  .page-hero__breadcrumb { left: 24px; }
  .filter-bar__inner { padding: 0 24px; }
  .catalog__inner { padding: 0 24px; }
  .catalog__grid { grid-template-columns: 1fr; }
  .cta-band { padding: 48px 24px; }
  .cta-band__inner { flex-direction: column; align-items: flex-start; }
}
</style>
