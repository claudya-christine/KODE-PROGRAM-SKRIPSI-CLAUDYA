<script setup>
import Sidebar from "../Sidebar.vue";
import { ref, onMounted } from "vue";
import axios from "axios";

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

const kategoris = ref([]);
const currentPage = ref(1);
const lastPage = ref(1);
const nextPageUrl = ref(null);
const prevPageUrl = ref(null);
const perPage = ref(5);

const fetchData = async (page = 1) => {
  try {
    const res = await axios.get(`${API_BASE_URL}/api/v1/kategori?page=${page}`);
    console.log("Response API:", res.data);
    kategoris.value = Array.isArray(res.data.data) ? res.data.data : res.data;
    currentPage.value = res.data.current_page || 1;
    lastPage.value = res.data.last_page || 1;
    nextPageUrl.value = res.data.next_page_url || null;
    prevPageUrl.value = res.data.prev_page_url || null;
  } catch (err) {
    console.error("Error fetching kategori data:", err);
  }
};

const deleteData = async (id) => {
  if (confirm("Apakah Anda yakin ingin menghapus kategori ini?")) {
    try {
      await axios.delete(`${API_BASE_URL}/api/v1/kategori/${id}`);
      fetchData(currentPage.value);
    } catch (err) {
      console.error("Error deleting kategori:", err);
    }
  }
};

const changePage = (page) => {
  if (page > 0 && page <= lastPage.value) fetchData(page);
};

onMounted(() => {
  fetchData();
});
</script>


<template>
  <div class="flex">
    <Sidebar />

    <div class="w-screen p-6">
      <h2 class="text-left text-2xl font-bold mb-6">KATEGORI BERITA</h2>

      <div class="text-left mb-6">
        <router-link
          to="/createKategori"
          class="mb-6 px-4 bg-blue-500 text-white text-sm py-3 rounded-lg hover:animate-pulse"
        >
          Tambah Kategori
        </router-link>
      </div>

      <div class="relative overflow-x-auto shadow-md">
        <table class="w-full text-sm text-left rtl:text-right border-collapse border border-gray-400">
          <thead class="text-xs uppercase text-center">
            <tr>
              <th scope="col" class="px-6 py-3 border border-gray-300">No</th>
              <th scope="col" class="px-6 py-3 border border-gray-300">Nama Kategori</th>
              <th scope="col" class="px-6 py-3 border border-gray-300">Aksi</th>
            </tr>
          </thead>

          <tbody>
            <tr
              v-for="(item, index) in kategoris"
              :key="item.id"
              class="bg-white border-b border-gray-200 hover:bg-gray-100"
            >
              <td class="px-4 text-center py-3 border border-gray-300">
                {{ (currentPage - 1) * perPage + index + 1 }}
              </td>
              <td class="px-4 text-center py-3 border border-gray-300">{{ item.nama_kategori }}</td>
              <td class="px-4 text-center py-3">
                <router-link :to="'/editKategori/' + item.id">
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


    </div>
  </div>

  <footer class="text-center text-white bg-(--primary) py-3 text-sm">
    © 2025 Yayasan Hosana Tebas. All Rights Reserved.
  </footer>
</template>


<style scoped>
</style>
