<template>
  <section id="contact" class="contact" ref="sectionRef">

    <div class="contact__inner">

      <!-- Left: Info -->
      <div class="contact__info" :class="{ visible: inView }">
        <p class="label">Contact</p>
        <h2 class="section-title">
          Parlons de<br>votre <em>projet</em>
        </h2>
        <p class="contact__desc">
          Notre équipe commerciale répond à toutes vos demandes de devis,
          questions techniques et informations produits dans les 24 heures.
        </p>

        <div class="contact__details">
          <div v-for="detail in details" :key="detail.label" class="contact__detail">
            <span class="contact__detail-icon">{{ detail.icon }}</span>
            <div>
              <p class="contact__detail-label">{{ detail.label }}</p>
              <p class="contact__detail-value">{{ detail.value }}</p>
            </div>
          </div>
        </div>

        <!-- Decorative panel strip -->
        <div class="contact__panel-strip">
          <div v-for="(c, i) in panelColors" :key="i" class="contact__panel-piece" :style="{ background: c }">
            <div class="contact__panel-grain"></div>
          </div>
        </div>
      </div>

      <!-- Right: Form -->
      <div class="contact__form-wrap" :class="{ visible: inView }">
        <form class="contact__form" @submit.prevent="handleSubmit" novalidate>

          <div class="contact__form-row">
            <div class="contact__field" :class="{ focused: focused === 'name', error: errors.name }">
              <label>Nom complet *</label>
              <input
                type="text"
                v-model="form.name"
                placeholder="Ahmed Benali"
                @focus="focused = 'name'"
                @blur="focused = null; validate('name')"
              />
              <span v-if="errors.name" class="contact__error">{{ errors.name }}</span>
            </div>
            <div class="contact__field" :class="{ focused: focused === 'company', error: errors.company }">
              <label>Entreprise *</label>
              <input
                type="text"
                v-model="form.company"
                placeholder="Menuiserie Al Hadafa"
                @focus="focused = 'company'"
                @blur="focused = null; validate('company')"
              />
              <span v-if="errors.company" class="contact__error">{{ errors.company }}</span>
            </div>
          </div>

          <div class="contact__form-row">
            <div class="contact__field" :class="{ focused: focused === 'email', error: errors.email }">
              <label>Email professionnel *</label>
              <input
                type="email"
                v-model="form.email"
                placeholder="contact@votreentreprise.ma"
                @focus="focused = 'email'"
                @blur="focused = null; validate('email')"
              />
              <span v-if="errors.email" class="contact__error">{{ errors.email }}</span>
            </div>
            <div class="contact__field" :class="{ focused: focused === 'phone' }">
              <label>Téléphone</label>
              <input
                type="tel"
                v-model="form.phone"
                placeholder="+212 6XX XXX XXX"
                @focus="focused = 'phone'"
                @blur="focused = null"
              />
            </div>
          </div>

          <div class="contact__field" :class="{ focused: focused === 'product' }">
            <label>Produit(s) d'intérêt</label>
            <div class="contact__checkboxes">
              <label v-for="prod in productOptions" :key="prod" class="contact__checkbox">
                <input type="checkbox" :value="prod" v-model="form.products"/>
                <span class="contact__checkbox-mark"></span>
                {{ prod }}
              </label>
            </div>
          </div>

          <div class="contact__field" :class="{ focused: focused === 'message', error: errors.message }">
            <label>Votre demande *</label>
            <textarea
              v-model="form.message"
              placeholder="Décrivez votre projet, les quantités souhaitées, les délais..."
              rows="5"
              @focus="focused = 'message'"
              @blur="focused = null; validate('message')"
            ></textarea>
            <span v-if="errors.message" class="contact__error">{{ errors.message }}</span>
          </div>

          <button type="submit" class="contact__submit" :class="{ loading: submitting, success: submitted }">
            <span v-if="!submitting && !submitted">
              Envoyer la demande
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                <path d="M2 7h10M7 2l5 5-5 5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
            <span v-else-if="submitting">Envoi en cours...</span>
            <span v-else>✓ Message envoyé !</span>
          </button>

          <p class="contact__note">Réponse garantie sous 24 heures ouvrables.</p>
        </form>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref, reactive, onMounted, onUnmounted } from 'vue'

const sectionRef = ref(null)
const inView     = ref(false)
const focused    = ref(null)
const submitting = ref(false)
const submitted  = ref(false)

const form = reactive({
  name: '', company: '', email: '', phone: '',
  products: [], message: ''
})

const errors = reactive({ name: '', company: '', email: '', message: '' })

const details = [
  { icon: '▸', label: 'Email',       value: 'contact@lamibois.ma' },
  { icon: '▸', label: 'Téléphone',   value: '+212 5XX XXX XXX' },
  { icon: '▸', label: 'Adresse',     value: 'Maroc' },
  { icon: '▸', label: 'Horaires',    value: 'Lun – Ven · 8h00 – 18h00' },
]

const panelColors = [
  'linear-gradient(180deg, #F5F0E8, #E8E0D0)',
  'linear-gradient(180deg, #C4975A, #A87840)',
  'linear-gradient(180deg, #3D2B1F, #2A1D14)',
  'linear-gradient(180deg, #E8E0D0, #D8D0C0)',
  'linear-gradient(180deg, #9A9590, #7A7570)',
  'linear-gradient(180deg, #D4B896, #C4A870)',
]

const productOptions = ['MDF Mélaminé', 'Contreplaqué', 'Bois Massif', 'MDF Brut', 'OSB']

const validate = (field) => {
  if (field === 'name')    errors.name    = form.name.trim()    ? '' : 'Champ requis'
  if (field === 'company') errors.company = form.company.trim() ? '' : 'Champ requis'
  if (field === 'email')   errors.email   = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email) ? '' : 'Email invalide'
  if (field === 'message') errors.message = form.message.trim() ? '' : 'Champ requis'
}

const handleSubmit = async () => {
  ['name', 'company', 'email', 'message'].forEach(validate)
  if (Object.values(errors).some(e => e)) return

  submitting.value = true
  await new Promise(r => setTimeout(r, 1600))
  submitting.value = false
  submitted.value = true
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
.contact {
  padding: 120px 60px;
  background: var(--cream);
}

.contact__inner {
  display: grid;
  grid-template-columns: 1fr 1.4fr;
  gap: 80px;
  max-width: 1200px;
  margin: 0 auto;
  align-items: start;
}

/* ── INFO ── */
.contact__info {
  opacity: 0;
  transform: translateX(-24px);
  transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}
.contact__info.visible { opacity: 1; transform: translateX(0); }

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
.label::before { content: ''; display: block; width: 24px; height: 1px; background: var(--wood); }

.section-title {
  font-family: var(--font-display);
  font-size: clamp(32px, 3.5vw, 48px);
  font-weight: 300;
  color: var(--forest);
  line-height: 1.15;
  margin-bottom: 20px;
}
.section-title em { font-style: italic; color: var(--wood); }

.contact__desc {
  font-size: 14px;
  font-weight: 300;
  line-height: 1.85;
  color: var(--mist);
  margin-bottom: 40px;
}

.contact__details {
  display: flex;
  flex-direction: column;
  gap: 20px;
  margin-bottom: 40px;
}

.contact__detail {
  display: flex;
  gap: 16px;
  align-items: flex-start;
}

.contact__detail-icon {
  color: var(--wood);
  font-size: 12px;
  margin-top: 2px;
  flex-shrink: 0;
}

.contact__detail-label {
  font-family: var(--font-mono);
  font-size: 9px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--mist);
  margin-bottom: 3px;
}

.contact__detail-value {
  font-size: 14px;
  font-weight: 400;
  color: var(--forest);
}

/* Panel strip decoration */
.contact__panel-strip {
  display: flex;
  height: 80px;
  border-radius: 3px;
  overflow: hidden;
  gap: 2px;
  box-shadow: 0 8px 32px rgba(45, 74, 45, 0.12);
}

.contact__panel-piece {
  flex: 1;
  position: relative;
  overflow: hidden;
}

.contact__panel-grain {
  position: absolute;
  inset: 0;
  background-image: repeating-linear-gradient(
    175deg, transparent 0px, transparent 4px,
    rgba(0,0,0,0.04) 4px, rgba(0,0,0,0.04) 5px
  );
}

/* ── FORM ── */
.contact__form-wrap {
  opacity: 0;
  transform: translateX(24px);
  transition: opacity 0.8s ease 0.2s, transform 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.2s;
}
.contact__form-wrap.visible { opacity: 1; transform: translateX(0); }

.contact__form {
  background: var(--white);
  padding: 48px;
  border-radius: 4px;
  border: 1px solid rgba(45, 74, 45, 0.08);
  box-shadow: 0 8px 48px rgba(45, 74, 45, 0.07);
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.contact__form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.contact__field {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.contact__field label {
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--mist);
  transition: color 0.25s;
}

.contact__field.focused label { color: var(--forest); }
.contact__field.error label   { color: #C0392B; }

.contact__field input,
.contact__field textarea {
  font-family: var(--font-body);
  font-size: 14px;
  font-weight: 300;
  color: var(--ink);
  background: var(--cream);
  border: 1px solid rgba(45, 74, 45, 0.15);
  border-radius: 2px;
  padding: 13px 16px;
  outline: none;
  transition: border-color 0.25s, background 0.25s;
  resize: none;
}

.contact__field input::placeholder,
.contact__field textarea::placeholder {
  color: rgba(122, 122, 114, 0.5);
}

.contact__field.focused input,
.contact__field.focused textarea {
  border-color: var(--forest);
  background: var(--white);
}

.contact__field.error input,
.contact__field.error textarea {
  border-color: #C0392B;
}

.contact__error {
  font-family: var(--font-mono);
  font-size: 10px;
  color: #C0392B;
  letter-spacing: 0.5px;
}

/* Checkboxes */
.contact__checkboxes {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  padding-top: 4px;
}

.contact__checkbox {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  font-weight: 300;
  color: var(--ink);
  cursor: pointer;
  padding: 8px 14px;
  border: 1px solid rgba(45, 74, 45, 0.15);
  border-radius: 2px;
  transition: border-color 0.25s, background 0.25s;
  user-select: none;
}

.contact__checkbox input { display: none; }

.contact__checkbox:has(input:checked) {
  border-color: var(--forest);
  background: rgba(45, 74, 45, 0.05);
  color: var(--forest);
}

.contact__checkbox-mark {
  width: 14px; height: 14px;
  border: 1px solid rgba(45, 74, 45, 0.3);
  border-radius: 1px;
  flex-shrink: 0;
  position: relative;
  transition: background 0.2s, border-color 0.2s;
}

.contact__checkbox:has(input:checked) .contact__checkbox-mark {
  background: var(--forest);
  border-color: var(--forest);
}

.contact__checkbox:has(input:checked) .contact__checkbox-mark::after {
  content: '✓';
  position: absolute;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  font-size: 9px;
  color: var(--cream);
  line-height: 1;
}

/* Submit */
.contact__submit {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  width: 100%;
  background: var(--forest);
  color: var(--cream);
  font-family: var(--font-mono);
  font-size: 12px;
  letter-spacing: 2px;
  text-transform: uppercase;
  padding: 17px 32px;
  border-radius: 2px;
  transition: background 0.25s, transform 0.2s, box-shadow 0.25s;
  margin-top: 8px;
}

.contact__submit:hover:not(.loading):not(.success) {
  background: var(--forest-dark);
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(45, 74, 45, 0.25);
}

.contact__submit.loading {
  background: var(--mist);
  cursor: wait;
}

.contact__submit.success {
  background: #2D6A2D;
}

.contact__note {
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 1px;
  color: var(--mist);
  text-align: center;
}

@media (max-width: 900px) {
  .contact { padding: 80px 24px; }
  .contact__inner { grid-template-columns: 1fr; gap: 48px; }
  .contact__form { padding: 32px 24px; }
  .contact__form-row { grid-template-columns: 1fr; }
}
</style>
