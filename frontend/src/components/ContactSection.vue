<template>
  <section id="contact" class="contact" ref="sectionRef">

    <div class="contact__inner">

      <!-- Left: Info -->
      <div class="contact__info" :class="{ visible: inView }">
        <p class="label">{{ t('contact.label') }}</p>
        <h2 class="section-title">
          {{ t('contact.title_line1') }}<br>{{ t('contact.title_line2') }} <em>{{ t('contact.title_em') }}</em>
        </h2>
        <p class="contact__desc">{{ t('contact.desc') }}</p>

        <div class="contact__details">
          <div v-for="detail in details" :key="detail.key" class="contact__detail">
            <span class="contact__detail-icon" v-html="detail.icon"></span>
            <div>
              <p class="contact__detail-label">{{ t(`contact.details.${detail.key}.label`) }}</p>
              <a
                v-if="detail.href"
                :href="detail.href"
                target="_blank"
                rel="noopener noreferrer"
                class="contact__detail-link"
              >
                {{ detail.key === 'hours' ? t(`contact.details.${detail.key}.value`) : detail.value }}
              </a>
              <p v-else class="contact__detail-value">{{ t(`contact.details.${detail.key}.value`) }}</p>
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
              <label>{{ t('contact.form.name_label') }}</label>
              <input
                type="text"
                v-model="form.name"
                :placeholder="t('contact.form.name_placeholder')"
                @focus="focused = 'name'"
                @blur="focused = null; validate('name')"
              />
              <span v-if="errors.name" class="contact__error">{{ errors.name }}</span>
            </div>
            <div class="contact__field" :class="{ focused: focused === 'company', error: errors.company }">
              <label>{{ t('contact.form.company_label') }}</label>
              <input
                type="text"
                v-model="form.company"
                :placeholder="t('contact.form.company_placeholder')"
                @focus="focused = 'company'"
                @blur="focused = null; validate('company')"
              />
              <span v-if="errors.company" class="contact__error">{{ errors.company }}</span>
            </div>
          </div>

          <div class="contact__form-row">
            <div class="contact__field" :class="{ focused: focused === 'email', error: errors.email }">
              <label>{{ t('contact.form.email_label') }}</label>
              <input
                type="email"
                v-model="form.email"
                placeholder="contact@yourcompany.ma"
                @focus="focused = 'email'"
                @blur="focused = null; validate('email')"
              />
              <span v-if="errors.email" class="contact__error">{{ errors.email }}</span>
            </div>
            <div class="contact__field" :class="{ focused: focused === 'phone' }">
              <label>{{ t('contact.form.phone_label') }}</label>
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
            <label>{{ t('contact.form.products_label') }}</label>
            <div class="contact__checkboxes">
              <label v-for="prod in productOptions" :key="prod.key" class="contact__checkbox">
                <input type="checkbox" :value="prod.key" v-model="form.products"/>
                <span class="contact__checkbox-mark"></span>
                {{ t(`contact.form.products.${prod.key}`) }}
              </label>
            </div>
          </div>

          <div class="contact__field" :class="{ focused: focused === 'message', error: errors.message }">
            <label>{{ t('contact.form.message_label') }}</label>
            <textarea
              v-model="form.message"
              :placeholder="t('contact.form.message_placeholder')"
              rows="5"
              @focus="focused = 'message'"
              @blur="focused = null; validate('message')"
            ></textarea>
            <span v-if="errors.message" class="contact__error">{{ errors.message }}</span>
          </div>

          <button type="submit" class="contact__submit" :class="{ loading: submitting, success: submitted }">
            <span v-if="!submitting && !submitted">
              {{ t('contact.form.submit') }}
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                <path d="M2 7h10M7 2l5 5-5 5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
            <span v-else-if="submitting">{{ t('contact.form.submitting') }}</span>
            <span v-else>✓ {{ t('contact.form.submitted') }}</span>
          </button>

          <p class="contact__note">{{ t('contact.form.note') }}</p>
        </form>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref, reactive, onMounted, onUnmounted } from 'vue'
import { useI18n } from 'vue-i18n'
import axios from 'axios'

const { t } = useI18n()

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

// Contact values (email, phone, address, links) stay as raw data — only labels are translated
const details = [
  {
    key: 'email',
    icon: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 7 10-7"/></svg>`,
    value: 'Lamibois1@gmail.com',
    href: 'mailto:Lamibois1@gmail.com'
  },
  {
    key: 'phone',
    icon: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.14 12 19.79 19.79 0 0 1 1.08 3.18 2 2 0 0 1 3.05 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.09 8.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>`,
    value: '+212661135570',
    href: 'tel:+212661135570'
  },
  {
    key: 'whatsapp',
    icon: `<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>`,
    value: 'Écrire sur WhatsApp',
    href: 'https://wa.me/212661135570?text=Bonjour%2C%20je%20souhaite%20obtenir%20des%20informations%20sur%20vos%20produits.'
  },
  {
    key: 'address',
    icon: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>`,
    value: 'Maroc, Tanger',
    href: 'https://maps.app.goo.gl/FjL9WNNhozQTqwrX6?g_st=iw'
  },
  { key: 'hours', icon: '▸' },
]

const panelColors = [
  'linear-gradient(180deg, #F5F0E8, #E8E0D0)',
  'linear-gradient(180deg, #C4975A, #A87840)',
  'linear-gradient(180deg, #3D2B1F, #2A1D14)',
  'linear-gradient(180deg, #E8E0D0, #D8D0C0)',
  'linear-gradient(180deg, #9A9590, #7A7570)',
  'linear-gradient(180deg, #D4B896, #C4A870)',
]

// Stable keys sent to the backend regardless of active language
const productOptions = [
  { key: 'mdf_melamine' },
  { key: 'plywood' },
  { key: 'solid_wood' },
  { key: 'raw_mdf' },
  { key: 'osb' },
]

const validate = (field) => {
  if (field === 'name')    errors.name    = form.name.trim()    ? '' : t('contact.form.errors.required')
  if (field === 'company') errors.company = form.company.trim() ? '' : t('contact.form.errors.required')
  if (field === 'email')   errors.email   = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email) ? '' : t('contact.form.errors.invalid_email')
  if (field === 'message') errors.message = form.message.trim() ? '' : t('contact.form.errors.required')
}

const handleSubmit = async () => {
  ['name', 'company', 'email', 'message'].forEach(validate)
  if (Object.values(errors).some(e => e)) return

  submitting.value = true

  try {
    const response = await axios.post('http://127.0.0.1:8001/api/contact', {
      name: form.name,
      name_company: form.company,
      email: form.email,
      phone: form.phone,
      project_type: form.products.join(', '),
      message: form.message
    })

    console.log('Message sent:', response.data)
    submitted.value = true
  } catch (error) {
    console.error('Failed to send message:', error)
    errors.message = t('contact.form.errors.send_failed')
  } finally {
    submitting.value = false
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
/* unchanged — keep exactly as before */
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
.contact__detail-icon {
  color: var(--wood);
  flex-shrink: 0;
  margin-top: 2px;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  background: rgba(201, 168, 124, 0.1);
  border-radius: 50%;
  padding: 7px;
}
.contact__detail-link {
  font-size: 14px;
  font-weight: 400;
  color: var(--forest);
  text-decoration: none;
  border-bottom: 1px solid rgba(45, 74, 45, 0.2);
  transition: color 0.2s, border-color 0.2s;
  display: inline-block;
}
.contact__detail-link:hover {
  color: var(--wood);
  border-bottom-color: var(--wood);
}
</style>