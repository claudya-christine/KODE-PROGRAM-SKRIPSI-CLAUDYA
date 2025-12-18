<script setup>
import tkj from '@/assets/images/tkj.png';
import dkv from '@/assets/images/dkv.png';
</script>

<template>

    <div class="w-full mx-auto py-10 md:py-0 md:px-20">
    <div class=" items-center justify-center px-10 ">
    <div class=" ">
    <h2 class="font-bold md:text-4xl text-3xl text-center  text-(--smk) mb-10">JURUSAN</h2>
    </div>
    <!-- <div class="">
   <img :src="imagetk" alt="logo" class="w-[70%] md:w-[300px]"/> 
  </div> -->

  <div class="container mx-auto flex flex-col md:flex-row gap-10 md:gap-5 items-center justify-center ">

        <div class="kiri  md:w-[30%] w-screen px-5 md:px-0 border-r-2 border-[#dae0d5]">
            <div class="text-center">
            <img :src="tkj" alt="tkj"  class="w-[25%] md:w-[23%]  mx-auto  mb-2
                     transition-transform duration-300 ease-in-out hover:scale-110"/> 
            <h1 class="md:text-xl text-xl font-semibold text-(--smk) mb-2">TEKNIK JARINGAN KOMPUTER & TELEKOMUNIKASI</h1>
            </div>
        </div>
 
        <div class="kiri  md:w-[30%] w-screen px-5 md:px-0 ">
            <div class="text-center">
            <img :src="dkv" alt="dkv"  class="w-[25%] md:w-[25%]   mx-auto mb-2
                     transition-transform duration-300 ease-in-out hover:scale-110"> 
            <h1 class="md:text-2xl text-xl font-semibold text-(--smk) mb-2">DESAIN KOMUNIKASI VISUAL</h1>
            </div>
        </div>
    </div>

    </div>
    </div>
</template>

<style>
</style>