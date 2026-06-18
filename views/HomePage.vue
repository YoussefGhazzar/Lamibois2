<template>
  <div class="home">
    <TheNavbar />
    <HeroSection />
    <ProductsSection />
    <AboutSection />
    <WhyUsSection />
    <ContactSection />
    <TheFooter />
  </div>
</template>

<script setup>
import TheNavbar      from '@/components/TheNavbar.vue'
import HeroSection    from '@/components/HeroSection.vue'
import ProductsSection from '@/components/ProductsSection.vue'
import AboutSection   from '@/components/AboutSection.vue'
import WhyUsSection   from '@/components/WhyUsSection.vue'
import ContactSection from '@/components/ContactSection.vue'
import TheFooter      from '@/components/TheFooter.vue'
</script>

<style scoped>
.home { width: 100%; }
</style>
