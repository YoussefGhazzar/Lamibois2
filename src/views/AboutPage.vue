<template>
  <div class="about-page">
    <TheNavbar />
    <div style="padding-top: 72px;">
      <AboutSection />
    </div>
    <TheFooter />
  </div>
</template>
<script setup>
import TheNavbar from '@/components/TheNavbar.vue'
import AboutSection from '@/components/AboutSection.vue'
import TheFooter from '@/components/TheFooter.vue'
</script>
<style scoped>
.about-page { background: var(--linen); min-height: 100vh; }
</style>