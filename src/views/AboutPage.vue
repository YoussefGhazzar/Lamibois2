<template>
  <div class="about-page">
    <TheNavbar />
    <div class="about-page__content">
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
.about-page {
  background: var(--linen);
  min-height: 100vh;
}
.about-page__content {
  padding-top: 72px;
}
</style>