<script setup lang="ts">
import { ref, onMounted } from 'vue'
import axios from 'axios'

const orders = ref<any[]>([])

const getOrders = async () => {
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/orders')

    orders.value = res.data
  } catch (error) {
    console.error('Gagal ambil orders:', error)
  }
}

const formatRupiah = (value: number) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(value)
}

onMounted(getOrders)
</script>

<template>
  <section class="orders-page">
    <div class="container">

      <div class="orders-header">
        <h2>Pesanan Saya</h2>

        <p>
          Daftar pesanan dan status pembayaran.
        </p>
      </div>

      <div
        v-if="orders.length === 0"
        class="empty-box"
      >
        Belum ada pesanan.
      </div>

      <div
        v-else
        class="orders-list"
      >
        <div
          v-for="order in orders"
          :key="order.id"
          class="order-card"
        >

          <div class="order-top">

            <div>
              <h3>
                Order #{{ order.id }}
              </h3>

              <p>
                {{ order.customer_name }}
              </p>
            </div>

            <span
              class="order-status"
              :class="order.payment_status?.toLowerCase()"
            >
              {{ order.payment_status }}
            </span>

          </div>

          <div class="order-items">

            <div
              v-for="item in order.items"
              :key="item.id"
              class="order-item"
            >
              <img
                :src="item.book?.cover_image || 'https://placehold.co/80x110?text=No+Cover'"
                class="order-img"
              />

              <div class="order-info">
                <h4>
                  {{ item.book?.title }}
                </h4>

                <p>
                  {{ item.book?.author }}
                </p>

                <span>
                  {{ item.quantity }} x
                  {{ formatRupiah(item.price) }}
                </span>
              </div>

              <strong>
                {{ formatRupiah(item.subtotal) }}
              </strong>
            </div>

          </div>

          <div class="order-bottom">

            <span>
              Total Pembayaran
            </span>

            <strong>
              {{ formatRupiah(order.total_price) }}
            </strong>

          </div>

        </div>
      </div>

    </div>
  </section>
</template>