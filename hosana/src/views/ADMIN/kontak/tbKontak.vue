<script setup>
import Sidebar from "../Sidebar.vue";
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

</script>


<template>
  <div class="flex">
      <Sidebar />

  <div class="  w-screen p-6">
    <h2 class="text-left text-2xl font-bold mb-6">KONTAK YAYASAN HOSANA</h2>

    <div class="relative overflow-x-auto shadow-md ">
      <table class="w-full text-sm text-left rtl:text-right border-collapse border border-gray-400 ">
        <thead class="text-xs  uppercase  text-center">
          <tr>
            <th scope="col" class="px-6 py-3 border border-gray-300">No</th>
            <th scope="col" class="px-6 py-3 border border-gray-300">Nomor Telepon</th>
            <th scope="col" class="px-6 py-3 border border-gray-300">Alamat</th>
            <th scope="col" class="px-6 py-3 border border-gray-300">Email</th>
            <th scope="col" class="px-6 py-3 border border-gray-300">Aksi</th>
          </tr>
        </thead>

          <tbody v-if="kontak">
            <tr class=" border-b border-gray-200 hover:bg-gray-100">
                <td class="px-4 text-center py-3 border border-gray-300">1</td>
                <td class="px-4 text-center py-3 border  border-gray-300">{{ kontak.noTelp }}</td>
                <td class="px-4 text-center py-3 border  border-gray-300">{{ kontak.alamat }}</td>
                <td class="px-4 text-center py-3 border border-gray-300">{{ kontak.email }}</td>
                <td class="px-4 text-center py-3">

      <router-link :to="'/editKontak/' + kontak.id">
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
  
      <footer class="text-center text-white bg-(--primary) py-3  text-sm">
© 2025 Yayasan Hosana Tebas. All Rights Reserved.
</footer>
</template>

<script>
import axios from "axios";

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL; // <-- pindah ke sini

export default {
  data() {
    return {
      kontak: null,
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    async fetchData() {
      try {
        const response = await axios.get(`${API_BASE_URL}/api/v1/kontak`);
        this.kontak = response.data[0];
      } catch (error) {
        console.error("Error fetching data:", error);
      }
      console.log("Data dari API:", this.kontak);
    },
  },
};
</script>



<style scoped>
</style>
