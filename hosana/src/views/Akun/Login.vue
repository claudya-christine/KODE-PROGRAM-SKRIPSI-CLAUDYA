<script setup>
import { ref } from "vue";
import axios from "@/axios";
import logo from "@/assets/logo.svg";
import Navbar from "@/components/Navbar.vue";
import Footer from "@/components/Footer.vue";
import { useRouter } from "vue-router";
const email = ref("");
const password = ref("");
const router = useRouter();
const handleLogin = async () => {
  try {
    const response = await axios.post("/login", {
      email: email.value,
      password: password.value,
    });

    localStorage.setItem("token", response.data.access_token);
    localStorage.setItem("user", JSON.stringify(response.data.user));
    localStorage.setItem("userRole", response.data.user.role);
    localStorage.setItem("userId", response.data.user.id);
    alert("Login berhasil! ");

    if (response.data.user.role === "admin") {
      router.push({ name: "Menudashboard" }); 
    } else {
      router.push({ path: "/" });
    }

  } catch (error) {
    console.error("Error:", error.response?.data || error.message);
    alert(
      error.response?.data?.message ||
        "Email atau password salah. Coba lagi."
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
      <router-link to="/DaftarAkun">
        <div class="absolute top-4 bg-white px-2 rounded-full right-6">
          <button
            class="text-sm font-bold text-gray-800 cursor-pointer hover:underline"
          >
            REGISTER
          </button>
        </div>
      </router-link>

      <div class="bg-white p-4 rounded-full flex items-center justify-center">
        <img :src="logo" alt="Logo" class="w-20 h-20 object-contain" />
      </div>

      <h2 class="mt-4 text-xl font-bold text-gray-900 text-center">
        LOGIN AKUN
      </h2>

      <form class="w-full mt-6 space-y-4" @submit.prevent="handleLogin">
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

        <button
          type="submit"
          class="w-full py-3 cursor-pointer rounded-full bg-blue-900 text-white font-semibold hover:bg-blue-800 transition"
        >
          Login
        </button>
      </form>
    </div>
  </div>

  <Footer />
</template>

<style scoped></style>
