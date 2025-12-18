<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";
import { Pagination, Navigation } from "swiper/modules";
import AOS from "aos";
import "aos/dist/aos.css";
import axios from "axios";
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

const fasilitasList = ref([]);
const showNavigation = ref(window.innerWidth >= 1024);
const prevRef = ref(null);
const nextRef = ref(null);

const updateNavigation = () => {
  showNavigation.value = window.innerWidth >= 1024;
};


const fetchFasilitas = async () => {
  try {
    const res = await axios.get(`${API_BASE_URL}/api/v1/fasilitas/all?unit=SMK`);
    fasilitasList.value = res.data.filter(item => item && item.id);

  } catch (error) {
    console.error("Gagal memuat data fasilitas:", error);
  }

};

onMounted(() => {
  fetchFasilitas();
  AOS.init({
    duration: 1000,
    easing: "ease-in-out",
    once: true,
  });
  window.addEventListener("resize", updateNavigation);
});
 
onBeforeUnmount(() => {
  window.removeEventListener("resize", updateNavigation);
});
</script>

<template>
<div class="mx-auto px-5 md:px-15 pb-10 bg-(--gssmk)">    
  <div class="cont-text1 text-center mb-5" data-aos="fade-down">
      <h2 class="font-bold  text-(--smk) pt-5 md:text-4xl text-3xl">FASILITAS</h2>
    </div>

    <!-- Swiper -->
    <div class="cont-swiper text-justify relative" data-aos="zoom-in">
      <Swiper
        :modules="[Pagination, Navigation]"
        :slides-per-view="1"
        :space-between="10"
        :pagination="{ clickable: true }"
        :navigation="{ nextEl: nextRef, prevEl: prevRef }"
        :breakpoints="{ 640: { slidesPerView: 2 }, 768: { slidesPerView: 3 }, 1024: { slidesPerView: 3 } }"
        class="mySwiper w-full max-w-[1200px] mx-auto"
      >
        <SwiperSlide
          v-for="item in fasilitasList"
          :key="item.id"
        > 
          <div class="bg-[#d1eefa] hover:bg-white shadow-lg rounded-xl p-5 w-[100%] duration-800 hover:z-10">
            <picture class="block overflow-hidden group">
              <img
                  :src="`${API_BASE_URL}/storage/${item.image}`"
                  alt="Fasilitas"
                  class="w-full max-h-40 object-cover rounded-lg transform transition-transform duration-1000 ease-out group-hover:scale-110"
                />
              </picture>

            <h3 class="text-l font-bold mt-4 pb-2 text-(--smk)">
                {{ item.namaFasilitas }}
              </h3>
           <p class="text-(--secondary) pb-4 text-sm">
                {{ item.deskripsi }}
              </p>

          </div>
        </SwiperSlide>
      </Swiper>

      <div class="flex justify-center items-center gap-4 mt-5">
        <button
          ref="prevRef"
          class="text-(--primary) bg-gray-100 py-[8px] px-[15px] rounded-full cursor-pointer hover:bg-gray-200"
        >
          ❮
        </button>
        <button
          ref="nextRef"
          class="text-(--primary) bg-gray-100 py-[8px] px-[15px] rounded-full cursor-pointer hover:bg-gray-200"
        >
          ❯
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.mySwiper {
  padding-bottom: 40px;
}
</style>


<style scoped>
.mySwiper {
  padding-bottom: 40px;
  
}
</style>
