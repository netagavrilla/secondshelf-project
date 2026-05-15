<script setup>
import { MessageCircle, Star, PenLine } from 'lucide-vue-next'

const testimonials = []
</script>

<template>
  <section class="testimonials">
    <div class="container">
      <div class="section-header">
        <h2>Apa Kata Mereka?</h2>
        <p>Pengalaman pembeli SecondShelf</p>
        <div class="section-bar"></div>
      </div>

      <div v-if="testimonials.length" class="testimonials__grid">
        <div class="testi-card" v-for="testi in testimonials" :key="testi.id">
          <p class="testi-card__text">"{{ testi.text }}"</p>

          <div class="testi-card__footer">
            <div class="testi-card__name">{{ testi.name }}</div>
            <div class="testi-card__role">{{ testi.role }}</div>

            <div class="testi-card__stars">
              <Star
                v-for="star in 5"
                :key="star"
                :size="12"
                fill="currentColor"
              />
            </div>
          </div>
        </div>
      </div>

      <div v-else class="testimonials__empty">
        <div class="testimonials__empty-icon">
          <MessageCircle :size="30" />
        </div>

        <h3>Belum ada ulasan</h3>
        <p>Jadilah pembeli pertama yang membagikan pengalamanmu.</p>

        <button class="btn-review" type="button">
          <PenLine :size="15" />
          Tulis Ulasan
        </button>
      </div>
    </div>
  </section>
</template>