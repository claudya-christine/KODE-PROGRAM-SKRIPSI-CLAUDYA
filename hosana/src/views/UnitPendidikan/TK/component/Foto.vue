<script setup>
import fototk1 from '@/assets/images/fototk1.jpg'
import fototk2 from '@/assets/images/fototk2.jpg'
import fototk3 from '@/assets/images/fototk3.jpg'
import fototk4 from '@/assets/images/fototk4.jpg'
</script>

<template>
  <!-- SCROLL KE KIRI -->
  <div class="overflow-hidden whitespace-nowrap group md:block hidden ">
    <div class="flex animate-scroll">
      <template v-for="i in 2" :key="i">
        <div class="w-[350px] h-[180px] bg-(--gstk) mx-1"></div>
        <img
          :src="fototk1"
          alt="img"
          class="w-[350px] h-[180px] mx-2  grayscale hover:grayscale-0 transform transition-all duration-700 ease-out"
        />
        <img
          :src="fototk2"
          alt="img"
          class="w-[350px] h-[180px] mx-2  grayscale hover:grayscale-0 transform transition-all duration-700 ease-out"
        />
        <img
          :src="fototk3"
          alt="img"
          class="w-[350px] h-[180px] mx-2  grayscale hover:grayscale-0 transform transition-all duration-700 ease-out"
        />
      </template>
    </div>
  </div>

  <!-- SCROLL KE KANAN -->
  <div class="overflow-hidden whitespace-nowrap mt-3 group md:block hidden">
    <div class="flex animate-scroll-reverse">
      <template v-for="i in 2" :key="i">
                <div class="w-[350px] h-[180px] bg-[#f7e7c4] mx-1"></div>

        <img
          :src="fototk3"
          alt="img"
          class="w-[350px] h-[180px] mx-2  grayscale hover:grayscale-0 transform transition-all duration-700 ease-out"
        />
        <img
          :src="fototk4"
          alt="img"
          class="w-[350px] h-[180px] mx-2  grayscale hover:grayscale-0 transform transition-all duration-700 ease-out"
        />
        <img
          :src="fototk2"
          alt="img"
          class="w-[350px] h-[180px] mx-2  grayscale hover:grayscale-0 transform transition-all duration-700 ease-out"
        />
        <img
          :src="fototk1"
          alt="img"
          class="w-[350px] h-[180px] mx-2  grayscale hover:grayscale-0 transform transition-all duration-700 ease-out"
        />
      </template>
    </div>
  </div>
</template>

<style scoped>
@keyframes scroll {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-50%);
  }
}

.animate-scroll {
  width: max-content;
  animation: scroll 25s linear infinite;
}

.animate-scroll-reverse {
  width: max-content;
  animation: scroll 25s linear infinite reverse;
}
</style>
