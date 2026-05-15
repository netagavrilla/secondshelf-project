<script setup lang="ts">
import { ref } from 'vue'
import axios from 'axios'
import { useRoute } from 'vue-router'

const route = useRoute()

const formatRupiah = (value: number) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(value)
}

const quantity = Number(route.query.quantity || 1)
const price = Number(route.query.price || 0)

const cover = String(
  route.query.cover ||
  'https://placehold.co/120x160?text=No+Cover'
)

const title = String(route.query.title || 'Judul tidak tersedia')
const author = String(route.query.author || 'Penulis tidak tersedia')

const total = quantity * price
const shipping = 10000
const grandTotal = total + shipping

const customerName = ref('')
const phone = ref('')
const address = ref('')
const paymentMethod = ref('DANA')
const note = ref('')

const checkout = async () => {
  try {
    if (
      !customerName.value ||
      !phone.value ||
      !address.value ||
      !paymentMethod.value
    ) {
      alert('Mohon lengkapi data checkout')
      return
    }

    const res = await axios.post('http://127.0.0.1:8000/api/orders', {
      customer_name: customerName.value,
      phone: phone.value,
      address: address.value,
      payment_method: paymentMethod.value,
      note: note.value,
      total_price: grandTotal,
      items: [
        {
          book_id: route.query.id,
          quantity: quantity,
          price: price,
          subtotal: total,
        },
      ],
    })

    window.location.href = res.data.invoice_url
  } catch (error) {
    console.error(error)
    alert('Gagal checkout')
  }
}
</script>

<template>
  <section class="checkout-page">
    <div class="container">
      <div class="checkout-header">
        <h2>Checkout</h2>
        <p>Periksa kembali pesananmu sebelum pembayaran.</p>
      </div>

      <div class="checkout-wrapper">
        <div class="checkout-left">
          <div class="checkout-item">
            <img
              :src="cover"
              :alt="title"
              class="checkout-img"
            />

            <div class="checkout-info">
              <h3>{{ title }}</h3>
              <p>{{ author }}</p>
              <span>Jumlah: {{ quantity }}</span>
              <strong>{{ formatRupiah(price) }}</strong>
            </div>
          </div>

          <div class="checkout-form">
            <h3>Informasi Pengiriman</h3>

            <div class="form-group">
              <label>Nama Penerima</label>
              <input
                v-model="customerName"
                type="text"
                placeholder="Masukkan nama penerima"
                required
              />
            </div>

            <div class="form-group">
              <label>Nomor HP</label>
              <input
                v-model="phone"
                type="text"
                placeholder="08xxxxxxxxxx"
                required
              />
            </div>

            <div class="form-group">
              <label>Alamat Lengkap</label>
              <textarea
                v-model="address"
                rows="4"
                placeholder="Masukkan alamat lengkap"
                required
              ></textarea>
            </div>

            <div class="form-group">
              <label>Metode Pembayaran</label>
              <select v-model="paymentMethod" required>
                <option>DANA</option>
                <option>ShopeePay</option>
                <option>GoPay</option>
                <option>Transfer Bank</option>
                <option>COD</option>
              </select>
            </div>

            <div class="form-group">
              <label>Catatan</label>
              <textarea
                v-model="note"
                rows="3"
                placeholder="Tambahkan catatan pesanan"
              ></textarea>
            </div>
          </div>
        </div>

        <div class="checkout-right">
          <h3>Ringkasan Belanja</h3>

          <div class="checkout-summary-row">
            <span>Total Produk</span>
            <strong>{{ formatRupiah(total) }}</strong>
          </div>

          <div class="checkout-summary-row">
            <span>Ongkir</span>
            <strong>{{ formatRupiah(shipping) }}</strong>
          </div>

          <div class="checkout-summary-row total">
            <span>Total Pembayaran</span>
            <strong>{{ formatRupiah(grandTotal) }}</strong>
          </div>

          <button
            class="checkout-btn"
            type="button"
            @click="checkout"
          >
            Bayar Sekarang
          </button>
        </div>
      </div>
    </div>
  </section>
</template>