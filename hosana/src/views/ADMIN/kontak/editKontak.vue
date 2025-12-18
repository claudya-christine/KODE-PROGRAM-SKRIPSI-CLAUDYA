<script setup>
import Sidebar from "../Sidebar.vue";
import axios from "axios";
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

const route = useRoute();
const router = useRouter();

const kontakId = ref(route.params.id);

const kontak = ref({
  noTelp: "",
  alamat: "",
  email: "",
});

const fetchKontakDetail = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/v1/kontak/${kontakId.value}`);
    kontak.value = response.data;
  } catch (error) {
    console.error("Error fetching detail:", error);
    alert("Gagal memuat data kontak.");
  }
};

const updateKontak = async () => {
  try {
    await axios.put(`${API_BASE_URL}/api/v1/kontak/${kontakId.value}`, kontak.value);
    alert("Data berhasil diperbarui!");
    router.push("/tbKontak");
  } catch (error) {
    console.error("Error updating data:", error);
    alert("Gagal memperbarui data. Coba lagi nanti.");
  }
};

onMounted(() => {
  fetchKontakDetail();
});
</script>

<template>
  <div class="flex">
    <Sidebar />

    <div class="mx-auto my-10 w-screen bg-white p-6 shadow-lg border border-gray-300 rounded-lg text-left max-w-xl">
      <h2 class="text-2xl font-bold mb-4">Edit Kontak</h2>

      <form @submit.prevent="updateKontak">
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Nomor Telepon</label>
          <input
            type="text"
            v-model="kontak.noTelp"
            class="w-full p-2 border rounded-lg"
            placeholder="Masukkan Nomor Telepon"
            required
          />
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Alamat</label>
          <input
            type="text"
            v-model="kontak.alamat"
            class="w-full p-2 border rounded-lg"
            placeholder="Masukkan Alamat"
            required
          />
        </div>
        
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Email</label>
          <input
            type="email"
            v-model="kontak.email"
            class="w-full p-2 border rounded-lg"
            placeholder="Masukkan Email"
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
            to="/tbKontak"
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
