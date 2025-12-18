<script setup>
import { ref } from 'vue';
import logotk from '@/assets/images/tk.png'
import logosd from '@/assets/images/sd.png'
import logosmp from '@/assets/images/smp.png'
import logosmk from '@/assets/images/smk.png'
import AOS from "aos";

const currentIndex = ref(0);
</script>

<template>
  <div class="container mx-auto py-10 px-5 md:px-10">
    <!-- Judul -->
    <div class="text-center mb-5">
      <h1 class="font-bold md:text-4xl text-2xl mb-2 text-(--primary)">
        UNIT PENDIDIKAN HOSANA TEBAS
      </h1>
      <h3>Membangun generasi unggul melalui unit pendidikan Yayasan Hosana Tebas.</h3>
    </div>

    <!-- Grid layout -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 justify-items-center">
      <!-- TK -->
      <div data-aos="fade-right" class="flex md:flex-row flex-col  items-center border p-4 w-full max-w-[500px] bg-(--gstk) hover:shadow-xl ">
        <img :src="logotk" alt="logotk" class="md:w-[15%] w-[20%] md:mr-3 md:mb-0 mb-3" />
        <div class="text-justify text-xs md:text-sm ">
          Taman Kanak-Kanak (TK) adalah jenjang pendidikan bagi anak usia 4–6 tahun yang mempersiapkan mereka sebelum masuk SD.
          Melalui kegiatan bermain sambil belajar.
        </div>
      </div>

      <!-- SD -->
      <div data-aos="fade-left" class="flex md:flex-row flex-col items-center border p-4 w-full max-w-[500px] bg-(--gssd) hover:shadow-xl">
        <img :src="logosd" alt="logosd" class="md:w-[15%] w-[20%] md:mr-3 md:mb-0 mb-3" />
        <div class="text-justify text-xs md:text-sm">
          Sekolah Dasar (SD) adalah jenjang pendidikan dasar untuk anak usia 7–12 tahun yang berfokus pada pengembangan kemampuan akademik dasar, karakter, dan disiplin belajar.
        </div>
      </div>

      <!-- SMP -->
      <div data-aos="fade-right" class="flex md:flex-row flex-col  items-center border p-4 w-full max-w-[500px] bg-(--gssmp) hover:shadow-xl">
        <img :src="logosmp" alt="logosmp" class="md:w-[15%] w-[20%] md:mr-3 md:mb-0 mb-3" />
        <div class="text-justify text-xs md:text-sm">
          Sekolah Menengah Pertama (SMP) membantu siswa memperdalam pengetahuan akademik dan mengasah kemampuan sosial serta kemandirian belajar.
        </div>
      </div>

      <!-- SMK -->
      <div data-aos="fade-left" class="flex md:flex-row flex-col  items-center border p-4 w-full max-w-[500px] bg-(--gssmk) hover:shadow-xl">
        <img :src="logosmk" alt="logosmk" class="md:w-[15%] w-[20%] md:mr-3 md:mb-0 mb-3" />
        <div class="text-justify text-xs md:text-sm">
          Sekolah Menengah Kejuruan (SMK) berfokus pada pembelajaran praktis dan keterampilan kerja sesuai bidang keahlian, mempersiapkan siswa untuk dunia industri.
        </div>
      </div>
    </div>
  </div>
</template>
