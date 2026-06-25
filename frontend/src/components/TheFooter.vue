<template>
  <footer class="footer">

    <!-- Top band -->
    <div class="footer__cta-band">
      <div class="footer__cta-content">
        <h2 class="footer__cta-title">
          Prêt à commencer<br>votre <em>prochain projet</em> ?
        </h2>
        <p class="footer__cta-sub">Contactez notre équipe pour un devis personnalisé.</p>
      </div>
      <div class="footer__cta-actions">
        <button class="footer__btn-primary" @click="$router.push('/contact')">Demander un devis →</button>
        <span class="footer__response-time">Réponse sous 24h</span>
      </div>
    </div>

    <!-- Panel color strip -->
    <div class="footer__panel-strip">
      <div v-for="(c, i) in panelColors" :key="i" class="footer__panel" :style="{ background: c }">
        <div class="footer__panel-lines"></div>
      </div>
    </div>

    <!-- Main footer -->
    <div class="footer__main">
      <div class="footer__brand">
        <div class="footer__logo">
          <div class="footer__logo-mark">
            <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" width="36" height="36">
              <circle cx="20" cy="20" r="18.5" stroke="#C9A87C" stroke-width="1.5"/>
              <text x="8" y="26" font-family="Cormorant Garamond, serif" font-size="16" font-weight="600" fill="#C9A87C">LB</text>
            </svg>
          </div>
          <span class="footer__logo-text">LAMIBOIS</span>
        </div>
        <p class="footer__tagline">
          Distributeur spécialisé en panneaux de bois<br>
          pour les professionnels du Maroc.
        </p>
        <div class="footer__certifications">
          <span class="footer__cert">E1</span>
          <span class="footer__cert">CARB P2</span>
          <span class="footer__cert">CE EN 636</span>
        </div>
      </div>

      <div class="footer__col">
        <p class="footer__col-title">Produits</p>
        <ul class="footer__links">
          <li>MDF Mélaminé</li>
          <li>Contreplaqué</li>
          <li>Bois Massif</li>
          <li>MDF Brut</li>
          <li>OSB</li>
          <li>Accessoires</li>
        </ul>
      </div>

      <div class="footer__col">
        <p class="footer__col-title">Entreprise</p>
        <ul class="footer__links">
          <li @click="scrollTo('apropos')">À propos</li>
          <li>Certifications</li>
          <li>Livraison</li>
          <li>Partenaires</li>
          <li @click="$router.push('/contact')">Contact</li>
        </ul>
      </div>

      <div class="footer__col">
        <p class="footer__col-title">Contact</p>
        <ul class="footer__contacts">
          <li>
            <span class="footer__contact-icon">◈</span>
            <span>contact@lamibois.ma</span>
          </li>
          <li>
            <span class="footer__contact-icon">◈</span>
            <span>+212 5XX XXX XXX</span>
          </li>
          <li>
            <span class="footer__contact-icon">◈</span>
            <span>Maroc</span>
          </li>
        </ul>
        <p class="footer__hours">Lun – Ven · 8h00 – 18h00</p>
      </div>
    </div>

    <!-- Bottom bar -->
    <div class="footer__bottom">
      <span class="footer__copy">© 2025 Lamibois · Tous droits réservés</span>
      <span class="footer__made">Fait avec soin au Maroc 🇲🇦</span>
    </div>

  </footer>
</template>

<script setup>
const scrollTo = (id) => document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' })

const panelColors = [
  '#F5F0E8', '#E8E0D0', '#C4975A', '#A87840',
  '#3D2B1F', '#2A1D14', '#D4B896', '#C4A870',
  '#9A9590', '#7A7570', '#F0ECE4', '#D8D0C0',
]
</script>

<style scoped>
.footer {
  background: var(--forest-deep);
}

/* CTA band */
.footer__cta-band {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 64px 60px;
  border-bottom: 1px solid rgba(201, 168, 124, 0.12);
  gap: 40px;
  flex-wrap: wrap;
}

.footer__cta-title {
  font-family: var(--font-display);
  font-size: clamp(28px, 3.5vw, 44px);
  font-weight: 300;
  color: var(--cream);
  line-height: 1.2;
  margin-bottom: 10px;
}

.footer__cta-title em { font-style: italic; color: var(--wood); }

.footer__cta-sub {
  font-size: 14px;
  font-weight: 300;
  color: rgba(245, 240, 232, 0.5);
}

.footer__cta-actions {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 10px;
}

.footer__btn-primary {
  background: var(--wood);
  color: var(--forest-deep);
  font-family: var(--font-mono);
  font-size: 11px;
  font-weight: 500;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  padding: 15px 32px;
  border-radius: 2px;
  white-space: nowrap;
  transition: background 0.25s, transform 0.2s;
}

.footer__btn-primary:hover {
  background: var(--wood-light);
  transform: translateY(-2px);
}

.footer__response-time {
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 1.5px;
  color: rgba(245, 240, 232, 0.35);
}

/* Panel strip */
.footer__panel-strip {
  display: flex;
  height: 6px;
}

.footer__panel { flex: 1; position: relative; }

.footer__panel-lines {
  position: absolute;
  inset: 0;
  background-image: repeating-linear-gradient(
    90deg, transparent 0px, transparent 6px,
    rgba(0,0,0,0.15) 6px, rgba(0,0,0,0.15) 7px
  );
}

/* Main */
.footer__main {
  display: grid;
  grid-template-columns: 2fr 1fr 1fr 1fr;
  gap: 48px;
  padding: 64px 60px;
  border-bottom: 1px solid rgba(245, 240, 232, 0.06);
}

.footer__logo {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 20px;
}

.footer__logo-text {
  font-family: var(--font-body);
  font-size: 12px;
  font-weight: 500;
  letter-spacing: 4px;
  color: var(--cream);
}

.footer__tagline {
  font-size: 13px;
  font-weight: 300;
  line-height: 1.8;
  color: rgba(245, 240, 232, 0.45);
  margin-bottom: 24px;
}

.footer__certifications {
  display: flex;
  gap: 8px;
}

.footer__cert {
  font-family: var(--font-mono);
  font-size: 9px;
  letter-spacing: 1px;
  color: var(--wood);
  border: 1px solid rgba(201, 168, 124, 0.3);
  padding: 4px 10px;
  border-radius: 1px;
}

.footer__col-title {
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 2.5px;
  text-transform: uppercase;
  color: var(--wood);
  margin-bottom: 20px;
}

.footer__links {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.footer__links li {
  font-size: 13px;
  font-weight: 300;
  color: rgba(245, 240, 232, 0.5);
  cursor: pointer;
  transition: color 0.2s;
}

.footer__links li:hover { color: var(--wood); }

.footer__contacts {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 14px;
}

.footer__contacts li {
  display: flex;
  gap: 12px;
  align-items: flex-start;
  font-size: 13px;
  font-weight: 300;
  color: rgba(245, 240, 232, 0.5);
}

.footer__contact-icon { color: var(--wood); font-size: 10px; margin-top: 3px; flex-shrink: 0; }

.footer__hours {
  margin-top: 20px;
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 1px;
  color: rgba(245, 240, 232, 0.3);
}

/* Bottom */
.footer__bottom {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 24px 60px;
}

.footer__copy, .footer__made {
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: rgba(245, 240, 232, 0.25);
}

@media (max-width: 900px) {
  .footer__cta-band { padding: 48px 24px; flex-direction: column; align-items: flex-start; }
  .footer__cta-actions { align-items: flex-start; }
  .footer__main { grid-template-columns: 1fr 1fr; padding: 48px 24px; }
  .footer__brand { grid-column: span 2; }
  .footer__bottom { padding: 20px 24px; flex-direction: column; gap: 8px; text-align: center; }
}
</style>
