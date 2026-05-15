<script setup>
import { BookOpen, Instagram, Mail, MessageCircle } from 'lucide-vue-next'
</script>

<template>
  <footer class="footer" id="tentang">
    <div class="container">
      <div class="footer__inner">
        <div class="footer__brand">
          <div class="footer__brand-logo">
            <span class="footer__brand-logo-icon">
              <BookOpen />
            </span>
            <span>SecondShelf</span>
          </div>

          <p class="footer__brand-desc">
            Platform jual beli buku preloved berkualitas untuk pelajar dan mahasiswa.
          </p>

          <div class="footer__socials">
            <button class="footer__social-btn" type="button" aria-label="Instagram">
              <Instagram />
            </button>
            <button class="footer__social-btn" type="button" aria-label="Email">
              <Mail />
            </button>
            <button class="footer__social-btn" type="button" aria-label="WhatsApp">
              <MessageCircle />
            </button>
          </div>
        </div>

        <div class="footer__col">
          <h3 class="footer__col-title">Informasi Platform</h3>
          <ul class="footer__links">
            <li><a href="#tentang">Tentang Kami</a></li>
            <li><a href="#">Cara Kerja</a></li>
            <li><a href="#">Bantuan</a></li>
          </ul>
        </div>

        <div class="footer__col">
          <h3 class="footer__col-title">Navigasi Cepat</h3>
          <ul class="footer__links">
            <li><a href="#">Home</a></li>
            <li><a href="#kategori">Kategori</a></li>
            <li><a href="#katalog">Katalog</a></li>
          </ul>
        </div>
      </div>

      <div class="footer__bottom">
        © 2026 SecondShelf. All rights reserved.
      </div>
    </div>
  </footer>
</template>