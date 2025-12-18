<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;


import logo from '@/assets/logo.svg'

const totalUser = ref(0);
const totalBerita = ref(0);
const totalGuruStaff = ref(0);

const fetchDashboardData = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/v1/dashboard`);
    totalUser.value = response.data.totalUser;
    totalBerita.value = response.data.totalBerita;
    totalGuruStaff.value = response.data.totalGuruStaff;
  } catch (error) {
    console.error("Gagal memuat data dashboard:", error);
  }
};

onMounted(() => {
  fetchDashboardData();
});
</script>

<template>
  <main class="flex-1 p-8 relative overflow-hidden">
    <!-- Logo Background -->
    <div class="absolute inset-0 flex justify-center items-center opacity-10 pointer-events-none z-0">
      <img :src="logo" alt="Logo" class="w-64 h-64" />
    </div>

    <h2 class="text-2xl font-bold text-gray-800 mb-6 relative z-10">DASHBOARD</h2>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8 relative z-10">
      <!-- Total User -->
             <router-link to="/tbUser">

      <div
        class="bg-[#5352ed] hover:animate-pulse shadow rounded-2xl p-4 flex flex-col items-center cursor-pointer hover:shadow-lg"
      >
          <i class="ri-user-fill text-white text-3xl"></i>
        <p class="mt-2 text-sm text-white">Total User Terdaftar</p>
        <p class="text-2xl text-white font-semibold">{{ totalUser }}</p>
      </div>
      </router-link>

      <!-- Total Berita -->
      <router-link to="/tbBerita">
        <div
          class="bg-[#ff3838] hover:animate-pulse shadow rounded-2xl p-4 flex flex-col items-center cursor-pointer hover:shadow-lg"
        >
            <i class="ri-article-fill text-white text-3xl"></i>
          <p class="mt-2 text-sm text-white">Total Berita Diposting</p>
          <p class="text-2xl text-white font-semibold">{{ totalBerita }}</p>
        </div>
      </router-link>

      <!-- Total Guru & Staff -->
      <router-link to="/tbGuruStaff">
        <div
          class="bg-[#f7b731] hover:animate-pulse shadow rounded-2xl p-4 flex flex-col items-center cursor-pointer hover:shadow-lg"
        >
            <i class="ri-team-fill text-white text-3xl"></i>
          <p class="mt-2 text-sm text-white">Total Guru & Staf Sekolah</p>
          <p class="text-2xl text-white font-semibold">{{ totalGuruStaff }}</p>
        </div>
      </router-link>
    </div>
  </main>
</template>

