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
      path: '/cart',
      name: 'cart',
      component: CartView,
    },
    {
      path: '/books/:id',
      name: 'detail',
      component: DetailView,
    },
    {
      path: '/wishlist',
      name: 'wishlist',
      component: WishlistView,
    },
    {
      path: '/checkout',
      name: 'checkout',
      component: CheckoutView,
    },
    {
        path: '/payment-success',
        name: 'payment-success',
        component: PaymentSuccessView,
      },
      {
        path: '/payment-failed',
        name: 'payment-failed',
        component: PaymentFailedView,
      },
      {
        path: '/orders',
        name: 'orders',
        component: OrdersView,
      }
  ]
  
})

export default router