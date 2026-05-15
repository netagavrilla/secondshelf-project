<template>
  <section class="payment-status-page success">
    <div class="status-card">
      <h1>Pembayaran Berhasil</h1>

      <p>
        Terima kasih, pembayaran pesananmu berhasil diproses.
      </p>

      <RouterLink to="/" class="status-btn">
        Kembali ke Home
      </RouterLink>
    </div>
  </section>
</template>

<script setup>
import { RouterLink } from 'vue-router'
</script>