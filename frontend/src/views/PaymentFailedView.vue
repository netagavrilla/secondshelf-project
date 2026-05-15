<template>
  <section class="payment-status-page failed">
    <div class="status-card">
      <h1>Pembayaran Gagal</h1>

      <p>
        Pembayaran belum berhasil atau invoice telah expired.
      </p>

      <RouterLink to="/cart" class="status-btn">
        Kembali ke Keranjang
      </RouterLink>
    </div>
  </section>
</template>

<script setup>
import { RouterLink } from 'vue-router'
</script>