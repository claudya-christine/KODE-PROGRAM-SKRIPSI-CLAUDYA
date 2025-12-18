<script setup>
import { ref } from 'vue';
import opportunity from '@/assets/images/opportunity.png';
import targeting from '@/assets/images/targeting2.png';


const currentIndex = ref(0);
</script>


<template>
        <div class="container mx-auto max-w-screen-xl mt-5 bg-[#d7e5f0]
     w-full pt-5 pb-10 lg:py-20 flex flex-col md:px-10  lg:flex-row gap-5 items-center justify-center">


        <div class="mx-auto  lg:ml-15 lg:w-[700px]">
        <div class="kiri lg:text-6xl md:text-3xl text-2xl text-center lg:text-left ">
            <h1 class="font-bold text-(--primary) ">VISI & MISI <span class="font-normal">YAYASAN</span></h1>
        </div>
        </div>


        <div class="w-full  flex lg:mr-15 gap-5 lg:flex-row flex-col lg:px-0 px-5">
            <div class=" border-(--primary) border-1 lg:w-[350px] bg-[#f9fafb] rounded-tr-4xl rounded-br rounded-tl rounded-bl-4xl px-5 py-3 lg:py-5 lg:px-8 ">
                <div class="flex flex-col lg:flex-row items-center lg:items-center lg:mb-3">
                    <img :src="opportunity" alt="opportunity"  class="w-[15%] md:w-[10%] lg:w-[13%] lg:mr-3"></img>
                    <h1 class="lg:text-3xl text-2xl text-center lg:text-left  font-bold text-(--primary) ">VISI</h1>
                </div>
                
            <p class="text-justify text-sm">"Menjadi Lembaga Pendidik Yang Berkualitas, Religius, Dan Ramah Lingkungan."</p>
        </div>

        <div class="bg-(--primary)  lg:w-[350px] rounded-tr-4xl rounded-br rounded-tl rounded-bl-4xl px-5 py-3 lg:py-5 lg:px-8 ">
            <div class="flex flex-col lg:flex-row items-center lg:items-center lg:mb-3">
                <img :src="targeting" alt="targeting"  class="w-[15%] md:w-[10%] lg:w-[13%] lg:mr-3"></img>
                    <h1 class="lg:text-3xl text-2xl text-center lg:text-left  font-bold text-white ">MISI</h1>
                </div>
            <p class="text-justify text-white text-sm">
               Menyelenggarakan pendidikan yang bermutu dengan menanamkan nilai religius serta kepedulian terhadap lingkungan.</p>
            </div>

        
        
            </div>
    
         
    </div>

</template>

<style>
</style>