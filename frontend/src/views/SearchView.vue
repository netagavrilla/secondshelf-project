<script setup lang="ts">
import { ref, onMounted, watch } from 'vue'
import { useRoute, RouterLink } from 'vue-router'
import axios from 'axios'
import { ShoppingCart, Eye } from 'lucide-vue-next'

const route = useRoute()

const books = ref<any[]>([])
const loading = ref(false)

const requireLogin = () => {
  if (!localStorage.getItem('token')) {
    window.location.href = '/login'
    return false
  }

  return true
}

const addToCart = async (bookId: number) => {
  if (!requireLogin()) return

  try {
    await axios.post('http://127.0.0.1:8000/api/carts', {
      book_id: bookId,
      quantity: 1,
    })

    alert('Buku ditambahkan ke keranjang')
  } catch (error) {
    console.error(error)
  }
}

const getCoverUrl = (cover: string) => {
  if (!cover) return 'https://placehold.co/300x420?text=No+Cover'
  if (cover.startsWith('http')) return cover
  if (cover.startsWith('uploads/')) return `http://127.0.0.1:8000/${cover}`
  if (cover.startsWith('/storage')) return `http://127.0.0.1:8000${cover}`
  if (cover.startsWith('storage/')) return `http://127.0.0.1:8000/${cover}`

  return `http://127.0.0.1:8000/storage/${cover}`
}

const formatRupiah = (value: number) => {
  if (!value) return 'Harga belum tersedia'

  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(value)
}

const getBooks = async () => {
  try {
    loading.value = true

    const keyword = String(route.query.q || '').toLowerCase()

    const res = await axios.get('http://127.0.0.1:8000/api/books')

    books.value = res.data.filter((book: any) => {
      return (
        book.title?.toLowerCase().includes(keyword) ||
        book.author?.toLowerCase().includes(keyword) ||
        book.category?.toLowerCase().includes(keyword)
      )
    })
  } catch (error) {
    console.error(error)
  } finally {
    loading.value = false
  }
}

onMounted(getBooks)

watch(() => route.query.q, getBooks)
</script>

<template>
  <main class="category-books-page">
    <div class="container">
      <div class="category-books-header">
        <span>Pencarian</span>

        <h1>"{{ route.query.q }}"</h1>

        <p>Hasil pencarian buku dan penulis.</p>
      </div>

      <div v-if="loading" class="category-empty">
        <h2>Loading...</h2>
      </div>

      <div v-else-if="books.length === 0" class="category-empty">
        <h2>Buku tidak ditemukan</h2>
        <p>Coba gunakan kata kunci lain.</p>
      </div>

      <div v-else class="products__grid">
        <article
          v-for="book in books"
          :key="book.id"
          class="book-card"
        >
          <div class="book-card__cover">
            <div class="book-card__cover-bg">
              <img
                :src="getCoverUrl(book.cover_image)"
                :alt="book.title"
                class="book-card__img"
              />
            </div>

            <span class="book-card__badge badge--good">
              {{ book.condition || 'Baik' }}
            </span>
          </div>

          <div class="book-card__body">
            <h3 class="book-card__title">
              {{ book.title }}
            </h3>

            <p class="book-card__author">
              {{ book.author }}
            </p>

            <p class="book-card__rating">
              Rating belum tersedia
            </p>

            <div class="book-card__prices">
              <span class="book-card__price">
                {{ formatRupiah(book.price) }}
              </span>

              <span
                v-if="book.old_price"
                class="book-card__price-ori"
              >
                {{ formatRupiah(book.old_price) }}
              </span>
            </div>

            <div class="book-card__actions">
              <RouterLink
                :to="`/books/${book.id}`"
                class="btn-detail"
              >
                <Eye />
                Detail
              </RouterLink>

              <button
                class="btn-cart"
                type="button"
                @click="addToCart(book.id)"
              >
                <ShoppingCart />
                Keranjang
              </button>
            </div>
          </div>
        </article>
      </div>
    </div>
  </main>
</template>