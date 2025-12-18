<script setup>
import Sidebar from "../Sidebar.vue";

</script>

<template>
  <div class="flex">
      <Sidebar />

  <div class="  w-screen p-6">
    <h2 class="text-left text-2xl font-bold mb-6">STATISTIK HOSANA</h2>

    <div class="relative overflow-x-auto shadow-md ">
      <table class="w-full text-sm text-left rtl:text-right border-collapse border border-gray-400 ">
        <thead class="text-xs  uppercase  text-center">
          <tr>
            <th scope="col" class="px-6 py-3 border border-gray-300">No</th>
            <th scope="col" class="px-6 py-3 border border-gray-300">Total Alumni</th>
            <th scope="col" class="px-6 py-3 border border-gray-300">Total Siswa</th>
            <th scope="col" class="px-6 py-3 border border-gray-300">Total Guru</th>
            <th scope="col" class="px-6 py-3 border border-gray-300">Aksi</th>
          </tr>
        </thead>

          <tbody v-if="statistic">
            <tr class=" border-b border-gray-200 hover:bg-gray-100">
                <td class="px-4 text-center py-3 border border-gray-300">1</td>
                <td class="px-4 text-center py-3 border  border-gray-300">{{ statistic.total_alumni }}</td>
                <td class="px-4 text-center py-3 border border-gray-300">{{ statistic.total_siswa }}</td>
                <td class="px-4 text-center py-3 border border-gray-300">{{ statistic.total_guru_staff }}</td>
                <td class="px-4 text-center py-3">
      <router-link :to="'/editStatistic/' + statistic.id">
        <button class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600">
          Edit
        </button>
      </router-link>
    </td>
  </tr>
</tbody>



        
      </table>
    </div>
  </div>
  </div>
  
      <footer class="text-center text-white bg-(--primary) py-3 text-sm">
© 2025 Yayasan Hosana Tebas. All Rights Reserved.
</footer>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      statistic: null,
      API_BASE_URL: import.meta.env.VITE_API_BASE_URL,
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    async fetchData() {
      try {
        const response = await axios.get(`${this.API_BASE_URL}/api/v1/statistic`);
        this.statistic = response.data;
        console.log("Data dari API:", this.statistic);
      } catch (error) {
        console.error("Error fetching statistic data:", error);
      }
    },
  },
};
</script>



<style scoped>
</style>
