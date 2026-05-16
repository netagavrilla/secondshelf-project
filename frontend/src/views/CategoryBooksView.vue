<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute, RouterLink } from 'vue-router'
import axios from 'axios'
import { Eye, ShoppingCart, Heart } from 'lucide-vue-next'

const route = useRoute()
const books = ref([])

const categoryName = computed(() => route.params.name)

const filteredBooks = computed(() => {
  return books.value.filter((book) => {
    return book.category?.toLowerCase() === categoryName.value.toLowerCase()
  })
})

const getCoverUrl = (cover) => {
  if (!cover) return 'https://placehold.co/300x420?text=No+Cover'
  if (cover.startsWith('http')) return cover
  if (cover.startsWith('uploads/')) return `http://127.0.0.1:8000/${cover}`
  if (cover.startsWith('/storage')) return `http://127.0.0.1:8000${cover}`
  if (cover.startsWith('storage/')) return `http://127.0.0.1:8000/${cover}`

  return `http://127.0.0.1:8000/storage/${cover}`
}

const formatRupiah = (value) => {
  if (!value) return 'Harga belum tersedia'

  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(value)
}

const addToWishlist = async (bookId) => {
  try {
    await axios.post('http://127.0.0.1:8000/api/wishlists', {
      book_id: bookId,
    })

    alert('Buku ditambahkan ke wishlist')
  } catch (error) {
    console.error('Gagal tambah wishlist:', error)
  }
}

const addToCart = async (bookId) => {
  try {
    await axios.post('http://127.0.0.1:8000/api/carts', {
      book_id: bookId,
      quantity: 1,
    })

    alert('Buku ditambahkan ke keranjang')
  } catch (error) {
    console.error('Gagal tambah keranjang:', error)
  }
}

onMounted(async () => {
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/books')
    books.value = res.data
  } catch (error) {
    console.error('Gagal mengambil data buku:', error)
  }
})
</script>

<template>
  <main class="category-books-page">
    <div class="container">
      <div class="category-books-header">
        <span>Kategori Buku</span>
        <h1>{{ categoryName }}</h1>
        <p>
          Menampilkan buku berdasarkan kategori {{ categoryName }}.
        </p>
      </div>

      <div
        v-if="filteredBooks.length"
        class="products__grid"
      >
        <article
          v-for="book in filteredBooks"
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

            <button
              class="book-card__wish"
              type="button"
              @click="addToWishlist(book.id)"
            >
              <Heart />
            </button>
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

      <div
        v-else
        class="category-empty"
      >
        <h2>Belum ada buku di kategori ini</h2>
        <p>Coba pilih kategori lain atau jual buku pertamamu.</p>

        <RouterLink
          to="/sell"
          class="profile-add-btn"
        >
          Jual Buku
        </RouterLink>
      </div>
    </div>
  </main>
</template>