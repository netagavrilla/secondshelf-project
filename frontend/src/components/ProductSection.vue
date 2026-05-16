<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { RouterLink } from 'vue-router'
import { Heart, ShoppingCart, Eye } from 'lucide-vue-next'

const books = ref([])

const getCoverUrl = (cover) => {
  if (!cover) {
    return 'https://placehold.co/300x420?text=No+Cover'
  }

  if (cover.startsWith('http')) {
    return cover
  }

  if (cover.startsWith('uploads/')) {
    return `http://127.0.0.1:8000/${cover}`
  }

  if (cover.startsWith('/storage')) {
    return `http://127.0.0.1:8000${cover}`
  }

  if (cover.startsWith('storage/')) {
    return `http://127.0.0.1:8000/${cover}`
  }

  return `http://127.0.0.1:8000/storage/${cover}`
}


onMounted(async () => {
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/books')

    books.value = res.data
  } catch (error) {
    console.error('Gagal mengambil data buku:', error)
  }
})

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

const formatRupiah = (value) => {
  if (!value) return 'Harga belum tersedia'

  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(value)
}
</script>

<template>
  <section class="products" id="katalog">
    <div class="container">

      <div class="products__header">

        <div class="products__header-left">
          <h2>Produk Pilihan</h2>

          <div class="section-bar"></div>
        </div>

        <a href="#" class="products__view-all">
          Lihat semua →
        </a>

      </div>

      <div class="products__grid">

        <article
          class="book-card"
          v-for="book in books"
          :key="book.id"
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
              aria-label="Wishlist"
              @click="addToWishlist(book.id)"
            >
              <Heart />
            </button>

          </div>

          <div class="book-card__body">

            <h3 class="book-card__title">
              {{ book.title || 'Nama buku belum tersedia' }}
            </h3>

            <p class="book-card__author">
              {{ book.author || 'Penulis belum tersedia' }}
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
  </section>
</template>