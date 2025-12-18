<script setup>
import Navbar from './Navbar.vue';
import Image from './component/Image.vue';
import ProgramSMK from './component/ProgramSMK.vue';
import Unggul from './component/Unggul.vue';
import Fasilitas from './component/Fasilitas.vue';
import Footer from './Footer.vue';
import Jurusan from './component/Jurusan.vue';
import TKJ from './component/tkj.vue';
import DKV from './component/dkv.vue';
import Ekskul from './component/Ekskul.vue';
</script>

<template>
<Navbar />
<Image />
<ProgramSMK />
<Unggul />
<Jurusan />
<div class="relative">
    <svg 
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 1440 320"
      class="block leading-none"
    >
      <path fill="#1e61a6" fill-opacity="1" d="M0,224L480,64L960,224L1440,96L1440,320L960,320L480,320L0,320Z"></path>
    </svg>

    <div class="-mt-[20px]">
      <TKJ />
    </div>
  </div>
  <div class="bg-[#000853]">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#1e61a6" fill-opacity="1" d="M0,32L480,160L960,96L1440,128L1440,0L960,0L480,0L0,0Z"></path></svg>
  </div>
  <div class="-mt-[80px]">
      <DKV />
</div>

  
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="#000853" fill-opacity="1" d="M0,64L480,128L960,96L1440,160L1440,0L960,0L480,0L0,0Z"></path>
  </svg>

  <div class="-mt-[100px]">
    <Ekskul />

  </div>
  <Fasilitas />
<Footer />

</template>

<style>
</style>