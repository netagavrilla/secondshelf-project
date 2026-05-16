<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter, RouterLink } from 'vue-router'

const router = useRouter()

const email = ref('')
const password = ref('')
const errorMessage = ref('')

const login = async () => {
  try {
    const res = await axios.post(
      'http://127.0.0.1:8000/api/login',
      {
        email: email.value,
        password: password.value,
      }
    )

    localStorage.setItem('token', res.data.token)
    localStorage.setItem('user', JSON.stringify(res.data.user))

    window.location.href = '/'
  } catch (error) {
    errorMessage.value = 'Email atau password salah'
    console.error(error)
  }
}
</script>

<template>
  <main class="auth-page">

    <section class="auth-card">

      <div class="auth-top">
        <h1>Welcome Back</h1>

        <p>
          Masuk untuk membeli dan menjual buku preloved favoritmu.
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
        @submit.prevent="login"
      >

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
            placeholder="Masukkan password"
          />
        </div>

        <button
          type="submit"
          class="auth-button"
        >
          Login
        </button>

      </form>

      <p class="auth-switch">
        Belum punya akun?

        <RouterLink to="/register">
          Register
        </RouterLink>
      </p>

    </section>

  </main>
</template>