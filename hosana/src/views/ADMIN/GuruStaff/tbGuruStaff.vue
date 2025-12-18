<script setup>
import Sidebar from "../Sidebar.vue";
import { ref, onMounted, watch } from "vue";
import axios from "axios";
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;


const gurustaff = ref([]);
const unitList = ref(["TK", "SD", "SMP", "SMK"]);
const selectedUnit = ref("");

const currentPage = ref(1);
const lastPage = ref(1);

const fetchData = async (page = 1) => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/v1/gurustaff`, {
      params: {
        page: page,
        unit: selectedUnit.value || undefined,
      },
    });

    gurustaff.value = response.data.data;
    currentPage.value = response.data.current_page;
    lastPage.value = response.data.last_page;

  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

const formatTanggal = (tanggal) => {
  if (!tanggal) return "-";
  const date = new Date(tanggal);
  return date.toLocaleDateString("id-ID", {
    day: "2-digit",
    month: "long",
    year: "numeric",
  });
};

const deleteData = async (staffID) => {
  if (!confirm("Apakah kamu yakin ingin menghapus data ini?")) return;

  try {
    await axios.delete(`${API_BASE_URL}/api/v1/gurustaff/${staffID}`);
    alert("Data berhasil dihapus");
    fetchData(currentPage.value); 
  } catch (error) {
    console.error("Error menghapus data:", error);
    alert("Gagal menghapus data. Periksa konsol untuk detail.");
  }
};

watch(selectedUnit, () => {
  fetchData(1);
});

onMounted(() => {
  fetchData();
});
</script>

<template>
  <div class="flex">
    <Sidebar />

    <div class="w-screen p-6">
      <h2 class="text-left text-2xl font-bold mb-6">DATA GURU DAN STAFF</h2>

      <div class="flex justify-between items-center mb-6">
        <router-link
          to="/createGuruStaff"
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

      <div class="relative overflow-x-auto shadow-md">
        <table class="w-full text-sm text-left border-collapse border border-gray-400">
          <thead class="text-xs uppercase text-center">
            <tr>
              <th class="px-6 py-3 border border-gray-300">No</th>
              <th class="px-6 py-3 border border-gray-300">ID Staff</th>
              <th class="px-6 py-3 border border-gray-300">Nama Lengkap</th>
              <th class="px-6 py-3 border border-gray-300">Tanggal Lahir</th>
              <th class="px-6 py-3 border border-gray-300">Posisi</th>
              <th class="px-6 py-3 border border-gray-300">Unit Pendidikan</th>
              <th class="px-6 py-3 border border-gray-300">Foto</th>
              <th class="px-6 py-3 border border-gray-300">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(item, index) in gurustaff"
              :key="item.id"
              class="border-b border-gray-200 hover:bg-gray-100"
            >
              <td class="px-4 text-center py-3 border border-gray-300">
                {{ (currentPage - 1) * 5 + index + 1 }}
              </td>
              <td class="px-4 text-center py-3 border border-gray-300">{{ item.staffID }}</td>
              <td class="px-4 text-center py-3 border border-gray-300">{{ item.namalengkap }}</td>
              <td class="px-4 text-center py-3 border border-gray-300">{{ formatTanggal(item.tanggal_lahir) }}</td>
              <td class="px-4 text-center py-3 border border-gray-300">{{ item.posisi }}</td>
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
                <router-link :to="'/editGuruStaff/' + item.staffID">
                  <button class="bg-yellow-500 text-white px-3 py-1 mb-1 rounded-lg hover:bg-yellow-600">
                    Edit
                  </button>
                </router-link>
                <button
                  @click="deleteData(item.staffID)"
                  class="ml-2 bg-red-500 text-white px-3 py-1 mb-1 rounded-lg hover:bg-red-600"
                >
                  Hapus
                </button>
              </td>
            </tr>

            <tr v-if="gurustaff.length === 0">
              <td colspan="8" class="text-center py-3 text-gray-500">Tidak ada data</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- PAGINATION -->
      <div class="flex justify-center items-center mt-6 space-x-2">
        <button
          @click="fetchData(currentPage - 1)"
          :disabled="currentPage === 1"
          class="px-4 py-2 cursor-pointer bg-gray-300 rounded-lg hover:bg-gray-400 disabled:opacity-50"
        >
          ‹ Prev
        </button>

        <span>Halaman {{ currentPage }} dari {{ lastPage }}</span>

        <button
          @click="fetchData(currentPage + 1)"
          :disabled="currentPage === lastPage"
          class="px-4 py-2 cursor-pointer bg-gray-300 rounded-lg hover:bg-gray-400 disabled:opacity-50"
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
