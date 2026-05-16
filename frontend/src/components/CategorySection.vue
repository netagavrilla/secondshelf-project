<script setup>
import { RouterLink } from 'vue-router'

import {
  BookOpen,
  BookMarked,
  GraduationCap,
  Baby,
  Sparkles,
  Landmark,
} from 'lucide-vue-next'

const categories = [
  { name: 'Novel', icon: BookOpen },
  { name: 'Komik', icon: BookMarked },
  { name: 'Pengetahuan', icon: GraduationCap },
  { name: 'Anak-anak', icon: Baby },
  { name: 'Motivasi', icon: Sparkles },
  { name: 'Sejarah', icon: Landmark },
]
</script>

<template>
  <section class="categories" id="kategori">
    <div class="container">

      <div class="section-header">
        <h2>Kategori Buku</h2>

        <p>
          Temukan buku dari genre favoritmu
        </p>

        <div class="section-bar"></div>
      </div>

      <div class="categories__grid">

        <RouterLink
          v-for="category in categories"
          :key="category.name"
          :to="`/category/${category.name}`"
          class="category-card"
        >

          <div class="category-card__icon">
            <component
              :is="category.icon"
              :size="24"
            />
          </div>

          <div class="category-card__name">
            {{ category.name }}
          </div>

          <div class="category-card__count">
            Lihat koleksi
          </div>

        </RouterLink>

      </div>
    </div>
  </section>
</template>