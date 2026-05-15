<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import { ShoppingCart, Trash2 } from 'lucide-vue-next'

const router = useRouter()
const carts = ref<any[]>([])

const getCarts = async () => {
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/carts')

    carts.value = res.data.map((item: any) => ({
      ...item,
      quantity: item.quantity || 1,
      selected: true,
    }))
  } catch (error) {
    console.error('Gagal ambil cart:', error)
  }
}

const removeCart = async (id: number) => {
  try {
    await axios.delete(`http://127.0.0.1:8000/api/carts/${id}`)
    getCarts()
  } catch (error) {
    console.error('Gagal hapus:', error)
  }
}

const increaseQty = (item: any) => {
  if (item.book && item.quantity < item.book.stock) {
    item.quantity++
  }
}

const decreaseQty = (item: any) => {
  if (item.quantity > 1) {
    item.quantity--
  }
}

const formatRupiah = (value: number) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(value)
}

const selectedCarts = computed(() => {
  return carts.value.filter((item) => item.selected)
})

const totalPrice = computed(() => {
  return selectedCarts.value.reduce((total, item) => {
    return total + item.book.price * item.quantity
  }, 0)
})

const totalQuantity = computed(() => {
  return selectedCarts.value.reduce((total, item) => {
    return total + item.quantity
  }, 0)
})

const checkoutCart = () => {
  if (selectedCarts.value.length === 0) {
    alert('Pilih minimal satu buku untuk checkout')
    return
  }

  const checkoutItems = selectedCarts.value.map((item) => ({
    cart_id: item.id,
    book_id: item.book.id,
    title: item.book.title,
    author: item.book.author,
    cover: item.book.cover_image,
    price: item.book.price,
    quantity: item.quantity,
    subtotal: item.book.price * item.quantity,
  }))

  localStorage.setItem('checkout_items', JSON.stringify(checkoutItems))

  router.push('/checkout?source=cart')
}

onMounted(getCarts)
</script>

<template>
  <section class="cart-page">
    <div class="container">
      <div class="cart-header">
        <h2>Keranjang Saya</h2>
        <p>Pilih buku yang ingin kamu checkout.</p>
      </div>

      <div v-if="carts.length === 0" class="empty-box">
        <ShoppingCart :size="24" />
        <span>Keranjang masih kosong.</span>
      </div>

      <div v-else class="cart-layout">
        <div class="cart-list">
          <div
            v-for="item in carts"
            :key="item.id"
            class="cart-item"
          >
            <input
              v-model="item.selected"
              type="checkbox"
              class="cart-checkbox"
            />

            <img
              :src="item.book?.cover_image || 'https://placehold.co/120x160?text=No+Cover'"
              :alt="item.book?.title"
              class="cart-img"
            />

            <div class="cart-info">
              <h3>{{ item.book?.title }}</h3>
              <p>{{ item.book?.author }}</p>

              <strong class="price">
                {{ formatRupiah(item.book?.price || 0) }}
              </strong>

              <div class="cart-qty">
                <span>Jumlah</span>

                <div class="qty-control">
                  <button type="button" @click="decreaseQty(item)">
                    -
                  </button>

                  <strong>{{ item.quantity }}</strong>

                  <button type="button" @click="increaseQty(item)">
                    +
                  </button>
                </div>
              </div>

              <p class="cart-subtotal">
                Subtotal:
                <strong>
                  {{ formatRupiah((item.book?.price || 0) * item.quantity) }}
                </strong>
              </p>
            </div>

            <button
              class="btn-delete"
              type="button"
              @click="removeCart(item.id)"
            >
              <Trash2 :size="15" />
              Hapus
            </button>
          </div>
        </div>

        <div class="cart-summary">
          <h3>Ringkasan Keranjang</h3>

          <div class="cart-summary-row">
            <span>Dipilih</span>
            <strong>{{ selectedCarts.length }} buku</strong>
          </div>

          <div class="cart-summary-row">
            <span>Total Jumlah</span>
            <strong>{{ totalQuantity }} item</strong>
          </div>

          <div class="cart-summary-row total">
            <span>Total Harga</span>
            <strong>{{ formatRupiah(totalPrice) }}</strong>
          </div>

          <button
            class="cart-checkout-btn"
            type="button"
            @click="checkoutCart"
          >
            Checkout
          </button>
        </div>
      </div>
    </div>
  </section>
</template>