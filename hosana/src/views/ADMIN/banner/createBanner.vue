<script setup>
import Sidebar from "../Sidebar.vue";

</script>

<template>
      <div class="flex ">
      <Sidebar />
  <div class="mx-auto my-10 w-screen bg-white p-6 shadow-lg border-1 border-(--primary) rounded-lg text-left max-w-xl">
    <h2 class="text-2xl font-bold mb-4">Tambah Banner</h2>

    <form @submit.prevent="addBanner">
      <!-- Upload Banner -->
      <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">Upload Banner</label>
        <input
          type="file"
          @change="handleFileUpload"
          accept="image/*"
          class="w-full p-2 border rounded-lg"
          required
        />
      </div>

      <!-- Preview -->
      <div v-if="previewImage" class="mb-4">
        <p class="text-gray-700 font-medium mb-2">Preview:</p>
        <img
          :src="previewImage"
          alt="Preview Banner"
          class="w-full h-48 object-cover rounded-lg border"
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
          to="/tbBanner"
          class="ml-4 text-gray-500 hover:underline"
        >
          Batal
        </router-link>
      </div>
    </form>
  </div>
  </div>
</template>

<script>
import axios from "axios";

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL; // <-- bisa di sini

export default {
  data() {
    return {
      bannerFile: null,
      previewImage: null,
    };
  },
  methods: {
    handleFileUpload(event) {
      const file = event.target.files[0];
      this.bannerFile = file;

      if (file) {
        this.previewImage = URL.createObjectURL(file);
      }
    },

    async addBanner() {
      if (!this.bannerFile) {
        alert("Silakan pilih file banner terlebih dahulu!");
        return;
      }

      try {
        const formData = new FormData();
        formData.append("banner", this.bannerFile);

        await axios.post(`${API_BASE_URL}/api/v1/banner`, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });

        alert("Banner berhasil ditambahkan!");
        this.$router.push("/tbBanner");
      } catch (error) {
        console.error("Error uploading banner:", error);
        alert("Gagal menambahkan banner. Periksa konsol untuk detail.");
      }
    },
  },
};
</script>


<style scoped>
</style>
