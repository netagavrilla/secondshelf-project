<script setup>
import { ref, onMounted } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import {
  Search,
  ShoppingCart,
  Heart,
  User,
  Package,
  LogIn
} from 'lucide-vue-next'

const router = useRouter()

const search = ref('')

const isLoggedIn = ref(false)
const showUserMenu = ref(false)

const submitSearch = () => {
  const keyword = search.value.trim()

  if (!keyword) return

  router.push({
    path: '/search',
    query: {
      q: keyword,
    },
  })
}

onMounted(() => {
  isLoggedIn.value = !!localStorage.getItem('token')
})

const toggleUserMenu = () => {
  showUserMenu.value = !showUserMenu.value
}

const logout = () => {
  localStorage.removeItem('token')
  localStorage.removeItem('user')

  showUserMenu.value = false
  isLoggedIn.value = false

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

          <a href="/#kategori">
            Kategori
          </a>

          <a href="/#katalog">
            Katalog
          </a>
        </nav>

        <div class="navbar__right">

          <form
            class="navbar__search"
            @submit.prevent="submitSearch"
          >

            <Search
              class="navbar__search-icon"
              :size="16"
            />

            <input
              v-model="search"
              type="text"
              placeholder="Cari buku atau penulis..."
            />

          </form>

          <div class="navbar__actions">

            <RouterLink
              v-if="isLoggedIn"
              to="/wishlist"
              class="navbar__icon-btn"
            >
              <Heart />
            </RouterLink>

            <RouterLink
              v-if="isLoggedIn"
              to="/cart"
              class="navbar__icon-btn"
            >
              <ShoppingCart :size="20" />
            </RouterLink>

            <RouterLink
              v-if="isLoggedIn"
              to="/orders"
              class="navbar__icon-btn"
            >
              <Package :size="20" />
            </RouterLink>

            <div
              v-if="isLoggedIn"
              class="navbar__user-menu"
            >
              <button
                class="navbar__icon-btn"
                type="button"
                @click="toggleUserMenu"
              >
                <User :size="20" />
              </button>

              <div
                v-if="showUserMenu"
                class="navbar__dropdown"
              >
                <RouterLink
                  to="/profile"
                  @click="showUserMenu = false"
                >
                  Setting
                </RouterLink>

                <button
                  type="button"
                  @click="logout"
                >
                  Logout
                </button>
              </div>
            </div>

            <RouterLink
              v-else
              to="/login"
              class="navbar__login-btn"
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