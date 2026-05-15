<script setup>
import NavBar from './components/NavBar.vue'
import FooterSection from './components/FooterSection.vue'
import { RouterView } from 'vue-router'
</script>

<template>
  <NavBar />
  <RouterView />
  <FooterSection />
</template>