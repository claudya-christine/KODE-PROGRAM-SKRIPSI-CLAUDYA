<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import AOS from "aos";
import "aos/dist/aos.css";
import Navbar from "@/components/Navbar.vue";
import Footer from "@/components/Footer.vue";
import axios from "axios";
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;
const news = ref([]);
const categories = ref([]); 
const selectedCategory = ref("All");
const showNavigation = ref(window.innerWidth >= 1024);

const updateNavigation = () => {
  showNavigation.value = window.innerWidth >= 1024;
};


const fetchBerita = async () => {
  try {
    const res = await axios.get(`${API_BASE_URL}/api/v1/berita/all`);
    news.value = res.data;

    const allCategories = new Set();
    news.value.forEach((item) => {
      if (item.kategoris && item.kategoris.length > 0) {
        item.kategoris.forEach((k) => allCategories.add(k.nama_kategori));
      }
    });
    categories.value = ["All", ...Array.from(allCategories)];
  } catch (error) {
    console.error("Gagal memuat berita:", error);
  }
};

const filteredNews = computed(() => {
  if (selectedCategory.value === "All") {
    return news.value;
  }
  return news.value.filter((item) =>
    item.kategoris?.some(
      (k) => k.nama_kategori.toLowerCase() === selectedCategory.value.toLowerCase()
    )
  );
});

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
  <Navbar />
  <div class="container mx-auto relative py-10 md:px-20 px-5">
    <div
      class="cont-text1 flex flex-col md:flex-row justify-between items-center mb-5 gap-4"
      data-aos="fade-down"
    >
      <div class="text-left">
        <h1 class="font-bold text-(--primary) md:text-3xl text-2xl">BERITA</h1>
        <h2 class="text-sm md:text-base">Temukan berita dan informasi terbaru tentang kami di sini</h2>
      </div>

      <div class="relative">
        <select
          v-model="selectedCategory"
          class="border text-xs  border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-(--primary)"
        >
          <option
            v-for="category in categories"
            :key="category"
            :value="category"
          class="text-xs">
            {{ category }}
          </option>
        </select>
      </div>
    </div>

    <!-- Grid berita -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="item in filteredNews"
        :key="item.id"
        class="bg-white shadow-lg rounded-xl w-full hover:z-10 transition duration-500"
        data-aos="fade-up"
      >
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

        <h3 class="text-l font-bold mt-2 pb-4 px-4">{{ item.judul }}</h3>

        <p class="text-gray-500 pb-4 px-4 text-sm text-justify">
          {{ item.isi.slice(0, 100) }}...
        </p>

        <p class="text-sm text-gray-600 px-4 pb-2">
          {{
            item.kategoris && item.kategoris.length
              ? item.kategoris
                  .slice(0, 2)
                  .map((k) => k.nama_kategori)
                  .join(", ") + (item.kategoris.length > 2 ? ", ..." : "")
              : "-"
          }}
        </p>

        <router-link
          :to="`/BeritaDetail/${item.id}`"
          class="text-(--primary) text-right cursor-pointer mt-5 pb-4 px-4 block"
        >
          Lihat Selengkapnya >>
        </router-link>
      </div>
    </div>
  </div>
  <Footer />
</template>

<style scoped>
.mySwiper {
  padding-bottom: 40px;
}
</style>
