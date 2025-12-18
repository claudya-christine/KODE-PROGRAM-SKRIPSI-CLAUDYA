<script setup>
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
import axios from '@/axios';
import { ref, onMounted } from 'vue';
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

const guruList = ref([]);
const errorMsg = ref('');

const fetchGuruTK = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/v1/gurustaff/all`, {
      params: { unit: 'SMK' }, 
    });
    console.log('Response API:', response.data);
    guruList.value = response.data.data || response.data;
  } catch (error) {
    console.error('Gagal memuat data guru:', error);
    errorMsg.value = error.message;
  }
};

onMounted(() => {
  fetchGuruTK();
});

const formatTanggal = (tanggal) => {
  if (!tanggal) return '-';
  const date = new Date(tanggal);
  return date.toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'long',
    year: 'numeric',
  });
};
</script>

<template>
  <Navbar />

  <div class="container mx-auto py-10 md:px-15 px-5 ">
    <h1 class="text-center md:text-4xl text-(--primary) font-bold mb-10">
      GURU & STAFF
      <span class="bg-(--smk) text-white px-3 py-1 rounded-2xl">SMPS HOSANA</span>
    </h1>

    <p v-if="errorMsg" class="text-red-500 text-center">{{ errorMsg }}</p>
    

    <div
      v-if="guruList.length > 0"
      class="flex md:px-0 px-10 justify-evenly gap-10 flex-col md:flex-row flex-wrap"
    >
      <div
        v-for="(guru, index) in guruList"
        :key="guru.staffID"
        class="md:w-[200px] w-[70%] h-[50%] mx-auto"
      >
        <div
          class="text-center bg-(--gssmk) mx-auto rounded-full hover:bg-(--smk) transition-colors duration-500"
        >
          <img
            v-if="guru.image"
            :src="`${API_BASE_URL}/storage/${guru.image}`"
            alt="guru"
            class="mx-auto h-[200px]"
          />
          <!-- <img
            v-else
            src="@/assets/images/guru2.png"
            alt="default"
            class="mx-auto w-[150px] h-[150px]"
          /> -->
        </div>
        <div class="text-xs md:text-left text-center mt-2">
          <h3 class="font-bold text-base">{{ guru.namalengkap }}</h3>
          <h3>Tanggal Lahir: {{ formatTanggal(guru.tanggal_lahir) }}</h3>
          <h3>Posisi: {{ guru.posisi }}</h3>
        </div>
      </div>
    </div>

    <p v-if="!errorMsg && guruList.length === 0" class="text-center text-gray-500 mt-10">
      Tidak ada data guru TK.
    </p>
  </div>

  <Footer />
</template>
