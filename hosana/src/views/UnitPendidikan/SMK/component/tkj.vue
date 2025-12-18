<script setup>
import whattkj from '@/assets/images/whattkj.jpg';
</script>

<template>

<div class=" mx-auto bg-(--smk) pb-10 pt-10 md:py-0">
    <div class=" items-center justify-center px-5 md:px-10 ">
    <div class=" ">
    <h2 class="font-bold md:text-4xl text-3xl text-center  text-white mb-10">TEKNIK JARINGAN KOMPUTER & TELEKOMUNIKASI</h2>
    </div> 
 
    <div class="flex flex-col md:flex-row  justify-center w-full md:w-[1150px]  mx-auto">
        <div class="w-[100%] bg-white md:py-20 md:px-15 p-5">
            <h1 class="font-bold text-2xl md:text-3xl text-(--primary) mb-3 md:text-left text-center ">APA ITU TJKT?</h1>
            <h3 class="text-justify"> Jurusan atau program keahlian di Sekolah Menengah Kejuruan (SMK) yang berfokus pada ilmu Teknologi Informasi dan Komunikasi (TIK). 
                Jurusan ini mempersiapkan siswa untuk bekerja di bidang komputer dan jaringan dengan mengajarkan cara merakit dan memperbaiki komputer, 
                merancang dan mengelola jaringan, hingga mengkonfigurasi berbagai perangkat jaringan. </h3>
        </div>
        <div class="w-[100%] h-full">
        <img :src="whattkj" alt="tkj" class="md:grayscale hover:grayscale-0 transform transition-all duration-700 ease-out"  />
        </div>
    </div>
    <!-- <div class="">
   <img :src="imagetk" alt="logo" class="w-[70%] md:w-[300px]"/> 
  </div> -->

  
    </div>
    </div>
</template>

<style>
</style>