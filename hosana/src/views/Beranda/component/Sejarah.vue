<script setup>
import { ref } from 'vue';
import gkkb from '@/assets/images/gkkb.jpg'; 

const currentIndex = ref(0);

const sejarahText = `Yayasan Hosana Tebas lahir dari kerinduan jemaat GKKB Tebas untuk ikut serta
membangun manusia Indonesia seutuhnya, khususnya melalui bidang pendidikan. Yayasan
ini berlokasi di Desa Makrampai, Kecamatan Tebas, Kabupaten Sambas, Kalimantan Barat.`;

const maxLength = 200;
</script>

<template>
  <body>
    <div class="container mx-auto max-w-screen py-5 md:py-15 flex flex-col md:flex-row gap-5 md:gap-50 items-center justify-center">

      <div class="kiri">
        <img :src="gkkb" alt="GKKB" class="w-[55%] md:w-[350px] rounded-t-full h-auto mx-auto"/> 
      </div>

      <div class="kanan  md:w-[30%]">
        <div class="">
          <h1 class="md:text-4xl text-2xl font-bold md:text-left text-center text-yellow-400 mb-3">SEJARAH</h1>
          
          <p class="text-justify text-sm md:text-lg">
            {{ sejarahText.length > maxLength ? sejarahText.slice(0, maxLength) + '...' : sejarahText }}
          </p>
        </div>

        <router-link to="/Informasi">
          <button 
            class="bg-(--primary) hover:animate-pulse text-xs text-white px-6 py-3 rounded-full cursor-pointer mt-5 
                   flex items-center justify-center mx-auto md:mx-0 md:justify-start">
            Lebih Lengkap <i class="ri-arrow-right-long-fill ml-4"></i>
          </button>
        </router-link>
      </div>
    </div>
  </body>
</template>

<style>
</style>
