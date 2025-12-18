<script setup>
import { ref } from "vue";
import axios from "@/axios"; // pastikan kamu sudah punya file src/axios.js
import logo from "@/assets/logo.svg";
import Navbar from "@/components/Navbar.vue";
import Footer from "@/components/Footer.vue";

const name = ref("");
const email = ref("");
const password = ref("");
const confirmPassword = ref("");

const handleRegister = async () => {
  if (password.value !== confirmPassword.value) {
    alert("Password dan konfirmasi password tidak cocok!");
    return;
  }

  try {
    const response = await axios.post("/register", {
      name: name.value,
      email: email.value,
      password: password.value,
    });

    alert("Registrasi berhasil! 🎉");
    console.log("Response:", response.data);

    // reset form
    name.value = "";
    email.value = "";
    password.value = "";
    confirmPassword.value = "";
  } catch (error) {
    console.error("Error:", error.response?.data || error.message);
    alert(
      error.response?.data?.message ||
        "Terjadi kesalahan saat registrasi. Coba lagi nanti."
    );
  }
};
</script>

<template>
  <Navbar />
  <div class="md:min-h-screen md:py-0 py-10 flex items-center justify-center bg-gray-100">
    <div
      class="bg-blue-200 rounded-3xl shadow-lg w-[350px] md:w-[400px] p-6 flex flex-col items-center relative"
    >
      <router-link to="/Login">
        <div class="absolute top-4 bg-white px-2 rounded-full right-6">
          <button
            class="text-sm font-bold text-gray-800 cursor-pointer hover:underline"
          >
            LOGIN
          </button>
        </div>
      </router-link>

      <div class="bg-white p-4 rounded-full flex items-center justify-center">
        <img :src="logo" alt="Logo" class="w-20 h-20 object-contain" />
      </div>

      <h2 class="mt-4 text-xl font-bold text-gray-900 text-center">
        DAFTAR AKUN
      </h2>

      <form class="w-full mt-6 space-y-4" @submit.prevent="handleRegister">
        <input
          type="text"
          v-model="name"
          placeholder="USERNAME"
          required
          class="w-full px-4 py-3 rounded-full bg-white border-none focus:ring-2 focus:ring-blue-400 text-sm"
        />
        <input
          type="email"
          v-model="email"
          placeholder="EMAIL"
          required
          class="w-full px-4 py-3 rounded-full bg-white border-none focus:ring-2 focus:ring-blue-400 text-sm"
        />
        <input
          type="password"
          v-model="password"
          placeholder="PASSWORD"
          required
          class="w-full px-4 py-3 rounded-full bg-white border-none focus:ring-2 focus:ring-blue-400 text-sm"
        />
        <input
          type="password"
          v-model="confirmPassword"
          placeholder="KONFIRMASI PASSWORD"
          required
          class="w-full px-4 py-3 rounded-full bg-white border-none focus:ring-2 focus:ring-blue-400 text-sm"
        />

        <button
          type="submit"
          class="w-full cursor-pointer py-3 rounded-full bg-blue-900 text-white font-semibold hover:bg-blue-800 transition"
        >
          DAFTAR
        </button>
      </form>
    </div>
  </div>

  <Footer />
</template>

<style scoped></style>
