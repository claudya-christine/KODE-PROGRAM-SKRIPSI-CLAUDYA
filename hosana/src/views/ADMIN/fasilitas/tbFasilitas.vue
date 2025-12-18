<script setup>
import Sidebar from "../Sidebar.vue";
import { ref, onMounted, watch } from "vue";
import axios from "axios";
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

const fasilitas = ref([]);
const pagination = ref({});
const unitList = ref(["TK", "SD", "SMP", "SMK"]);
const selectedUnit = ref("");
const currentPage = ref(1);
const perPage = ref(5); 

const fetchData = async (page = 1) => {
  try {
    let url = `${API_BASE_URL}/api/v1/fasilitas?page=${page}`;
    if (selectedUnit.value) {
      url += `&unit=${selectedUnit.value}`;
    }

    const response = await axios.get(url);
    fasilitas.value = response.data.data; 
    pagination.value = {
      current_page: response.data.current_page,
      last_page: response.data.last_page,
      next_page_url: response.data.next_page_url,
      prev_page_url: response.data.prev_page_url,
      per_page: response.data.per_page, 
      total: response.data.total
    };
    perPage.value = response.data.per_page;
    currentPage.value = response.data.current_page;
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

watch(selectedUnit, () => {
  currentPage.value = 1;
  fetchData(1);
});

// Soft delete 
const deleteData = async (id) => {
  if (!confirm("Apakah Anda yakin ingin menghapus data ini?")) return;

  try {
    await axios.delete(`${API_BASE_URL}/api/v1/fasilitas/${id}`);
    alert("Data berhasil dihapus");
    fetchData(currentPage.value);
  } catch (error) {
    console.error("Error menghapus data:", error);
    alert("Gagal menghapus data. Periksa konsol untuk detail.");
  }
};

onMounted(() => {
  fetchData();
});
</script>

<template>
  <div class="flex">
    <Sidebar />

    <div class="w-screen p-6">
      <h2 class="text-left text-2xl font-bold mb-6">FASILITAS</h2>

      <!-- Tombol + Filter -->
      <div class="flex justify-between items-center mb-6">
        <router-link
          to="/createFasilitas"
          class="px-4 bg-blue-500 text-white text-sm py-3 rounded-lg hover:animate-pulse"
        >
          Tambah Data
        </router-link>

        <select
          v-model="selectedUnit"
          class="p-2 border rounded-lg"
        >
          <option value="">Semua Unit</option>
          <option v-for="unit in unitList" :key="unit" :value="unit">
            {{ unit }}
          </option>
        </select>
      </div>

      <!-- Table -->
      <div class="relative overflow-x-auto shadow-md">
        <table class="w-full text-sm text-left border-collapse border border-gray-400">
          <thead class="text-xs uppercase text-center">
            <tr>
              <th class="px-6 py-3 border border-gray-300">No</th>
              <th class="px-6 py-3 border border-gray-300">Nama Fasilitas</th>
              <th class="px-6 py-3 border border-gray-300">Deskripsi</th>
              <th class="px-6 py-3 border border-gray-300">Unit Pendidikan</th>
              <th class="px-6 py-3 border border-gray-300">Foto</th>
              <th class="px-6 py-3 border border-gray-300">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(item, index) in fasilitas"
              :key="item.id"
              class="border-b border-gray-200 hover:bg-gray-100"
            >
              <td class="px-4 text-center py-3 border border-gray-300">
                {{ (pagination.current_page - 1) * perPage + (index + 1) }}
              </td>
              <td class="px-4 text-center py-3 border border-gray-300">{{ item.namaFasilitas }}</td>
              <td class="px-4 text-center py-3 border border-gray-300">{{ item.deskripsi }}</td>
              <td class="px-4 text-center py-3 border border-gray-300">{{ item.unit?.pendidikan || '-' }}</td>
              <td class="px-4 py-3 text-center border border-gray-300">
                <img
                  v-if="item.image"
                  :src="`${API_BASE_URL}/storage/${item.image}`"
                  alt="Image"
                  class="w-40 h-24 object-cover rounded-lg mx-auto shadow"
                />
                <span v-else class="text-gray-400 italic">Tidak ada gambar</span>
              </td>
              <td class="px-4 text-center py-3">
                <router-link :to="'/editFasilitas/' + item.id">
                  <button class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600">
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

            <tr v-if="fasilitas.length === 0">
              <td colspan="5" class="text-center py-3 text-gray-500">Tidak ada data</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="flex justify-center items-center mt-5 gap-3">
        <button
          :disabled="!pagination.prev_page_url"
          @click="fetchData(pagination.current_page - 1)"
          class="px-3 py-1 rounded bg-gray-300 hover:bg-gray-400 disabled:opacity-50"
        >
          ‹ Prev
        </button>

        <span>Halaman {{ pagination.current_page }} dari {{ pagination.last_page }}</span>

        <button
          :disabled="!pagination.next_page_url"
          @click="fetchData(pagination.current_page + 1)"
          class="px-3 py-1 rounded bg-gray-300 hover:bg-gray-400 disabled:opacity-50"
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
