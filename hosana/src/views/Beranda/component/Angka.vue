<script setup>
import { ref, onMounted } from 'vue'
import axios from '@/axios'  // pastikan axios sudah dikonfigurasi
import guru from '@/assets/images/teacher.png'
import siswa from '@/assets/images/reading.png'
import alumni from '@/assets/images/graduated.png'
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

const statistic = ref(null)

onMounted(async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/v1/statistic`)
    statistic.value = response.data
    console.log('Data Statistik:', statistic.value)
  } catch (error) {
    console.error('Gagal mengambil data statistik:', error)
  }
})
</script>

<template>
  <div class="container mx-auto  pt-15 flex flex-col md:flex-row gap-5 items-center justify-evenly">
    <div class="md:w-[20%] w-screen px-5 md:px-0 text-center">
      <img :src="alumni" alt="alumni" class="w-[25%] md:w-[50%] h-auto mx-auto mb-2" />
      <h1 class="md:text-2xl text-xl text-(--primary)">
        {{ statistic ? statistic.total_alumni : '...' }}
      </h1>
      <h1 class="md:text-3xl text-xl font-bold text-yellow-400 mb-3">ALUMNI</h1>
    </div>

    <div class="md:w-[20%] w-screen px-5 md:px-0 text-center">
      <img :src="siswa" alt="siswa" class="w-[25%] md:w-[50%] h-auto mx-auto mb-2" />
      <h1 class="md:text-2xl text-xl text-(--primary)">
        {{ statistic ? statistic.total_siswa : '...' }}
      </h1>
      <h1 class="md:text-3xl text-xl font-bold text-yellow-400 mb-3">SISWA AKTIF</h1>
    </div>

    <div class="md:w-[20%] w-screen px-5 md:px-0 text-center">
      <img :src="guru" alt="guru" class="w-[25%] md:w-[50%] h-auto mx-auto mb-2" />
      <h1 class="md:text-2xl text-xl text-(--primary)">
        {{ statistic ? statistic.total_guru_staff : '...' }}
      </h1>
      <h1 class="md:text-3xl text-xl font-bold text-yellow-400 mb-3">GURU</h1>
    </div>
  </div>
</template>

<style scoped>
</style>
