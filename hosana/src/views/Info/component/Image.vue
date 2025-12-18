<script setup>
import { ref } from 'vue';
import slide1 from '@/assets/images/gkkb1.jpg';


const coverBeranda = ref([
  { id: 1, image: slide1 },
]);

const currentIndex = ref(0);

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
    <div class="mx-auto w-full md:w-full  overflow-hidden relative">  
  <div
    class="w-full h-[150px] md:h-[350px] bg-center bg-no-repeat brightness-60 bg-cover bg-contain"
      :style="{ backgroundImage: `url('${coverBeranda[currentIndex].image}')`,   }"
  >

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
