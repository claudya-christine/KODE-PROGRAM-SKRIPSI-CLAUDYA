<script setup>
import Sidebar from "../Sidebar.vue";
import axios from "axios";
import { ref, onMounted } from "vue";

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;
const users = ref([]);

const fetchUsers = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/v1/users`);
    users.value = response.data;
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

onMounted(() => {
  fetchUsers();
});
</script>

<template>
  <div class="flex">
    <Sidebar />

    <div class="w-screen p-6">
      <h2 class="text-left text-2xl font-bold mb-6">DAFTAR USER</h2>

      <div class="relative overflow-x-auto shadow-md">
        <table class="w-full text-sm text-left rtl:text-right border-collapse border border-gray-400">
          <thead class="text-xs uppercase text-center">
            <tr>
              <th class="px-6 py-3 border border-gray-300">No</th>
              <th class="px-6 py-3 border border-gray-300">Nama Akun</th>
              <th class="px-6 py-3 border border-gray-300">Email</th>
            </tr>
          </thead>

          <tbody v-if="users && users.length">
            <tr
              v-for="(user, index) in users"
              :key="user.id"
              class="border-b border-gray-200 hover:bg-gray-100"
            >
              <td class="px-4 text-center py-3 border border-gray-300">{{ index + 1 }}</td>
              <td class="px-4 text-center py-3 border border-gray-300">{{ user.name }}</td>
              <td class="px-4 text-center py-3 border border-gray-300">{{ user.email }}</td>
            </tr>
          </tbody>

          <tbody v-else>
            <tr>
              <td colspan="3" class="text-center py-3 text-gray-500">
                Tidak ada data user
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <footer class="text-center text-white bg-(--primary) py-3 text-sm">
    © 2025 Yayasan Hosana Tebas. All Rights Reserved.
  </footer>
</template>

<style scoped>
</style>
