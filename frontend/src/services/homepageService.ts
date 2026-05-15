import { api } from './api'

export const homepageService = {
  getBooks() {
    return api.get('/books')
  },
}