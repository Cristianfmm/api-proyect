<template>
  <div>
    <div class="mb-4">
      <input v-model="filters.name" placeholder="Buscar por nombre" class="border p-2 mr-2" />
      <input type="number" v-model.number="filters.priceRange[0]" placeholder="Precio mínimo" class="border p-2 mr-2" />
      <input type="number" v-model.number="filters.priceRange[1]" placeholder="Precio máximo" class="border p-2 mr-2" />
      <button @click="fetchProducts" class="bg-blue-500 text-white p-2 rounded">Filtrar</button>
    </div>

    <div v-if="products.length === 0">
      No se encontraron productos.
    </div>

    <ul v-else>
      <li v-for="product in products" :key="product.id" class="p-2 border-b">
        {{ product.name }} - ${{ product.price }}
      </li>
    </ul>
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
const products = computed(() => store.getters.products);
const filters = computed(() => store.getters.filters);

const fetchProducts = () => {
  store.dispatch('fetchProducts');
};

onMounted(() => {
  fetchProducts();
});
</script>