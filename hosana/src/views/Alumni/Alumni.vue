<script setup>
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
import SD from './component/SD.vue';
import SMP from './component/SMP.vue';
import SMK from './component/SMK.vue';
</script>

<template>
  <Navbar />
      <div class="cont-text1 text-center pt-10 md:px-20 px-5" data-aos="fade-down">
        <h1 class="font-bold text-(--primary) text-3xl">INFORMASI GRUP ALUMNI</h1>
        <h3 class=" text-(--primary) text-sm mt-3">Yuk, bergabung dengan grup WhatsApp alumni sesuai jenjang pendidikanmu!</h3>
        </div>
  <SD />
  <SMP />
  <SMK />


  <Footer />

</template>
