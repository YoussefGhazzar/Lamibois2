<template>
  <div class="admin-layout">
    
    <!-- Left: Thematic Brand Panel -->
    <div class="theme-panel">
      <div class="geometric-background"></div>
      
      <div class="theme-content">
        <!-- Logo Header -->
        <div class="brand-header">
          <div class="logo-circle">
            <span>LB</span>
          </div>
          <span class="brand-name">LAMIBOIS</span>
        </div>

        <!-- Main Hero Text -->
        <div class="hero-text-block">
          <div class="overline-group">
            <div class="overline-line"></div>
            <span class="overline-text">PORTAIL D'ADMINISTRATION SÉCURISÉ</span>
          </div>
          <h1 class="hero-title">
            La matière <span class="text-gold italic">noble</span><br/>
            au service de vos<br/>
            projets
          </h1>
          <p class="hero-description">
            Interface de gestion des stocks, commandes et partenaires B2B. Accès strictement réservé au personnel autorisé Lamibois.
          </p>
        </div>
      </div>
    </div>

    <!-- Right: Admin Login Form -->
    <div class="form-panel">
      <div class="form-container">
        
        <!-- Mobile Header (Hidden on Desktop) -->
        <div class="mobile-header">
          <div class="logo-circle"><span>LB</span></div>
          <span class="brand-name">LAMIBOIS ADMIN</span>
        </div>

        <!-- Form Header -->
        <div class="form-heading">
          <h2>Connexion Admin</h2>
          <p>Saisissez vos identifiants pour accéder au tableau de bord.</p>
        </div>

        <!-- Auth Form -->
        <form @submit.prevent="login" class="admin-form">
          
          <!-- Colored & Filled Floating Label Text Box: Email -->
          <div class="input-wrapper">
            <input 
              id="email" 
              v-model="email" 
              type="email" 
              placeholder=" "
              :disabled="loading"
              class="premium-input"
            />
            <label for="email" class="premium-label">Adresse e-mail</label>
          </div>

          <!-- Colored & Filled Floating Label Text Box: Password -->
          <div class="input-wrapper">
            <input 
              id="password" 
              v-model="password" 
              type="password" 
              placeholder=" "
              :disabled="loading"
              class="premium-input"
            />
            <label for="password" class="premium-label">Mot de passe</label>
          </div>

          <!-- Error Alert -->
          <Transition name="fade">
            <div v-if="error" class="error-box">
              <span class="error-icon">⚠</span>
              <span>{{ error }}</span>
            </div>
          </Transition>

          <!-- Submit Button -->
          <button type="submit" :disabled="loading" class="gold-button">
            <span v-if="loading" class="spinner"></span>
            <span v-else>Connexion →</span>
          </button>

        </form>

        <div class="footer-note">
          <p>© 2026 Lamibois — Plateforme d'administration.</p>
          <p>Toute tentative d'accès non autorisé est surveillée.</p>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()
const email = ref('')
const password = ref('')
const loading = ref(false)
const error = ref('')

function login() {
  if (!email.value || !password.value) {
    error.value = 'Veuillez saisir vos identifiants administrateur.'
    return
  }
  error.value = ''
  loading.value = true

  axios.post('/admin/login', {
    email: email.value,
    password: password.value,
  })
    .then(() => {
      router.push('/dashboard')
    })
    .catch(() => {
      error.value = 'Identifiants invalides. Accès refusé.'
    })
    .finally(() => {
      loading.value = false
    })
}
</script>

<style scoped>
/* Core Layout & Colors */
:root {
  --color-green-darkest: #131b14;
  --color-green-dark: #1b261a;
  --color-green-olive: #2a3727;
  --color-brown-dark: #383424;
  --color-gold-dark: #826e45;
  --color-gold-light: #d1b88a;
  --color-gold-bright: #e5cc9d;
  --color-text-main: #ffffff;
  --color-text-muted: #a3a099;
}

.admin-layout {
  display: flex;
  min-height: 100vh;
  background-color: var(--color-green-darkest);
  color: var(--color-text-main);
  font-family: 'Helvetica Neue', Arial, sans-serif;
  margin: 0;
  box-sizing: border-box;
}

/* Left Panel: Background Geometry */
.theme-panel {
  display: none;
  width: 55%;
  position: relative;
  overflow: hidden;
}

@media (min-width: 1024px) {
  .theme-panel {
    display: block;
  }
}

.geometric-background {
  position: absolute;
  inset: 0;
  z-index: 1;
  background: linear-gradient(
    102deg,
    #1b261a 0%, #1b261a 38%,
    #2a3727 38.1%, #2a3727 60%,
    #383424 60.1%, #383424 78%,
    #826e45 78.1%, #826e45 90%,
    #a69e88 90.1%, #a69e88 100%
  );
}

.geometric-background::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(to bottom, rgba(19, 27, 20, 0.2), rgba(19, 27, 20, 0.6));
}

.theme-content {
  position: relative;
  z-index: 10;
  height: 100%;
  padding: 3rem 4rem;
  display: flex;
  flex-direction: column;
}

/* Header & Logo */
.brand-header {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.logo-circle {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: 1px solid var(--color-gold-light);
  display: flex;
  align-items: center;
  justify-content: center;
}

.logo-circle span {
  font-size: 0.8rem;
  font-weight: 400;
  color: var(--color-gold-light);
  letter-spacing: 1px;
}

.brand-name {
  font-size: 0.9rem;
  font-weight: 600;
  letter-spacing: 0.3em;
  color: var(--color-text-main);
}

/* Hero Typography */
.hero-text-block {
  margin-top: auto;
  margin-bottom: auto;
  max-width: 35rem;
}

.overline-group {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 2rem;
}

.overline-line {
  width: 40px;
  height: 1px;
  background-color: var(--color-gold-light);
}

.overline-text {
  font-size: 0.75rem;
  font-weight: 600;
  letter-spacing: 0.2em;
  color: var(--color-gold-light);
}

.hero-title {
  font-family: 'Georgia', serif;
  font-size: 4rem;
  line-height: 1.1;
  font-weight: 400;
  margin: 0 0 1.5rem 0;
  color: #ffffff;
}

.text-gold {
  color: var(--color-gold-light);
}

.italic {
  font-style: italic;
}

.hero-description {
  font-size: 0.95rem;
  line-height: 1.6;
  color: #c9c5bc;
  max-width: 85%;
}

/* Right Panel: Form */
.form-panel {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: var(--color-green-darkest);
  padding: 2rem;
  border-left: 1px solid rgba(255, 255, 255, 0.05);
}

.form-container {
  width: 100%;
  max-width: 400px;
}

.mobile-header {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 3rem;
}

@media (min-width: 1024px) {
  .mobile-header { display: none; }
}

.form-heading {
  margin-bottom: 3rem;
}

.form-heading h2 {
  font-family: 'Georgia', serif;
  font-size: 2.2rem;
  font-weight: 400;
  margin: 0 0 0.5rem 0;
  color: var(--color-gold-light);
}

.form-heading p {
  font-size: 0.85rem;
  color: var(--color-text-muted);
  margin: 0;
}

.admin-form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

/* 
  TEXT BOX DESIGN: Warmer Gold Tint & Brighter Text
*/
.input-wrapper {
  position: relative;
  width: 100%;
}

.premium-input {
  width: 100%;
  /* A warmer, subtle gold background fill */
  background: rgba(209, 184, 138, 0.06); 
  border: 1px solid rgba(209, 184, 138, 0.3); 
  border-radius: 6px;
  color: #ffffff; /* Bright white text inside the box */
  font-size: 1rem;
  padding: 1.5rem 1rem 0.5rem 1rem; 
  outline: none;
  transition: all 0.3s ease;
  box-sizing: border-box;
}

/* Focus state */
.premium-input:focus {
  background: rgba(209, 184, 138, 0.12);
  border-color: var(--color-gold-light);
  box-shadow: 0 0 0 1px var(--color-gold-light);
}

/* The "sous text" (Floating Label) */
.premium-label {
  position: absolute;
  top: 1.1rem;
  left: 1rem;
  font-size: 0.85rem;
  font-weight: 500;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  /* More visible gold color instead of muted gray */
  color: rgba(209, 184, 138, 0.7); 
  pointer-events: none;
  transition: all 0.3s ease;
}

/* Floating behavior pushes the label up */
.premium-input:focus ~ .premium-label,
.premium-input:not(:placeholder-shown) ~ .premium-label {
  top: 0.4rem;
  font-size: 0.65rem;
  color: var(--color-gold-light); /* Fully bright gold when floating */
}

/* 
  SOLID BUTTON DESIGN
*/
.gold-button {
  /* Solid gold gradient background */
  background: linear-gradient(135deg, var(--color-gold-light) 0%, #a68b56 100%);
  color: var(--color-green-darkest); /* Dark text for contrast */
  border: none;
  padding: 1.1rem;
  margin-top: 1rem;
  border-radius: 6px;
  font-size: 0.8rem;
  font-weight: 800;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  cursor: pointer;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.gold-button:hover {
  /* Brighter gold on hover */
  background: linear-gradient(135deg, var(--color-gold-bright) 0%, #bca16c 100%);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
  transform: translateY(-1px);
}

.gold-button:disabled {
  opacity: 0.7;
  cursor: not-allowed;
  transform: none;
  box-shadow: none;
}

/* Loading & Errors */
.spinner {
  width: 1.2rem;
  height: 1.2rem;
  border: 2px solid rgba(19, 27, 20, 0.2);
  border-top-color: var(--color-green-darkest);
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.error-box {
  background-color: rgba(239, 68, 68, 0.1);
  border: 1px solid rgba(239, 68, 68, 0.4);
  border-radius: 6px;
  color: #fca5a5;
  padding: 0.75rem 1rem;
  font-size: 0.85rem;
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.error-icon {
  font-size: 1.1rem;
}

.footer-note {
  margin-top: 4rem;
  padding-top: 1.5rem;
  font-size: 0.7rem;
  color: #666;
  text-align: center;
  line-height: 1.5;
}

.footer-note p {
  margin: 0;
}

/* Animations */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>