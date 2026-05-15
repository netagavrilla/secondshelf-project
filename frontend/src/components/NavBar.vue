<script setup>
import { computed } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import {
  Search,
  ShoppingCart,
  Heart,
  User,
  Package,
  LogOut,
  LogIn
} from 'lucide-vue-next'

const router = useRouter()

const isLoggedIn = computed(() => {
  return !!localStorage.getItem('token')
})

const logout = () => {
  localStorage.removeItem('token')
  router.push('/login')
}
</script>

<template>
  <header class="navbar">
    <div class="container">
      <div class="navbar__inner">
        <RouterLink to="/" class="navbar__logo">
          SecondShelf
        </RouterLink>

        <nav class="navbar__nav">
          <RouterLink to="/">Home</RouterLink>
          <a href="/#kategori">Kategori</a>
          <a href="/#katalog">Katalog</a>

          <RouterLink
            v-if="isLoggedIn"
            to="/orders"
          >
            Pesanan Saya
          </RouterLink>
        </nav>

        <div class="navbar__right">
          <div class="navbar__search">
            <Search class="navbar__search-icon" :size="16" />
            <input type="text" placeholder="Cari..." />
          </div>

          <div class="navbar__actions">
            <RouterLink
              v-if="isLoggedIn"
              to="/wishlist"
              class="navbar__icon-btn"
              aria-label="Wishlist"
            >
              <Heart />
            </RouterLink>

            <RouterLink
              v-if="isLoggedIn"
              to="/cart"
              class="navbar__icon-btn"
              aria-label="Keranjang"
            >
              <ShoppingCart :size="20" />
            </RouterLink>

            <RouterLink
              v-if="isLoggedIn"
              to="/orders"
              class="navbar__icon-btn"
              aria-label="Pesanan Saya"
            >
              <Package :size="20" />
            </RouterLink>

            <RouterLink
              v-if="isLoggedIn"
              to="/profile"
              class="navbar__icon-btn"
              aria-label="Profil"
            >
              <User :size="20" />
            </RouterLink>

            <button
              v-if="isLoggedIn"
              class="navbar__icon-btn"
              type="button"
              aria-label="Logout"
              @click="logout"
            >
              <LogOut :size="20" />
            </button>

            <RouterLink
              v-else
              to="/login"
              class="navbar__icon-btn"
              aria-label="Login"
            >
              <LogIn :size="20" />
            </RouterLink>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>