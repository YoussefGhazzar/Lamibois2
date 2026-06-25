<template>
  <div class="login-page">
    <div class="login__visual">
      <div class="login__visual-panels">
        <div class="login__panel login__panel--1"></div>
        <div class="login__panel login__panel--2"></div>
        <div class="login__panel login__panel--3"></div>
        <div class="login__panel login__panel--4"></div>
        <div class="login__panel login__panel--5"></div>
      </div>
      <div class="login__visual-overlay"></div>
      <div class="login__visual-content">
        <div class="login__logo">
          <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" width="48" height="48">
            <circle cx="20" cy="20" r="18.5" stroke="#C9A87C" stroke-width="1.5"/>
            <text x="8" y="26" font-family="Cormorant Garamond, serif" font-size="16" font-weight="600" fill="#C9A87C">LB</text>
          </svg>
          <span>LAMIBOIS</span>
        </div>
        <h2 class="login__visual-title">Espace<br><em>professionnel</em></h2>
        <p class="login__visual-sub">Acces reserve aux equipes Lamibois.</p>
      </div>
    </div>
    <div class="login__form-wrap">
      <div class="login__form-inner">
        <p class="login__eyebrow">Connexion</p>
        <h1 class="login__title">Bienvenue</h1>
        <p class="login__sub">Connectez-vous a votre espace.</p>
        <form class="login__form" @submit.prevent="handleLogin" novalidate>
          <div class="login__field" :class="{ focused: focused === 'email', error: errors.email }">
            <label>Adresse email</label>
            <input
              type="email"
              v-model="form.email"
              placeholder="votre@email.com"
              @focus="focused = 'email'"
              @blur="focused = null"
            />
            <span v-if="errors.email" class="login__error">{{ errors.email }}</span>
          </div>
          <div class="login__field" :class="{ focused: focused === 'password', error: errors.password }">
            <label>Mot de passe</label>
            <div class="login__input-wrap">
              <input
                :type="showPassword ? 'text' : 'password'"
                v-model="form.password"
                placeholder="••••••••"
                @focus="focused = 'password'"
                @blur="focused = null"
              />
              <button type="button" class="login__toggle-pw" @click="showPassword = !showPassword">
                {{ showPassword ? 'Cacher' : 'Voir' }}
              </button>
            </div>
            <span v-if="errors.password" class="login__error">{{ errors.password }}</span>
          </div>
          <button type="submit" class="login__submit" :class="{ loading: loading }">
            <span v-if="!loading">Se connecter</span>
            <span v-else>Connexion...</span>
          </button>
          <p v-if="loginError" class="login__global-error">{{ loginError }}</p>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'

const focused      = ref(null)
const showPassword = ref(false)
const loading      = ref(false)
const loginError   = ref('')

const form   = reactive({ email: '', password: '' })
const errors = reactive({ email: '', password: '' })

const handleLogin = async () => {
  errors.email    = form.email    ? '' : 'Email requis'
  errors.password = form.password ? '' : 'Mot de passe requis'
  if (errors.email || errors.password) return
  loading.value = true
  await new Promise(r => setTimeout(r, 1500))
  loading.value = false
  loginError.value = 'Email ou mot de passe incorrect.'
}
</script>

<style scoped>
.login-page {
  display: grid;
  grid-template-columns: 1fr 1fr;
  min-height: 100vh;
  background: var(--cream);
}
.login__visual {
  position: relative;
  overflow: hidden;
}
.login__visual-panels {
  position: absolute;
  inset: 0;
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 2px;
}
.login__panel--1 { background: linear-gradient(180deg, #2A1D14, #3D2B1F); }
.login__panel--2 { background: linear-gradient(180deg, #C4975A, #A87840); }
.login__panel--3 { background: linear-gradient(180deg, #F0ECE4, #E0D8C8); }
.login__panel--4 { background: linear-gradient(180deg, #3D2B1F, #5C3D25); }
.login__panel--5 { background: linear-gradient(180deg, #C4975A, #A87840); }
.login__visual-overlay {
  position: absolute;
  inset: 0;
  background: rgba(17, 29, 17, 0.82);
}
.login__visual-content {
  position: relative;
  z-index: 1;
  padding: 60px;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
.login__logo {
  display: flex;
  align-items: center;
  gap: 14px;
  margin-bottom: 48px;
}
.login__logo span {
  font-family: var(--font-body);
  font-size: 13px;
  font-weight: 500;
  letter-spacing: 4px;
  color: var(--cream);
}
.login__visual-title {
  font-family: var(--font-display);
  font-size: 56px;
  font-weight: 300;
  color: var(--cream);
  line-height: 1.1;
  margin-bottom: 20px;
}
.login__visual-title em { font-style: italic; color: var(--wood); }
.login__visual-sub {
  font-size: 14px;
  font-weight: 300;
  color: rgba(245, 240, 232, 0.5);
}
.login__form-wrap {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 60px 40px;
}
.login__form-inner { width: 100%; max-width: 400px; }
.login__eyebrow {
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
.login__eyebrow::before {
  content: '';
  display: block;
  width: 24px; height: 1px;
  background: var(--wood);
}
.login__title {
  font-family: var(--font-display);
  font-size: 44px;
  font-weight: 300;
  color: var(--forest);
  margin-bottom: 8px;
}
.login__sub {
  font-size: 14px;
  font-weight: 300;
  color: var(--mist);
  margin-bottom: 44px;
}
.login__form { display: flex; flex-direction: column; gap: 24px; }
.login__field { display: flex; flex-direction: column; gap: 8px; }
.login__field label {
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--mist);
  transition: color 0.25s;
}
.login__field.focused label { color: var(--forest); }
.login__field.error label   { color: #C0392B; }
.login__field input {
  width: 100%;
  font-family: var(--font-body);
  font-size: 14px;
  font-weight: 300;
  color: var(--ink);
  background: var(--linen);
  border: 1px solid rgba(45, 74, 45, 0.15);
  border-radius: 2px;
  padding: 14px 16px;
  outline: none;
  transition: border-color 0.25s, background 0.25s;
}
.login__field.focused input { border-color: var(--forest); background: var(--white); }
.login__field.error input   { border-color: #C0392B; }
.login__input-wrap { position: relative; }
.login__input-wrap input { padding-right: 70px; }
.login__toggle-pw {
  position: absolute;
  right: 14px;
  top: 50%;
  transform: translateY(-50%);
  font-family: var(--font-mono);
  font-size: 9px;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: var(--mist);
  background: none;
  border: none;
  cursor: pointer;
  transition: color 0.2s;
}
.login__toggle-pw:hover { color: var(--forest); }
.login__error { font-family: var(--font-mono); font-size: 10px; color: #C0392B; }
.login__submit {
  width: 100%;
  background: var(--forest);
  color: var(--cream);
  font-family: var(--font-mono);
  font-size: 12px;
  letter-spacing: 2px;
  text-transform: uppercase;
  padding: 16px;
  border-radius: 2px;
  border: none;
  cursor: pointer;
  margin-top: 8px;
  transition: background 0.25s, transform 0.2s;
}
.login__submit:hover { background: var(--forest-dark); transform: translateY(-2px); }
.login__submit.loading { background: var(--mist); cursor: wait; }
.login__global-error {
  font-family: var(--font-mono);
  font-size: 11px;
  color: #C0392B;
  text-align: center;
  padding: 12px;
  background: rgba(192, 57, 43, 0.06);
  border: 1px solid rgba(192, 57, 43, 0.2);
  border-radius: 2px;
}
@media (max-width: 768px) {
  .login-page { grid-template-columns: 1fr; }
  .login__visual { display: none; }
  .login__form-wrap { padding: 40px 24px; }
}
</style>