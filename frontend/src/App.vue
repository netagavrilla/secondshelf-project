<script setup>
import { computed } from 'vue'
import { useRoute, RouterView } from 'vue-router'

import NavBar from './components/NavBar.vue'
import FooterSection from './components/FooterSection.vue'

const route = useRoute()

const hideLayout = computed(() => {
  return route.path === '/login' || route.path === '/register'
})
</script>

<template>
  <NavBar v-if="!hideLayout" />

  <RouterView />

  <FooterSection v-if="!hideLayout" />
</template>