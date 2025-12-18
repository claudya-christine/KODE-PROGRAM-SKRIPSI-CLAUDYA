<script setup>
import { ref } from 'vue';

import image3 from '@/assets/images/image3.png';

const visi = ref([
  { id: 1, image: image3 },
]);

const currentIndex = ref(0);

</script>

<template>
 
    <div class="bg-[#454545]">
   <div
    class="w-full h-[150px] md:h-[350px] bg-contain bg-cover flex items-center justify-center text-center"
    :style="{ backgroundImage:   `url('${visi[currentIndex].image}')` }"
  >
    <div class="px-4">
      <h1 class="text-yellow-400 text-xl md:text-4xl text-2xl font-bold">VISI YAYASAN HOSANA</h1>
      <h2 class="text-white text-sm md:text-lg mt-2 font-bold ">
        "Menjadi Lembaga Pendidik Yang Berkualitas, Religius, Dan Ramah Lingkungan."
      </h2>
    </div>
  </div>
  </div>
</template>
