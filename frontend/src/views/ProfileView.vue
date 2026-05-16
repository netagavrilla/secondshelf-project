<script setup>
import { ref, onMounted } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import { User, Mail, BookOpen, Package, Settings, LogOut, Plus } from 'lucide-vue-next'

const router = useRouter()

const user = ref({
  name: 'User SecondShelf',
  email: 'user@email.com',
})

const myBooks = ref([
  {
    id: 1,
    title: 'Atomic Habits',
    price: 45000,
    status: 'Aktif',
    stock: 5,
  },
  {
    id: 2,
    title: 'Cantik Itu Luka',
    price: 50000,
    status: 'Aktif',
    stock: 1,
  },
])

onMounted(() => {
  const savedUser = localStorage.getItem('user')

  if (savedUser) {
    user.value = JSON.parse(savedUser)
  }
})

const formatRupiah = (value) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(value)
}

const logout = () => {
  localStorage.removeItem('token')
  localStorage.removeItem('user')
  router.push('/login')
}
</script>

<template>
  <main class="profile-page">
    <div class="container">
      <section class="profile-header">
        <div class="profile-avatar">
          <User :size="34" />
        </div>

        <div>
          <h1>{{ user.name }}</h1>
          <p>{{ user.email }}</p>
        </div>
      </section>

      <section class="profile-grid">
        <div class="profile-card">
          <div class="profile-card__title">
            <User :size="20" />
            <h2>Informasi Akun</h2>
          </div>

          <div class="profile-info">
            <p>
              <span>Nama</span>
              <strong>{{ user.name }}</strong>
            </p>

            <p>
              <span>Email</span>
              <strong>{{ user.email }}</strong>
            </p>
          </div>

          <button class="profile-btn">
            Edit Profile
          </button>
        </div>

        <div class="profile-card">
          <div class="profile-card__title">
            <Package :size="20" />
            <h2>Ringkasan Aktivitas</h2>
          </div>

          <div class="profile-stats">
            <div>
              <strong>2</strong>
              <span>Buku Dijual</span>
            </div>

            <div>
              <strong>0</strong>
              <span>Pesanan Pending</span>
            </div>

            <div>
              <strong>0</strong>
              <span>Transaksi Selesai</span>
            </div>
          </div>
        </div>
      </section>

      <section class="profile-card profile-section">
        <div class="profile-section__header">
          <div class="profile-card__title">
            <BookOpen :size="20" />
            <h2>Buku yang Saya Jual</h2>
          </div>

          <RouterLink to="/sell" class="profile-add-btn">
            <Plus :size="18" />
            Tambah Buku
          </RouterLink>
        </div>

        <div class="seller-books">
          <article
            v-for="book in myBooks"
            :key="book.id"
            class="seller-book-card"
          >
            <div>
              <h3>{{ book.title }}</h3>
              <p>{{ formatRupiah(book.price) }}</p>
            </div>

            <div class="seller-book-meta">
              <span>{{ book.status }}</span>
              <small>Stok: {{ book.stock }}</small>
            </div>
          </article>
        </div>
      </section>

      <section class="profile-card profile-section">
        <div class="profile-card__title">
          <Settings :size="20" />
          <h2>Pengaturan</h2>
        </div>

        <div class="profile-actions">
          <button class="profile-btn">
            Ubah Password
          </button>

          <button class="profile-btn profile-btn--danger" @click="logout">
            <LogOut :size="18" />
            Logout
          </button>
        </div>
      </section>
    </div>
  </main>
</template>