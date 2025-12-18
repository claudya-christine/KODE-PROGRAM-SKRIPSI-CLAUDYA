<script setup>
import { ref, computed } from "vue";
import logo from "@/assets/logo.svg";
import { useRouter, useRoute } from "vue-router";
import axios from "axios";
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;


const router = useRouter();
const route = useRoute(); 

const showUnitSubmenu = ref(false);
const showBeritaSubmenu = ref(false);

const isActive = (path) => route.path === path; 

const toggleUnitSubmenu = () => {
  showUnitSubmenu.value = !showUnitSubmenu.value;
};

const toggleBeritaSubmenu = () => {
  showBeritaSubmenu.value = !showBeritaSubmenu.value;
};

const handleLogout = async () => {
  const confirmLogout = window.confirm("Apakah Anda yakin ingin logout?");
  if (!confirmLogout) return;

  try {
    const token = localStorage.getItem("token");
    await axios.post(
  `${API_BASE_URL}/api/logout`,
      {},
      {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      }
    );

    localStorage.clear();
    alert("Berhasil logout! ");
    router.push("/Login");
  } catch (error) {
    console.error("Logout error:", error.response?.data || error.message);
    alert("Terjadi kesalahan saat logout. Coba lagi nanti.");
  }
};
</script>




<template>
  <div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-[#112B55] text-white flex flex-col justify-between shadow-xl">
      <div>
        <!-- Header Logo -->
        <div class="p-4 flex items-center space-x-2 border-b border-gray-600">
          <img :src="logo" alt="Logo" class="w-10 h-10 rounded-full" />
          <h1 class="font-bold text-sm leading-tight">YAYASAN HOSANA TEBAS</h1>
        </div>

        <!-- Navigation -->
        <nav class="my-4 space-y-1">
             <router-link to="/admin">
          <button
                :class="[
                'flex items-center w-full px-5 py-2 rounded cursor-pointer',
                isActive('/admin') ? 'bg-[#294d87]' : 'hover:bg-[#294d87]'
                ]"
            >
            <i class="ri-dashboard-line mr-3 text-lg"></i> DASHBOARD
          </button>
            </router-link>

          <router-link to="/tbBanner">
                    <button
                :class="[
                'flex items-center w-full px-5 py-2 rounded cursor-pointer',
                isActive('/tbBanner') ? 'bg-[#294d87]' : 'hover:bg-[#294d87]'
                ]"
            >
            <i class="ri-image-line mr-3 text-lg"></i> BANNER
          </button>
        </router-link>
          
        <router-link to="/tbStatistic">
            <button
                :class="[
                'flex items-center w-full px-5 py-2 rounded cursor-pointer',
                isActive('/tbStatistic') ? 'bg-[#294d87]' : 'hover:bg-[#294d87]'
                ]"
            >
            <i class="ri-bar-chart-2-line mr-3 text-lg"></i> STATISTIK
          </button>
        </router-link>

          <!-- <button class="flex items-center w-full px-5 py-2 hover:bg-[#294d87] cursor-pointer
                  isActive('/tbBanner') ? 'bg-[#294d87]' : 'hover:bg-[#294d87]'">
            <i class="ri-information-line mr-3 text-lg"></i> INFORMASI YAYASAN
          </button> -->

        <!-- UNIT PENDIDIKAN -->
        <div>
          <button
            @click="toggleUnitSubmenu"
            class="flex items-center justify-between w-full px-5 py-2 hover:bg-[#294d87] cursor-pointer"
          >
            <div class="flex items-center">
              <i class="ri-school-line mr-3 text-lg"></i>
              UNIT PENDIDIKAN
            </div>
            <i
              :class="[
                'ri-arrow-up-s-line transition-transform duration-200',
                showUnitSubmenu ? 'rotate-180' : 'rotate-0'
              ]"
            ></i>
          </button>
 
          <transition name="fade">
            <div v-if="showUnitSubmenu" class="ml-10 mt-1 space-y-1">
            <router-link to="/tbKegiatan">
                          <button :class="[
                                  'flex items-center w-full px-5 py-2 rounded cursor-pointer',
                                  isActive('/tbKegiatan') ? 'bg-[#294d87]' : 'hover:bg-[#294d87]'
                                  ]">KEGIATAN</button>
                          </router-link>
            <router-link to="/tbFasilitas">
                          <button :class="[
                                  'flex items-center w-full px-5 py-2 rounded cursor-pointer',
                                  isActive('/tbFasilitas') ? 'bg-[#294d87]' : 'hover:bg-[#294d87]'
                                  ]">FASILITAS</button>
            </router-link>
            </div>
          </transition>
        </div>

      <router-link to="/tbGuruStaff">
                <button :class="[
                      'flex items-center w-full px-5 py-2 rounded cursor-pointer',
                      isActive('/tbGuruStaff') ? 'bg-[#294d87]' : 'hover:bg-[#294d87]'
                      ]">
                  <i class="ri-team-line mr-3 text-lg"></i> GURU DAN STAFF
                </button>
                </router-link>

          <div>
          <button
            @click="toggleBeritaSubmenu"
            class="flex items-center justify-between w-full px-5 py-2 hover:bg-[#294d87] cursor-pointer"
          >
            <div class="flex items-center">
              <i class="ri-article-line mr-3 text-lg"></i>
              BERITA
            </div>
            <i
              :class="[
                'ri-arrow-up-s-line transition-transform duration-200',
                showBeritaSubmenu ? 'rotate-180' : 'rotate-0'
              ]"
            ></i>
          </button>

          <transition name="fade">
            <div v-if="showBeritaSubmenu" class="ml-10 mt-1 space-y-1">
              <router-link to="/tbBerita">
              <button :class="[
                      'flex items-center w-full px-5 py-2 rounded cursor-pointer',
                      isActive('/tbBerita') ? 'bg-[#294d87]' : 'hover:bg-[#294d87]'
                      ]">INPUT BERITA</button>
              </router-link>
              <router-link to="/tbKategori">
              <button :class="[
                      'flex items-center w-full px-5 py-2 rounded cursor-pointer',
                      isActive('/tbKategori') ? 'bg-[#294d87]' : 'hover:bg-[#294d87]'
                      ]">KATEGORI BERITA</button>
              </router-link>
            </div>
          </transition>
        </div>

          <router-link to="/tbAlumni">
          <button :class="[
                'flex items-center w-full px-5 py-2 rounded cursor-pointer',
                isActive('/tbAlumni') ? 'bg-[#294d87]' : 'hover:bg-[#294d87]'
                ]">
            <i class="ri-graduation-cap-line mr-3 text-lg"></i> INFORMASI ALUMNI
          </button>
          </router-link>

          <router-link to="/tbKontak">
          <button :class="[
                'flex items-center w-full px-5 py-2 rounded cursor-pointer',
                isActive('/tbKontak') ? 'bg-[#294d87]' : 'hover:bg-[#294d87]'
                ]">
            <i class="ri-phone-line mr-3 text-lg"></i> KONTAK
          </button>
          </router-link>
          
          <router-link to="/Menutanggapan">
          <button :class="[
                'flex items-center w-full px-5 py-2 rounded cursor-pointer',
                isActive('/Menutanggapan') ? 'bg-[#294d87]' : 'hover:bg-[#294d87]'
                ]">
            <i class="ri-message-3-line mr-3 text-lg"></i> TANGGAPAN
          </button>
          </router-link>

          <router-link to="/">
          <button class="flex items-center w-full px-5 py-2 hover:bg-[#294d87] cursor-pointer">
            <i class="ri-window-line mr-3 text-lg"></i> HOME WEBSITE
          </button>
          </router-link>
        </nav>
      </div>
      
      <button
        @click="handleLogout"
        class="flex items-center justify-center cursor-pointer space-x-2 py-3 bg-red-700 hover:bg-red-500"
      >
        <i class="ri-logout-box-r-line"></i>
        <span>LOGOUT</span>
      </button>
    </aside>
  </div>
  
</template>

<style>
@import url("https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css");

.fade-enter-active,
.fade-leave-active {
  transition: all 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(-5px);
}
</style>
