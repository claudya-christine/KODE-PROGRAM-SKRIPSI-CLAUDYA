<script setup>
import senam from '@/assets/images/exercisesmp.png';
import pembinaan from '@/assets/images/compassionsmp.png';
import konseling from '@/assets/images/therapysmp.png';
</script>

<template>
 
    <div class="w-full mx-auto md:px-20  px-5 py-10">
    <div class=" items-center justify-center px-10 ">
    <h2 class="font-bold md:text-4xl text-3xl text-center  text-(--smp) mb-5 md:mb-10">PENDIDIKAN KARAKTER</h2>
    
    <!-- <div class="">
   <img :src="imagetk" alt="logo" class="w-[70%] md:w-[300px]"/> 
  </div> -->

  <div class="container mx-auto flex flex-col md:flex-row gap-5 items-center justify-center ">

        <div class="kiri md:w-[30%] w-screen px-5 md:px-0  border-[#dae0d5]">
            <div class="text-center">
            <img :src="senam" alt="Senam"  class="w-[15%] md:w-[20%]  mx-auto  mb-2
                     transition-transform duration-300 ease-in-out hover:scale-110"/> 
            <h1 class="md:text-2xl text-xl font-semibold text-[#ab7500] mb-2">SENAM PAGI</h1>
            <h3>Membiasakan hidup sehat dan disiplin.</h3>
            </div>
        </div>
        <div class="tengah  md:w-[50%] w-screen px-5 border-x-2 border-[#dae0d5]">
            <div class="text-center">
            <img :src="pembinaan" alt="Pembinaan"  class="w-[15%] md:w-[20%]  mx-auto  mb-2
                     transition-transform duration-300 ease-in-out hover:scale-110"/> 
            <h1 class="md:text-2xl text-xl font-semibold text-[#ab7500] mb-2">PEMBINAAN KARAKTER</h1>
            <h4>Menumbuhkan sikap hormat, rasa syukur, dan nilai moral melalui kegiatan ibadah.</h4>
            </div>
        </div>
        <div class="kiri  md:w-[30%] w-screen px-5 md:px-0 ">
            <div class="text-center">
            <img :src="konseling" alt="Konseling"  class="w-[15%] md:w-[20%]   mx-auto mb-2
                     transition-transform duration-300 ease-in-out hover:scale-110"> 
            <h1 class="md:text-2xl text-xl font-semibold text-[#ab7500] mb-2">KONSELING</h1>
            <h4>Mendampingi siswa secara emosional dan sosial.</h4>
            </div>
        </div> 
    </div>
    </div>
    </div>
</template>

<style>
</style>