<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import { productService } from '@/services/productService'
import { Heart, MessageCircle } from 'lucide-vue-next'

const route = useRoute()
const router = useRouter()

const book = ref<any>(null)
const quantity = ref(1)

const buyNow = () => {
  router.push({
    path: '/checkout',
    query: {
      id: book.value.id,
      title: book.value.title,
      author: book.value.author,
      price: book.value.price,
      cover: book.value.cover_image,
      quantity: quantity.value,
    },
  })
}

const addToCart = async () => {
  try {
    await axios.post('http://127.0.0.1:8000/api/carts', {
      book_id: book.value.id,
      quantity: quantity.value,
    })

    alert('Buku berhasil ditambahkan ke keranjang')

    router.push('/cart')
  } catch (error) {
    console.error(error)

    alert('Gagal menambahkan ke keranjang')
  }
}

const increaseQty = () => {
  if (book.value && quantity.value < book.value.stock) {
    quantity.value++
  }
}

const decreaseQty = () => {
  if (quantity.value > 1) {
    quantity.value--
  }
}

onMounted(async () => {
  try {
    const id = route.params.id as string

    const res = await productService.getProductById(id)
    book.value = res.data
  } catch (error) {
    console.error(error)
  }
})

const formatRupiah = (value: number) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(value)
}
</script>

<template>
  <section class="detail-page">
    <div class="container">

      <div
        v-if="book"
        class="detail-wrapper"
      >

        <!-- LEFT -->
        <div class="detail-left">

          <div class="detail-image-box">
            <img
              :src="book.cover_image"
              class="detail-cover"
            />
          </div>

        </div>

        <!-- MIDDLE -->
        <div class="detail-middle">

          <span class="detail-category">
            {{ book.category || 'Buku' }}
          </span>

          <h1 class="detail-title">
            {{ book.title }}
          </h1>

          <p class="detail-author">
            {{ book.author }}
          </p>

          <p class="detail-condition">
            Kondisi:
            <strong>{{ book.condition }}</strong>
          </p>

          <strong class="detail-price">
            {{ formatRupiah(book.price) }}
          </strong>

          <p class="detail-stock">
            Stok tersedia:
            {{ book.stock }}
          </p>

          <!-- QUANTITY -->
          <div class="detail-qty">

            <span>Jumlah</span>

            <div class="qty-control">

              <button
                type="button"
                @click="decreaseQty"
              >
                -
              </button>

              <strong>
                {{ quantity }}
              </strong>

              <button
                type="button"
                @click="increaseQty"
              >
                +
              </button>

            </div>

          </div>

          <!-- ACTION -->
          <div class="detail-icons">

            <button>
              <Heart />
              Wishlist
            </button>

            <button>
              <MessageCircle />
              Tanya Penjual
            </button>

          </div>

        </div>

        <!-- RIGHT -->
        <div class="detail-right">

          <button
            class="detail-btn-primary"
            type="button"
            @click="buyNow"
          >
            Beli Sekarang
          </button>

          <button
            class="detail-btn-secondary"
            type="button"
            @click="addToCart"
          >
            + Keranjang
          </button>

          <div class="detail-desc-box">

            <h3>Deskripsi</h3>

            <p>
              {{
                book.description ||
                'Belum ada deskripsi untuk buku ini.'
              }}
            </p>

          </div>

        </div>

      </div>

    </div>
  </section>
</template>