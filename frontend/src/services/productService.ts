import { api } from './api'

export const productService = {
  getProducts() {
    return api.get('/books')
  },

  getProductById(id: string | number) {
    return api.get(`/books/${id}`)
  },
}