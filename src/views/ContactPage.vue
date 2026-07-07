<template>
  <div class="contact-page">
    <TheNavbar />
    <div style="padding-top: 72px;">
      <ContactSection />
    </div>
    <TheFooter />
  </div>
</template>
<script setup>
import TheNavbar from '@/components/TheNavbar.vue'
import ContactSection from '@/components/ContactSection.vue'
import TheFooter from '@/components/TheFooter.vue'
</script>
<style scoped>
.contact-page { background: var(--cream); min-height: 100vh; }
</style>