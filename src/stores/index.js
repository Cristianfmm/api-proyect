import { createStore } from 'vuex';
import axios from 'axios';

const store = createStore({
  state: {
    products: [],
    filters: {
      name: '',
      priceRange: [0, 1000],
      category: '',
    },
    currentPage: 1,
  },
  mutations: {
    setProducts(state, products) {
      state.products = products;
    },
    setFilters(state, filters) {
      state.filters = filters;
    },
    setCurrentPage(state, page) {
      state.currentPage = page;
    },
  },
  actions: {
    async fetchProducts({ commit, state }) {
      try {
        const response = await axios.get('http://localhost/api-productos/public/api/products', {
          params: {
            name: state.filters.name,
            minPrice: state.filters.priceRange[0],
            maxPrice: state.filters.priceRange[1],
            category: state.filters.category,
            page: state.currentPage,
          },
        });
        commit('setProducts', response.data.data);
      } catch (error) {
        console.error('Error fetching products:', error);
      }
    },
  },
  getters: {
    products: (state) => state.products,
    filters: (state) => state.filters,
    currentPage: (state) => state.currentPage,
  },
});

export default store;
