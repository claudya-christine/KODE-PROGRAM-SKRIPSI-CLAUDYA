<script setup>
import Sidebar from "../Sidebar.vue";
import axios from "axios";
import { ref, onMounted } from "vue";

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

const beritas = ref([]);
const currentPage = ref(1);
const lastPage = ref(1);
const nextPageUrl = ref(null);
const prevPageUrl = ref(null);
const perPage = ref(5);

const searchQuery = ref("");

const searchData = async () => {
  try {
    const response = await axios.get(
      `${API_BASE_URL}/api/v1/berita?search=${searchQuery.value}`
    );
    beritas.value = response.data.data;
    currentPage.value = response.data.current_page;
    lastPage.value = response.data.last_page;
    nextPageUrl.value = response.data.next_page_url;
    prevPageUrl.value = response.data.prev_page_url;
  } catch (error) {
    console.error("Error searching berita:", error);
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

const fetchData = async (page = 1) => {
  try {
    const response = await axios.get(
      `${API_BASE_URL}/api/v1/berita?page=${page}&search=${searchQuery.value}`
    );
    beritas.value = response.data.data;
    currentPage.value = response.data.current_page;
    lastPage.value = response.data.last_page;
    nextPageUrl.value = response.data.next_page_url;
    prevPageUrl.value = response.data.prev_page_url;
  } catch (error) {
    console.error("Error fetching berita:", error);
  }
};

const deleteData = async (id) => {
  if (confirm("Apakah Anda yakin ingin menghapus berita ini?")) {
    try {
      await axios.delete(`${API_BASE_URL}/api/v1/berita/${id}`);
      fetchData(currentPage.value);
    } catch (error) {
      console.error("Error deleting berita:", error);
    }
  }
};

const changePage = (page) => {
  if (page > 0 && page <= lastPage.value) {
    fetchData(page);
  }
};

onMounted(() => {
  fetchData();
});

const downloadPDF = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/v1/berita/pdf`, {
      responseType: "blob", // wajib untuk file PDF
    });

    const blob = new Blob([response.data], { type: "application/pdf" });
    const url = window.URL.createObjectURL(blob);

    const link = document.createElement("a");
    link.href = url;
    link.download = "Daftar_Berita.pdf";
    link.click();

    window.URL.revokeObjectURL(url);
  } catch (error) {
    console.error("Gagal mendownload PDF:", error);
  }
};

</script>





<template>
  <div class="flex">
    <Sidebar />

    <div class="w-screen p-6">
      <h2 class="text-left text-2xl font-bold mb-6">BERITA</h2>

      <div class="text-left mb-6">
        <router-link
          to="/createBerita"
          class="mb-6 px-4 bg-blue-500 cursor-pointer text-white text-sm py-3 rounded-lg hover:animate-pulse"
        >
          Tambah Berita
        </router-link>
      <button
        @click="downloadPDF"
        class="px-4 bg-red-600 ml-3 text-white cursor-pointer text-sm py-3 rounded-lg hover:animate-pulse"
      >
        Download PDF
      </button>
      </div>

      <div class="mb-4 flex">
  <input
    v-model="searchQuery"
    @input="searchData"
    type="text"
    placeholder="Cari judul berita..."
    class="border border-gray-400 px-3 py-2 rounded-lg w-64"
  />

  <button
    @click="searchData"
    class="ml-3 px-4 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700"
  >
    Cari
  </button>
</div>


      <div class="relative overflow-x-auto shadow-md">
        <table class="w-full text-sm text-left rtl:text-right border-collapse border border-gray-400">
          <thead class="text-xs uppercase text-center">
            <tr>
              <th scope="col" class="px-6 py-3 border border-gray-300">No</th>
              <th scope="col" class="px-6 py-3 border border-gray-300">Judul Berita</th>
              <th scope="col" class="px-6 py-3 border border-gray-300">Isi Berita</th>
              <th scope="col" class="px-6 py-3 border border-gray-300">Tanggal</th>
              <th scope="col" class="px-6 py-3 border border-gray-300">Kategori</th>
              <th scope="col" class="px-6 py-3 border border-gray-300">Aksi</th>
            </tr>
          </thead>
 
          <tbody>
            <tr
              v-for="(item, index) in beritas"
              :key="item.id"
              class="bg-white border-b border-gray-200 hover:bg-gray-100"
            >
              <td class="px-4 text-center py-3 border border-gray-300">
                {{ (currentPage - 1) * perPage + index + 1 }}
              </td>

              <td class="px-4 text-center py-3 border border-gray-300">{{ item.judul }}</td>
              <td class="px-4 text-center py-3 border border-gray-300"> {{ item.isi.slice(0, 100) }} ...</td>
              <td class="px-4 text-center py-3 border border-gray-300">{{ formatTanggal(item.tanggal_berita) }}</td>
              <td class="px-4 text-center py-3 border border-gray-300">
            {{ item.kategoris && item.kategoris.length > 0 ? item.kategoris.map(k => k.nama_kategori).join(', ') : '-' }}
              </td>

              <td class="px-4 text-center py-3">
                <router-link :to="'/editBerita/' + item.id">
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
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="flex justify-center mt-4 space-x-2">
        <button
          :disabled="!prevPageUrl"
          @click="changePage(currentPage - 1)"
          class="px-3 py-1 bg-gray-200 rounded disabled:opacity-50"
        >
          ‹ Prev
        </button>
        <span class="px-2 text-gray-700">Halaman {{ currentPage }} dari {{ lastPage }}</span>
        <button
          :disabled="!nextPageUrl"
          @click="changePage(currentPage + 1)"
          class="px-3 py-1 bg-gray-200 rounded disabled:opacity-50"
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


