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
const news = ref([]);
const showNavigation = ref(window.innerWidth >= 1024);
const prevRef = ref(null);
const nextRef = ref(null);

const updateNavigation = () => {
  showNavigation.value = window.innerWidth >= 1024;
};

const fetchBerita = async () => {
  try {
    const res = await axios.get(`${API_BASE_URL}/api/v1/berita`);
    news.value = res.data.data || res.data;
  } catch (error) {
    console.error("Gagal memuat berita:", error);
  }
};

onMounted(() => {
  fetchBerita();
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
  <div class="w-full relative py-10 md:px-20 px-5 overflow-x-hidden">
    <div class="cont-text1 text-center mb-5" data-aos="fade-down">
      <h2 class="font-bold text-(--primary) md:text-4xl text-2xl">BERITA TERBARU</h2>
    </div>

    <div class="cont-swiper text-justify relative" data-aos="zoom-in">
      <Swiper
        :modules="[Pagination, Navigation]"
        :slides-per-view="1"
        :space-between="20"
        :pagination="{ clickable: true }"
        :navigation="{ nextEl: nextRef, prevEl: prevRef }"
        :breakpoints="{ 640: { slidesPerView: 2 }, 768: { slidesPerView: 3 }, 1024: { slidesPerView: 3 } }"
        class="mySwiper w-full max-w-[1200px] mx-auto"
      >
        <SwiperSlide
          v-for="item in news"
          :key="item.id"
          
        >
          <div class="bg-white shadow-lg rounded-xl w-[100%] duration-800 hover:z-10">
            <picture class="block overflow-hidden group">
              <img
                v-if="item.media && item.media.length > 0"
                :src="`${API_BASE_URL}/storage/${item.media[0].file_path}`"
                alt="Gambar Berita"
                class="w-full max-h-40 object-cover rounded-lg md:grayscale hover:grayscale-0 transform transition-transform duration-1000 ease-out group-hover:scale-110"
              />
              <img
                v-else
                src="@/assets/images/news1.jpg"
                alt="Default News"
                class="w-full max-h-40 object-cover rounded-lg"
              />
            </picture>

            <h3 class="text-l font-bold mt-2 pb-4 pl-4 pr-4">{{ item.judul }}</h3>
            <p class="text-gray-500 pb-4 pl-4 pr-4 text-sm">
              {{ item.isi.slice(0, 100) }}...
            </p>

            <div class="flex mx-4 justify-between items-center">
              <p class="text-sm text-gray-600">
                {{
                  item.kategoris && item.kategoris.length
                    ? item.kategoris
                        .slice(0, 2) 
                        .map(k => k.nama_kategori)
                        .join(', ') + (item.kategoris.length > 2 ? ', ...' : '')
                    : '-'
                }}
              </p>

              <router-link
                :to="`/BeritaDetail/${item.id}`"
                class="text-(--primary) text-right cursor-pointer pb-4 pl-4 pr-4 block"
              >
                Lihat Selengkapnya >>
              </router-link>
            </div>
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

    <div class="cont-button text-center mt-5">
      <router-link to="/BeritaAll">
        <button
          class="bg-(--primary) hover:animate-pulse text-white px-5 py-3 text-sm border rounded cursor-pointer border-none"
        >
          Lihat Semua Berita<i class="ri-arrow-right-long-fill ml-4"></i>
        </button>
      </router-link>
    </div>
  </div>
</template>

<style scoped>
.mySwiper {
  padding-bottom: 40px;
}
</style>
