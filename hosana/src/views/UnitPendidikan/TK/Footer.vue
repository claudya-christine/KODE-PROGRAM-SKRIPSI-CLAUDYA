<script setup>
import { ref, onMounted } from "vue";
import axios from "@/axios";
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

const kontak = ref([]);

const fetchKontak = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/v1/kontak`);
    kontak.value = response.data;
  } catch (error) {
    console.error("Gagal mengambil data:", error);
  }
};

onMounted(() => {
  fetchKontak();
});
</script>

<template>
  <footer class="bg-[#e80997] text-white font-lato">
    <div class="max-w-7xl mx-auto px-5 md:px-20 py-12 flex flex-wrap justify-between gap-10">
      
      <div class="w-full md:w-[30%] ">
        <h3 class="text-sm font-semibold mb-4 text-yellow-200">YAYASAN HOSANA TEBAS</h3>
        <p class="text-sm text-justify leading-6">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </p>
      </div>

      <div class="w-full md:w-[30%]  ">
        <h3 class="text-sm font-semibold mb-4">INFORMASI</h3>
        <ul class="space-y-2 text-sm">
          <li><router-link to="/" class="hover:underline">BERANDA</router-link></li>
          <li><router-link to="/Informasi" class="hover:underline">INFORMASI YAYASAN</router-link></li>
          <li><router-link to="/TK" class="hover:underline">UNIT PENDIDIKAN</router-link></li>
          <li><router-link to="/GSTK" class="hover:underline">GURU & STAFF</router-link></li>
          <li><router-link to="/Alumni" class="hover:underline">INFORMASI ALUMNI</router-link></li>
          <li><router-link to="/BeritaAll" class="hover:underline">BERITA</router-link></li>
          <li><router-link to="/Kontak" class="hover:underline">KONTAK</router-link></li>
        </ul>
      </div>

      <div class="w-full md:w-[30%]  ">
        <h3 class="text-sm font-semibold mb-4">KONTAK KAMI</h3>
        <div v-for="item in kontak" :key="item.id" class="space-y-4 text-sm">
          <p class="flex items-center">
            <i class="ri-phone-fill text-3xl mr-3"></i><span> {{ item.noTelp }}</span>
          </p>
          <p class="flex items-start">
           <i class="ri-school-fill text-3xl mr-3"></i>
            <span>{{ item.alamat }}</span>
          </p>
          <p class="flex items-start">
            <i class="ri-mail-fill text-3xl mr-3"></i>
            <span>{{ item.email }}</span>
          </p>
        </div>
      </div>

    </div>

    <!-- Copyright -->
    <div class="bg-white text-center text-gray-700 py-3 text-sm">
      © 2025 Yayasan Hosana Tebas. All Rights Reserved.
    </div>
  </footer>
</template>

<style scoped>
</style>
