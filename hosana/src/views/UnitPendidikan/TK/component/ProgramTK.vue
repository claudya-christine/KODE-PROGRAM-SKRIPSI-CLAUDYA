<script setup>
import imagetk from '@/assets/images/imagetk.png'

</script>

<template>

    <div class="md:w-full w-screen mx-auto md:px-20  px-5 py-10 ">
    <div class=" items-center justify-center pt-5 md:pt-0 px-5 md:px-10 flex md:flex-row flex-col bg-[#fcd4f3] rounded-4xl">
    <div class="">
    <h2 class="font-bold md:text-4xl text-3xl md:text-left text-center  text-(--tk) md:mb-3 mb-5">PROGRAM PENDIDIKAN</h2>
    <h4 class="text-justify"><span class="font-bold ">Kelompok Belajar A </span> : (Usia 4 - 5 Tahun)
        Fokus pada pengembangan dasar keterampilan sosial, motorik, kognitif, dan bahasa.
    </h4>
    <br>
    <h4 class="text-justify"> <span class="font-bold"> Kelompok Belajar B </span>: (Usia 5 - 6 Tahun)
        Persiapan menuju pendidikan dasar dengan penguatan keterampilan akademis dan sosial.
    </h4>
    </div>
    <div class="">
  <img :src="imagetk" alt="logo" class="w-[60%] mx-auto md:w-[300px]"/>
  </div>
</div>
    </div>
</template>

<style>
</style>