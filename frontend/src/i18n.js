import { createI18n } from 'vue-i18n'

import fr from './locales/fr.json'
import en from './locales/en.json'
import ar from './locales/ar.json'
import es from './locales/es.json'
export default createI18n({
  legacy: false,
  locale: 'fr',
  fallbackLocale: 'fr',
  messages: {
    fr,
    en,
    ar,
    es
  },
})