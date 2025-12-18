<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

const kegiatanList = ref([]);

const fetchKegiatan = async () => {
  try {
    const res = await axios.get(`${API_BASE_URL}/api/v1/kegiatan/all?unit=SMP`);
    kegiatanList.value = res.data.filter(item => item && item.id);
  } catch (error) {
    console.error("Gagal memuat kegiatan:", error);
  }
};

onMounted(() => {
  fetchKegiatan();
}); 
</script>

<template>
  <div class="mx-auto px-5 pb-15">
    <div data-aos="fade-left" class="text-center mb-10">
    <h1  class ="font-bold pt-10 md:pt-0 md:text-4xl text-2xl text-(--smp) ">
      KEGIATAN DAN EKSKUL 
    </h1>
    <h3 class="text-[#4a2800] text-sm">Kegiatan seru dan ekstrakurikuler menarik untuk mengembangkan potensi, bakat, dan jiwa kepemimpinan siswa SD.
</h3>
</div>
    <div 
      class="container md:gap-10 gap-5 mx-auto flex flex-col md:flex-row flex-wrap  items-center justify-evenly"
    >
      <div
        v-for="item in kegiatanList"
        :key="item.id"
        class="md:w-[300px] w-full md:px-0 "
        data-aos="fade-left"
      >
        <!-- Judul -->
        <div
          class="w-full h-full shadow-lg py-2  shadow-lg  rounded-lg bg-(--gssmp) flex items-center justify-center"
        >
          <h3 class="text-xl font-bold text-[#ab7500]">
            {{ item.namaKegiatan }}
          </h3>
        </div>

        <!-- Konten -->
        <div
          class="w-full mt-3 p-5 rounded-lg h-full shadow-lg  bg-(--gssmp)"
        >
      <div class="w-full mb-3 rounded-lg overflow-hidden group">
        <img
          v-if="item.image"
          :src="`${API_BASE_URL}/storage/${item.image}`"
          alt="Foto Kegiatan"
          class="rounded-lg w-full h-[150px] object-cover transform transition-transform duration-700 ease-out group-hover:scale-110"
        />
        <!-- <img
          v-else
          src="@/assets/images/default.jpg"
          alt="Default"
          class="rounded-lg w-full h-[150px] object-cover transform transition-transform duration-700 ease-out group-hover:scale-110"
        /> -->
      </div>

          <!-- Deskripsi -->
          <div class="rounded-lg bg-(--gssmp) h-full text-xs text-justify">
            <p>{{ item.deskripsi }}</p>
          </div>
        </div>
      </div>

      <!-- Jika belum ada data -->
      <p v-if="kegiatanList.length === 0" class="text-gray-500 text-center mt-10">
        Belum ada data ekstrakurikuler.
      </p>
    </div>
  </div>
</template>

<style scoped>

</style>
