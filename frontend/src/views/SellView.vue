<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const form = ref({
  title: '',
  author: '',
  category: '',
  price: '',
  old_price: '',
  condition: 'Baik',
  description: '',
  stock: 1,
})

const coverFile = ref(null)
const errorMessage = ref('')
const successMessage = ref('')

const handleFile = (event) => {
  coverFile.value = event.target.files[0]
}

const submitBook = async () => {
  try {
    const data = new FormData()

    data.append('title', form.value.title)
    data.append('author', form.value.author)
    data.append('category', form.value.category)
    data.append('price', form.value.price)
    data.append('old_price', form.value.old_price)
    data.append('condition', form.value.condition)
    data.append('description', form.value.description)
    data.append('stock', form.value.stock)

    if (coverFile.value) {
      data.append('cover_file', coverFile.value)
    }

    await axios.post(
        'http://127.0.0.1:8000/api/books',
        data
        )

    successMessage.value = 'Buku berhasil ditambahkan!'
    errorMessage.value = ''

    setTimeout(() => {
      router.push('/')
    }, 1000)
  } catch (error) {
    errorMessage.value = 'Gagal menambahkan buku.'
    console.error(error)
  }
}
</script>

<template>
  <main class="sell-page">
    <section class="sell-card">
      <div class="sell-header">
        <span>Jual Buku</span>
        <h1>Tambahkan Buku Preloved</h1>
        <p>Isi data buku yang ingin kamu jual di SecondShelf.</p>
      </div>

      <p v-if="successMessage" class="auth-success">
        {{ successMessage }}
      </p>

      <p v-if="errorMessage" class="auth-error">
        {{ errorMessage }}
      </p>

      <form class="sell-form" @submit.prevent="submitBook">
        <div class="sell-group">
          <label>Judul Buku</label>
          <input v-model="form.title" type="text" required />
        </div>

        <div class="sell-group">
          <label>Penulis</label>
          <input v-model="form.author" type="text" required />
        </div>

        <div class="sell-row">
          <div class="sell-group">
            <label>Kategori</label>
            <input v-model="form.category" type="text" />
          </div>

          <div class="sell-group">
            <label>Kondisi</label>
            <select v-model="form.condition">
              <option>Baik</option>
              <option>Sangat Baik</option>
              <option>Cukup</option>
            </select>
          </div>
        </div>

        <div class="sell-row">
          <div class="sell-group">
            <label>Harga Jual</label>
            <input v-model="form.price" type="number" required />
          </div>

          <div class="sell-group">
            <label>Harga Asli</label>
            <input v-model="form.old_price" type="number" />
          </div>
        </div>

        <div class="sell-group">
          <label>Stok</label>
          <input v-model="form.stock" type="number" min="1" />
        </div>

        <div class="sell-group">
          <label>Cover Buku</label>
          <input type="file" accept="image/*" @change="handleFile" />
        </div>

        <div class="sell-group">
          <label>Deskripsi</label>
          <textarea v-model="form.description" rows="4"></textarea>
        </div>

        <button type="submit" class="sell-button">
          Jual Buku
        </button>
      </form>
    </section>
  </main>
</template>