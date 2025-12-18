<script setup>
import Sidebar from "../Sidebar.vue";

</script>

<template>
  <div class="flex">
    <Sidebar />

    <div class="w-screen p-6">
      <h2 class="text-left text-2xl font-bold mb-6">Banner</h2>

      <div class="text-left mb-6">
        <router-link
          to="/createBanner"
          class="mb-6 px-4 bg-blue-500 text-white text-sm py-3 rounded-lg hover:animate-pulse"
        >
          Tambah Banner
        </router-link>
      </div>

      <div class="relative overflow-x-auto shadow-md">
        <table class="w-full text-sm text-left rtl:text-right border-collapse border border-gray-400">
          <thead class="text-xs uppercase text-center">
            <tr>
              <th scope="col" class="px-6 py-3 border border-gray-300">No</th>
              <th scope="col" class="px-6 py-3 border border-gray-300">Banner</th>
              <th scope="col" class="px-6 py-3 border border-gray-300">Aksi</th>
            </tr>
          </thead>

          <tbody>
            <tr
              v-for="(item, index) in banners"
              :key="item.id"
              class="bg-white border-b border-gray-200 hover:bg-gray-100"
            >
              <td class="px-4 text-center py-3 border border-gray-300">
                {{ (currentPage - 1) * perPage + index + 1 }}
              </td>

              <td class="px-4 py-3 text-center border border-gray-300">
                <img
                  v-if="item.banner"
                  :src="`${API_BASE_URL}/storage/${item.banner}`"
                  alt="Banner"
                  class="w-40 h-24 object-cover rounded-lg mx-auto shadow"
                />
                <span v-else class="text-gray-400 italic">Tidak ada gambar</span>
              </td>

              <td class="px-4 text-center py-3">
                <router-link :to="'/editBanner/' + item.id">
                  <button
                    class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600"
                  >
                    Edit
                  </button>
                </router-link>

                <button
                  @click="deleteData(item.id)"
                  class="ml-2 bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600"
                >
                  Hapus
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="flex justify-center mt-4 space-x-2">
        <button
          :disabled="!prevPageUrl"
          @click="changePage(currentPage - 1)"
          class="px-3 cursor-pointer py-1 bg-gray-200 rounded disabled:opacity-50"
        >
          ‹ Prev
        </button>
        <span class="px-2  text-gray-700">Halaman {{ currentPage }} dari {{ lastPage }}</span>
        <button
          :disabled="!nextPageUrl"
          @click="changePage(currentPage + 1)"
          class="px-3 py-1 cursor-pointer bg-gray-200 rounded disabled:opacity-50"
        >
          Next ›
        </button>
      </div>
    </div>
  </div>

  <footer class="text-center text-white bg-(--primary) py-3 text-sm">
    © 2025 Yayasan Hosana Tebas. All Rights Reserved.
  </footer>
</template>

<script>
import axios from "axios";


export default {
  data() {
    return {
      API_BASE_URL: import.meta.env.VITE_API_BASE_URL,
      banners: [],
      currentPage: 1,
      lastPage: 1,
      nextPageUrl: null,
      prevPageUrl: null,
      perPage: 5,
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    async fetchData(page = 1) {
      try {
        const response = await axios.get(
          `${this.API_BASE_URL}/api/v1/banner?page=${page}`
        );
        this.banners = response.data.data;
        this.currentPage = response.data.current_page;
        this.lastPage = response.data.last_page;
        this.nextPageUrl = response.data.next_page_url;
        this.prevPageUrl = response.data.prev_page_url;
      } catch (error) {
        console.error("Error fetching banner data:", error);
      }
    },
    async deleteData(id) {
      if (confirm("Apakah Anda yakin ingin menghapus banner ini?")) {
        try {
          await axios.delete(`${this.API_BASE_URL}/api/v1/banner/${id}`);
          this.fetchData(this.currentPage);
        } catch (error) {
          console.error("Error deleting banner:", error);
        }
      }
    },
    changePage(page) {
      if (page > 0 && page <= this.lastPage) {
        this.fetchData(page);
      }
    },
  },
};

</script>

<style scoped>
</style>
