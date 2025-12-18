<script setup>
import Sidebar from "../Sidebar.vue";
import { ref } from "vue";
import axios from "axios";
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;
import { useRouter } from 'vue-router';
const router = useRouter();
const nama_kategori = ref(""); 

const addKategori = async () => {
  if (!nama_kategori.value) {
    alert("Nama kategori harus diisi!");
    return;
  }

  try {
    await axios.post(`${API_BASE_URL}/api/v1/kategori`, {
      nama_kategori: nama_kategori.value
    });

    alert("Data berhasil ditambahkan!");
    router.push('/tbKategori');
  } catch (error) {
    console.error("Error menambahkan data:", error);
    alert("Gagal menambahkan data.");
  }
};
</script>

<template>
  <div class="flex">
    <Sidebar />
    <div class="mx-auto my-10 w-screen bg-white p-6 shadow-lg border border-gray-300 rounded-lg text-left max-w-xl">
      <h2 class="text-2xl font-bold mb-4">Tambah Kategori</h2>

      <form @submit.prevent="addKategori">
        <!-- Nama Kategori -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Nama Kategori</label>
          <input
            type="text"
            v-model="nama_kategori"
            class="w-full p-2 border rounded-lg"
            placeholder="Masukkan nama kategori"
            required
          />
        </div>

        <!-- Tombol -->
        <div class="mt-6">
          <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
          >
            Tambah
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
