<script setup>
import { ref, onMounted } from "vue";
import axios from "@/axios";
import logo from '@/assets/logo.svg'
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

const beritas = ref([]);
const currentPage = ref(1);
const lastPage = ref(1);
const nextPageUrl = ref(null);
const prevPageUrl = ref(null);
const perPage = 6;

const fetchBeritas = async (page = 1) => {
  try {
    const res = await axios.get(`/v1/berita-dengan-komentar?page=${page}`);
    beritas.value = res.data.data;          
    currentPage.value = res.data.current_page;
    lastPage.value = res.data.last_page;
    nextPageUrl.value = res.data.next_page_url;
    prevPageUrl.value = res.data.prev_page_url;
  } catch (err) {
    console.error("Gagal ambil berita:", err);
  }
};

onMounted(() => {
  fetchBeritas();
});

const changePage = (page) => {
  if (page > 0 && page <= lastPage.value) {
    fetchBeritas(page);
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
</script>

<template>
  <main class="flex-1 p-8 relative">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Tanggapan Berita</h2>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
      <div v-for="berita in beritas" :key="berita.id" class="max-w-sm bg-white rounded-lg shadow p-4 z-10 relative">
        <div class="grid grid-cols-1 gap-2">
          <img
            v-if="berita.media && berita.media.length"
            :src="`${API_BASE_URL}/storage/${berita.media[0].file_path}`"
            alt="Thumbnail Berita"
            class="w-full h-32 object-cover rounded"
          />
        </div>

        <h2 class="font-semibold mt-2">{{ berita.judul }}</h2>
        <!-- <p class="mt-2 text-gray-700 text-sm">{{ berita.isi.slice(0, 100) }}...</p> -->

        <div class="mt-4 flex justify-between text-xs text-gray-500">
          <span>{{ berita.kategoris ? berita.kategoris.map(k => k.nama_kategori).join(', ') : '-' }}</span>
          <router-link :to="`/tanggapanDetail/${berita.id}`">
            <span class="underline cursor-pointer">{{ berita.komentar ? berita.komentar.length : 0 }} Komentar</span>
          </router-link>
        </div>
      </div>

      <!-- Watermark Logo -->
      <div class="absolute inset-0 flex justify-center items-center opacity-10 pointer-events-none">
        <img :src="logo" alt="Logo" class="w-64 h-64" />
      </div>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center mt-4 space-x-2">
      <button
        :disabled="!prevPageUrl"
        @click="changePage(currentPage - 1)"
        class="px-3 py-1 bg-gray-200 rounded cursor-pointer disabled:opacity-50"
      >
        ‹ Prev
      </button>
      <span class="px-2 text-gray-700">Halaman {{ currentPage }} dari {{ lastPage }}</span>
      <button
        :disabled="!nextPageUrl"
        @click="changePage(currentPage + 1)"
        class="px-3 py-1 bg-gray-200 rounded cursor-pointer disabled:opacity-50"
      >
        Next ›
      </button>
    </div>
  </main>
</template>
