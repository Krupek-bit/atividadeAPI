<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
  headers: { Accept: 'application/json' }
})

const produtos = ref([])
const form = ref({ nome: '', descricao: '', preco: 0, estoque: 0 })
const erro = ref('')

async function carregar() {
  const { data } = await api.get('/produtos')
  produtos.value = data.data
}

async function salvar() {
  try {
    erro.value = ''
    await api.post('/produtos', form.value)
    form.value = { nome: '', descricao: '', preco: 0, estoque: 0 }
    await carregar()
  } catch (e) {
    erro.value = e.response?.data?.message || 'Erro ao salvar'
  }
}

async function remover(id) {
  await api.delete(`/produtos/${id}`)
  await carregar()
}

onMounted(carregar)
</script>

<template>
  <main style="max-width: 600px; margin: 2rem auto; font-family: sans-serif">
    <h1>Produtos</h1>

    <form @submit.prevent="salvar">
      <input v-model="form.nome" placeholder="Nome" required />
      <input v-model="form.descricao" placeholder="Descrição" />
      <input v-model.number="form.preco" type="number" step="0.01" placeholder="Preço" />
      <input v-model.number="form.estoque" type="number" placeholder="Estoque" />
      <button>Adicionar</button>
      <p v-if="erro" style="color: red">{{ erro }}</p>
    </form>

    <ul>
      <li v-for="p in produtos" :key="p.id">
        {{ p.nome }}: R$ {{ p.preco.toFixed(2) }} ({{ p.estoque }} un.)
        <button @click="remover(p.id)">Excluir</button>
      </li>
    </ul>
  </main>
</template>
