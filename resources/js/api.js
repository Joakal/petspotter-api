import axios from 'axios'
export default axios.create({
  baseURL: 'https://petspotter.joakal.com/api',
  timeout: 5000,
  headers: {
    'Content-Type': 'application/json'
  }
})