<script setup>
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
import banner from './component/Banner.vue';
import sejarah from './component/Sejarah.vue';
import visi from './component/Visi.vue';
import angka from './component/Angka.vue';
import uPendidikan from './component/UPendidikan.vue';
import berita from './component/Berita.vue';
</script>

<template>
  <Navbar />
  <banner />
  <div class="px-5">
  <sejarah />
    </div>
  <visi />
  <angka />
  <uPendidikan />
  <berita />
  <Footer />

</template>
