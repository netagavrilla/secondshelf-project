import { createRouter, createWebHistory } from 'vue-router'

import HomeView from '@/views/HomeView.vue'
import AboutView from '@/views/AboutView.vue'
import CartView from '@/views/CartView.vue'
import DetailView from '@/views/DetailView.vue'
import WishlistView from '@/views/WishlistView.vue'
import CheckoutView from '@/views/CheckoutView.vue'
import PaymentSuccessView from '@/views/PaymentSuccessView.vue'
import PaymentFailedView from '@/views/PaymentFailedView.vue'
import OrdersView from '@/views/OrdersView.vue'
import LoginView from '@/views/LoginView.vue'
import RegisterView from '@/views/RegisterView.vue'
import ProfileView from '@/views/ProfileView.vue'
import SellView from '@/views/SellView.vue'
import CategoryBooksView from '@/views/CategoryBooksView.vue'
import SearchView from '@/views/SearchView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),

  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },

    {
      path: '/about',
      name: 'about',
      component: AboutView,
    },

    {
      path: '/books/:id',
      name: 'detail',
      component: DetailView,
    },

    {
      path: '/category/:name',
      component: CategoryBooksView,
    },

    {
      path: '/login',
      component: LoginView,
    },

    {
      path: '/register',
      component: RegisterView,
    },

    {
      path: '/cart',
      name: 'cart',
      component: CartView,
      meta: { requiresAuth: true },
    },

    {
      path: '/wishlist',
      name: 'wishlist',
      component: WishlistView,
      meta: { requiresAuth: true },
    },

    {
      path: '/checkout',
      name: 'checkout',
      component: CheckoutView,
      meta: { requiresAuth: true },
    },

    {
      path: '/payment-success',
      name: 'payment-success',
      component: PaymentSuccessView,
      meta: { requiresAuth: true },
    },

    {
      path: '/payment-failed',
      name: 'payment-failed',
      component: PaymentFailedView,
      meta: { requiresAuth: true },
    },

    {
      path: '/orders',
      name: 'orders',
      component: OrdersView,
      meta: { requiresAuth: true },
    },

    {
      path: '/profile',
      component: ProfileView,
      meta: { requiresAuth: true },
    },

    {
      path: '/sell',
      component: SellView,
      meta: { requiresAuth: true },
    },
    {
      path: '/search',
      component: SearchView,
    },
  ],
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')

  if (to.meta.requiresAuth && !token) {
    next('/login')
  } else {
    next()
  }
})

export default router