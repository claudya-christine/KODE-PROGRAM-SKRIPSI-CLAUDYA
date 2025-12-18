<script setup>
import Sidebar from "../Sidebar.vue";
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

</script>

<template>
    <div class="flex">
      <Sidebar />
  <div class="mx-auto my-10 w-screen bg-white p-6 shadow-lg border-1 border-(--primary) rounded-lg text-left max-w-xl">
    <h2 class="text-2xl font-bold mb-4">Edit Banner</h2>

    <form @submit.prevent="updateBanner">
      <!-- Upload Banner -->
      <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">Ganti Banner (Opsional)</label>
        <input
          type="file"
          @change="handleFileUpload"
          accept="image/*"
          class="w-full p-2 border rounded-lg"
        />
      </div>

      <!-- Preview -->
      <div class="mb-4">
        <p class="text-gray-700 font-medium mb-2">Preview:</p>

        <!-- Jika user upload baru -->
        <img
          v-if="previewImage"
          :src="previewImage"
          alt="Preview Banner"
          class="w-full h-48 object-cover rounded-lg border"
        />

        <!-- Jika belum upload baru, tampilkan banner lama -->
        <img
          v-else-if="currentBanner"
          :src="`${API_BASE_URL}/storage/${currentBanner}`"
          alt="Current Banner"
          class="w-full h-48 object-cover rounded-lg border"
        />

        <span v-else class="text-gray-400 italic">Tidak ada gambar</span>
      </div>

      <!-- Tombol -->
      <div class="mt-6">
        <button
          type="submit"
          class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
        >
          Simpan Perubahan
        </button>

        <router-link to="/tbBanner" class="ml-4 text-gray-500 hover:underline">
          Batal
        </router-link>
      </div>
    </form>
  </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      API_BASE_URL: import.meta.env.VITE_API_BASE_URL, // <-- pindahkan sini
      bannerId: null,
      currentBanner: null,
      bannerFile: null,
      previewImage: null,
    };
  },
  mounted() {
    this.fetchBannerDetail();
  },
  methods: {
    async fetchBannerDetail() {
      this.bannerId = this.$route.params.id;

      try {
        const response = await axios.get(
          `${this.API_BASE_URL}/api/v1/banner/${this.bannerId}`
        );
        this.currentBanner = response.data.banner;
      } catch (error) {
        console.error("Error fetching banner detail:", error);
        alert("Gagal memuat data banner.");
      }
    },

    handleFileUpload(event) {
      const file = event.target.files[0];
      this.bannerFile = file;

      if (file) {
        this.previewImage = URL.createObjectURL(file);
      }
    },

    async updateBanner() {
      try {
        const formData = new FormData();

        if (this.bannerFile) {
          formData.append("banner", this.bannerFile);
        }

        await axios.post(
          `${this.API_BASE_URL}/api/v1/banner/${this.bannerId}?_method=PUT`,
          formData,
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        );

        alert("Banner berhasil diperbarui!");
        this.$router.push("/tbBanner");
      } catch (error) {
        console.error("Error updating banner:", error);
        alert("Gagal memperbarui banner. Coba lagi nanti.");
      }
    },
  },
};

</script>

<style scoped>
</style>
