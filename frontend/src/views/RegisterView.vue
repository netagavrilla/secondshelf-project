<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { RouterLink } from 'vue-router'

const name = ref('')
const email = ref('')
const password = ref('')
const errorMessage = ref('')

const register = async () => {
  try {
    const res = await axios.post('http://127.0.0.1:8000/api/register', {
      name: name.value,
      email: email.value,
      password: password.value,
    })

    localStorage.setItem('token', res.data.token)
    localStorage.setItem('user', JSON.stringify(res.data.user))

    window.location.href = '/'
  } catch (error) {
    errorMessage.value = 'Register gagal. Cek kembali data yang kamu isi.'
    console.error(error)
  }
}
</script>

<template>
  <main class="auth-page">
    <section class="auth-card">
      <div class="auth-top">
        <h1>Create Account</h1>

        <p>
          Daftar untuk mulai membeli, menjual, dan menyimpan buku favoritmu.
        </p>
      </div>

      <p
        v-if="errorMessage"
        class="auth-error"
      >
        {{ errorMessage }}
      </p>

      <form
        class="auth-form"
        @submit.prevent="register"
      >
        <div class="auth-group">
          <label>Nama</label>

          <input
            v-model="name"
            type="text"
            placeholder="Masukkan nama"
          />
        </div>

        <div class="auth-group">
          <label>Email</label>

          <input
            v-model="email"
            type="email"
            placeholder="Masukkan email"
          />
        </div>

        <div class="auth-group">
          <label>Password</label>

          <input
            v-model="password"
            type="password"
            placeholder="Minimal 6 karakter"
          />
        </div>

        <button
          type="submit"
          class="auth-button"
        >
          Register
        </button>
      </form>

      <p class="auth-switch">
        Sudah punya akun?

        <RouterLink to="/login">
          Login
        </RouterLink>
      </p>
    </section>
  </main>
</template>