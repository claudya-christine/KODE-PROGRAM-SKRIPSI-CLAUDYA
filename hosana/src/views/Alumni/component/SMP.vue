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

import WA from "@/assets/images/WA.jpeg";

const news = ref([]); 

const fetchAlumniSMP = async () => {
  try {
    let page = 1;
    let allData = [];
    let response;

    do {
      response = await axios.get(`${API_BASE_URL}/api/v1/alumni?page=${page}`);
      allData = allData.concat(response.data.data);
      page++;
    } while (response.data.next_page_url);

    const smpData = allData.filter(
      (item) => item.unit?.pendidikan?.toLowerCase().includes("smp")
    );

    news.value = smpData.map((item) => ({
      id: item.id,
      image: WA,
      title: `SMPS HOSANA Generasi ${item.generasi}`,
      content: `Ini adalah Link Grup WhatsApp untuk Generasi ${item.generasi}`,
      link: item.link || "#",
    }));
  } catch (error) {
    console.error("Gagal memuat data alumni :", error);
  }
};


const showNavigation = ref(window.innerWidth >= 1024);
const prevRef = ref(null);
const nextRef = ref(null);

const updateNavigation = () => {
  showNavigation.value = window.innerWidth >= 1024;
};

onMounted(() => {
  AOS.init({
    duration: 1000,
    easing: "ease-in-out",
    once: true,
  });
  fetchAlumniSMP(); 
  window.addEventListener("resize", updateNavigation);
});

onBeforeUnmount(() => {
  window.removeEventListener("resize", updateNavigation);
});
</script>

<template>
  <div class="mx-auto px-5 md:px-15 pb-5">
    <div class="cont-text1 text-center mb-5" data-aos="fade-down">
      <h1 class="font-bold text-(--primary) pt-5 md:text-2xl text-xl">
        Alumni SMPS HOSANA
      </h1>
    </div>

    <div class="cont-swiper text-justify relative" data-aos="zoom-in">
      <Swiper
        :modules="[Pagination, Navigation]"
        :slides-per-view="1"
        :space-between="10"
        :pagination="{ clickable: true }"
        :navigation="{ nextEl: nextRef, prevEl: prevRef }"
        :breakpoints="{ 
          640: { slidesPerView: 2 }, 
          768: { slidesPerView: 3 }, 
          1024: { slidesPerView: 3 } 
        }"
        class="mySwiper w-full max-w-[1200px] mx-auto"
      >
        <SwiperSlide v-for="item in news" :key="item.id">
          <div
            class="bg-white hover:bg-gray-50 shadow-lg rounded-xl p-5 w-[100%] duration-800 hover:z-10"
          >
            <picture class="block overflow-hidden group">
              <img
                :src="item.image"
                alt="Alumni Image"
                class="w-full max-h-40 object-cover rounded-lg transform transition-transform duration-1000 ease-out group-hover:scale-110"
              />
            </picture>

            <h3 class="text-l font-bold mt-4 pb-2 text-(--primary)">
              {{ item.title }}
            </h3>

            <p class="text-gray-500 pb-4 text-sm">
              {{ item.content }}
            </p>

            <a
              :href="item.link"
              target="_blank"
              class="text-(--primary) block cursor-pointer mt-3"
            >
              {{ item.link }}
            </a>
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
