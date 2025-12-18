<script setup>
import Sidebar from "../Sidebar.vue";
</script>

<template>
  <div class="flex">
    <Sidebar />

    <div
      class="mx-auto my-10 w-screen bg-white p-6 shadow-lg border border-(--primary) rounded-lg text-left max-w-xl"
    >
      <h2 class="text-2xl font-bold mb-4">Edit Statistik</h2>

      <form @submit.prevent="updateStatistic">
        <!-- Total Siswa -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Total Siswa</label>
          <input
            type="number"
            v-model="statistic.total_siswa"
            class="w-full p-2 border rounded-lg"
            placeholder="Masukkan total siswa"
            min="0"
            required
          />
        </div>

        <!-- Total Alumni -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Total Alumni</label>
          <input
            type="number"
            v-model="statistic.total_alumni"
            class="w-full p-2 border rounded-lg"
            placeholder="Masukkan total alumni"
            min="0"
            required
          />
        </div>

        <!-- Tombol -->
        <div class="mt-6">
          <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
          >
            Simpan Perubahan
          </button>

          <router-link to="/tbStatistic" class="ml-4 text-gray-500 hover:underline">
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
      statisticId: null,
      statistic: {
        total_siswa: "",
        total_alumni: "",
      },
      API_BASE_URL: import.meta.env.VITE_API_BASE_URL, 
    };
  },
  mounted() {
    this.fetchStatisticDetail();
  },
  methods: {
    async fetchStatisticDetail() {
      this.statisticId = this.$route.params.id;

      try {
        const response = await axios.get(
          `${this.API_BASE_URL}/api/v1/statistic/${this.statisticId}`
        );

        this.statistic = response.data;
      } catch (error) {
        console.error("Error fetching statistic detail:", error);
        alert("Gagal memuat data statistik.");
      }
    },

    async updateStatistic() {
      try {
        await axios.put(
          `${this.API_BASE_URL}/api/v1/statistic/${this.statisticId}`,
          this.statistic
        );

        alert("Data statistik berhasil diperbarui!");
        this.$router.push("/tbStatistic");
      } catch (error) {
        console.error("Error updating statistic:", error);
        alert("Gagal memperbarui data. Coba lagi nanti.");
      }
    },
  },
};
</script>


<style scoped>
</style>
