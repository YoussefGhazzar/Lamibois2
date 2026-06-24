<template>
  <div class="home">
    <TheNavbar />
    <HeroSection />
    <ProductsSection />
    <AboutSection />
    <WhyUsSection />
    
    <TheFooter />
  </div>
</template>

<script setup>
import TheNavbar from '@/components/TheNavbar.vue'
import HeroSection from '@/components/HeroSection.vue'
import ProductsSection from '@/components/ProductsSection.vue'
import AboutSection from '@/components/AboutSection.vue'
import WhyUsSection from '@/components/WhyUsSection.vue'
import ContactPage from '@/views/ContactPage.vue'
import TheFooter from '@/components/TheFooter.vue'
</script>

<style scoped>
.home { width: 100%; }
</style>
