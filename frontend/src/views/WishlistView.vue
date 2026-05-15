<script setup>
import { ref, onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import axios from 'axios'
import { Heart, Trash2 } from 'lucide-vue-next'

const wishlists = ref([])

const getWishlists = async () => {
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/wishlists')
    wishlists.value = res.data
  } catch (error) {
    console.error('Gagal ambil wishlist:', error)
  }
}

const removeWishlist = async (id) => {
  try {
    await axios.delete(`http://127.0.0.1:8000/api/wishlists/${id}`)
    getWishlists()
  } catch (error) {
    console.error('Gagal hapus wishlist:', error)
  }
}

const addToCart = async (bookId) => {
  try {
    await axios.post('http://127.0.0.1:8000/api/carts', {
      book_id: bookId,
      quantity: 1,
    })

    alert('Buku berhasil ditambahkan ke keranjang')
  } catch (error) {
    console.error('Gagal tambah keranjang:', error)
    alert('Gagal menambahkan ke keranjang')
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

onMounted(getWishlists)
</script>

<template>
  <section class="wishlist-page">
    <div class="container">
      <div class="wishlist-header">
        <h2>Wishlist Saya</h2>
        <p>Buku yang kamu simpan untuk dilihat nanti.</p>
      </div>

      <div v-if="wishlists.length === 0" class="empty-box">
        <Heart :size="24" />
        <span>Belum ada buku yang disukai.</span>
      </div>

      <div v-else class="wishlist-list">
        <div
          v-for="item in wishlists"
          :key="item.id"
          class="wishlist-item"
        >
          <RouterLink
            :to="`/books/${item.book.id}`"
            class="wishlist-cover-link"
          >
            <img
              :src="item.book.cover_image || 'https://placehold.co/120x160?text=No+Cover'"
              :alt="item.book.title"
              class="wishlist-item__img"
            />
          </RouterLink>

          <div class="wishlist-item__content">
            <RouterLink
              :to="`/books/${item.book.id}`"
              class="wishlist-item__info"
            >
              <h3>{{ item.book.title }}</h3>
              <p>{{ item.book.author }}</p>
              <strong>{{ formatRupiah(item.book.price) }}</strong>
            </RouterLink>

            <div class="wishlist-actions">
              <button
                class="btn-cart"
                type="button"
                @click="addToCart(item.book.id)"
              >
                + Keranjang
              </button>
            </div>
          </div>

          <button
            class="btn-remove"
            type="button"
            @click="removeWishlist(item.id)"
          >
            <Trash2 :size="15" />
            Hapus
          </button>
        </div>
      </div>
    </div>
  </section>
</template>