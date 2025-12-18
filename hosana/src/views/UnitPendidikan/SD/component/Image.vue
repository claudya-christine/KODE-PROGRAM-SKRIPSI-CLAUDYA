<script setup>
import { ref } from 'vue';
import slide1 from '@/assets/images/sd.svg';
import logo from '@/assets/images/sd.png'
import slide2 from '@/assets/images/slide2.jpg';
import slide3 from '@/assets/images/slide3.png';

const coverBeranda = ref([
  { id: 1, image: slide1 },
  //{ id: 1, image: slide1 },
]);

const currentIndex = ref(0);

// Fungsi navigasi
const nextSlide = () => {
  currentIndex.value = (currentIndex.value + 1) % coverBeranda.value.length;
};

const prevSlide = () => {
  currentIndex.value = (currentIndex.value - 1 + coverBeranda.value.length) % coverBeranda.value.length;
};
</script>

<template>
    <div class="banner" >
  <div class="relative w-full overflow-hidden">
    <!-- Slide aktif -->
    <div class="mx-auto w-full md:w-full  overflow-hidden relative">
  <div
    class="w-full h-[150px] md:h-[450px] bg-center bg-no-repeat  bg-cover bg-contain"
      :style="{ backgroundImage: `url('${coverBeranda[currentIndex].image}')`,   }"
  >
<div class="absolute inset-0 flex flex-col items-center justify-center ">

  <img :src="logo" alt="logo" class="w-[12%] md:w-[150px] md:h-[150px] mb-2 md:mb-5" />
  <div class="bg-(--sd) rounded md:py-3 md:px-10 px-3 flex items-center justify-center">
    <h1 class="md:text-7xl text-2xl font-bold text-white">SDS PROTESTAN</h1>
  </div>

  <!-- <h1 class="md:text-2xl text-sm text-white md:mt-3 mt-2">
    PPDB TAHUN AJARAN 2025/2026
  </h1> -->
</div>


</div>
</div>
    <!-- Tombol navigasi muncul hanya jika slide > 1 -->
    <template v-if="coverBeranda.length > 1">
      <button 
        @click="prevSlide"
        class="absolute left-4 top-1/2 cursor-pointer transform -translate-y-1/2 bg-white bg-opacity-50 px-3 py-2 rounded hover:bg-opacity-80"
      >&lt;</button>
      <button 
        @click="nextSlide"
        class="absolute right-4 top-1/2 cursor-pointer transform -translate-y-1/2 bg-white bg-opacity-50 px-3 py-2 rounded hover:bg-opacity-80"
      >&gt;</button>
    </template>
    <!-- Teks di slider -->
    </div>
  </div>


  <div class="">


  </div>
</template>
