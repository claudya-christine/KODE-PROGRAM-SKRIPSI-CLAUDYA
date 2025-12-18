<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";
import { Pagination, Navigation, Autoplay } from "swiper/modules";
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;
import axios from "axios";

const coverBeranda = ref([]);

const showNavigation = ref(window.innerWidth >= 1024);
const prevRef = ref(null);
const nextRef = ref(null);

const fetchBannerData = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/v1/banner`);
    coverBeranda.value = response.data.data;
  } catch (error) {
    console.error("Gagal mengambil data banner:", error);
  }
};

const updateNavigation = () => {
  showNavigation.value = window.innerWidth >= 1024;
};

onMounted(() => {
  fetchBannerData();
  window.addEventListener("resize", updateNavigation);
});

onBeforeUnmount(() => {
  window.removeEventListener("resize", updateNavigation);
});
</script>

<template>
  <div class="relative w-full">
    <Swiper
      :modules="[Pagination, Navigation, Autoplay]"
      :slides-per-view="1"
      :pagination="{ clickable: true }"
      :autoplay="{ delay: 4000, disableOnInteraction: false }"
      :navigation="showNavigation ? { nextEl: nextRef, prevEl: prevRef } : false"
      class="mySwiper"
    >
      <SwiperSlide v-for="item in coverBeranda" :key="item.id">
        <div
          class="w-screen h-[130px] md:h-[350px] bg-center bg-no-repeat bg-cover"
          :style="{ backgroundImage: `url(${API_BASE_URL}/storage/${item.banner})` }"
        ></div>
      </SwiperSlide>
    </Swiper>

    <!-- Tombol navigasi -->
    <button
      v-if="showNavigation"
      ref="prevRef"
      class="hidden md:block absolute left-4 top-1/2 z-10 -translate-y-1/2 bg-white/60 px-3 py-2 rounded-full hover:bg-white"
    >
      ❮
    </button>
    <button
      v-if="showNavigation"
      ref="nextRef"
      class="hidden md:block absolute right-4 top-1/2 z-10 -translate-y-1/2 bg-white/60 px-3 py-2 rounded-full hover:bg-white"
    >
      ❯
    </button>
  </div>
</template>

<style scoped>
.mySwiper {
  padding-bottom: 40px;
}
</style>
