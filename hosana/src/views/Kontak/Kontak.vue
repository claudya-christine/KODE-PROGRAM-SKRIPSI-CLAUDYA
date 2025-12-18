<script setup>
import { ref, onMounted } from "vue";
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
import axios from "@/axios";
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

const kontak = ref([]);

const fetchKontak = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/v1/kontak`);
    kontak.value = response.data;
  } catch (error) {
    console.error("Gagal mengambil data:", error);
  }
};

onMounted(() => {
  fetchKontak();
});
</script>


<template>
    <Navbar />
  <div class="xl:w-[1125px] mx-auto mt-10 pb-10 px-5">
  <div class="text-center md:text-3xl text-2xl mb-5 font-bold text-(--primary)">
      <h1>HUBUNGI KAMI</h1>
      </div>
    <div class="flex flex-col lg:justify-evenly md:flex-row gap-10">
      
      
      <!-- Maps -->
      <div class="md:w-1/2 w-full border-2 border-(--primary) rounded-4xl p-3">
        <div v-for="item in kontak" :key="item.id" class="w-full">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1846.6092842478618!2d109.14848014397536!3d1.2315000029818741!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31e498dc6120b32f%3A0xb93bfafaadb8b256!2sGKKB%20Jemaat%20Tebas!5e0!3m2!1sid!2sid!4v1759334107005!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
            class="w-full h-64 md:h-[425px] rounded-xl">
          </iframe>
        </div>
      </div>

      <!-- Kontak Info -->
      <div class="flex flex-col text-center lg:w-[35%] gap-5 md:w-1/2 w-full">

        <!-- Telepon -->
        <div class="bg-(--primary) px-8 py-5 rounded-xl">
          <i class="ri-phone-fill text-3xl text-[#d7e5f0]"></i>
          <h2 class="font-bold text-white mb-1">Kontak</h2>
          <div v-for="item in kontak" :key="item.id">
            <h3 class="text-sm text-white" v-html="item.noTelp"></h3>
          </div>
        </div>

        <!-- Alamat -->
        <div class="bg-[#e1e9f5] px-8 py-5 rounded-xl">
          <i class="ri-school-fill text-3xl text-(--primary)"></i>
          <h2 class="font-bold text-(--primary) mb-1">YAYASAN HOSANA TEBAS</h2>
          <div v-for="item in kontak" :key="item.id">
            <h3 class="text-sm text-(--primary)" v-html="item.alamat"></h3>
          </div>
        </div>

        <!-- Email -->
        <div class="bg-(--primary) px-8 py-5 rounded-xl">
          <i class="ri-mail-fill text-3xl text-[#e1e9f5]"></i>
          <h2 class="font-bold text-white mb-1">Email</h2>
          <div v-for="item in kontak" :key="item.id">
            <h3 class="text-sm text-white" v-html="item.email"></h3>
          </div>
        </div>

      </div>
    </div>
  </div>

  <Footer />
</template>
