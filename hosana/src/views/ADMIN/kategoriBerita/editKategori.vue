<script setup>
import Sidebar from "../Sidebar.vue";
import axios from "axios";
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

const route = useRoute();
const router = useRouter();

const kategoriId = ref(route.params.id);

const kategori = ref({
  noTelp: "",
  alamat: "",
  email: "",
});

const fetchKategoriDetail = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/v1/kategori/${kategoriId.value}`);
    kategori.value = response.data;
  } catch (error) {
    console.error("Error fetching detail:", error);
    alert("Gagal memuat data.");
  }
};

const updateKategori = async () => {
  try {
    await axios.put(`${API_BASE_URL}/api/v1/kategori/${kategoriId.value}`, kategori.value);
    alert("Data berhasil diperbarui!");
    router.push("/tbKategori");
  } catch (error) {
    console.error("Error updating data:", error);
    alert("Gagal memperbarui data. Coba lagi nanti.");
  }
};

onMounted(() => {
  fetchKategoriDetail();
});
</script>

<template>
  <div class="flex">
    <Sidebar />

    <div class="mx-auto my-10 w-screen bg-white p-6 shadow-lg border border-gray-300 rounded-lg text-left max-w-xl">
      <h2 class="text-2xl font-bold mb-4">Edit Kategori</h2>

      <form @submit.prevent="updateKategori">
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Nama Kategori</label>
          <input
            type="text"
            v-model="kategori.nama_kategori"
            class="w-full p-2 border rounded-lg"
            placeholder="Masukkan Nama Kategori"
            required
          />
        </div>

        <div class="mt-6">
          <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
          >
            Simpan Perubahan
          </button>

          <router-link
            to="/tbKategori"
            class="ml-4 text-gray-500 hover:underline"
          >
            Batal
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
</style>
