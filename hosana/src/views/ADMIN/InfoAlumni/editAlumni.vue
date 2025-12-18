<script setup>
import Sidebar from "../Sidebar.vue";
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRoute, useRouter } from "vue-router";
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

const route = useRoute();
const router = useRouter();

const alumniId = ref(route.params.id); 
const generasi = ref(""); 
const unitPendidikan = ref(""); 
const linkGrup = ref(""); 

const unitList = ref([]); 

const fetchUnits = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/v1/unit`); 
    unitList.value = response.data;
  } catch (error) {
    console.error("Gagal fetch unit pendidikan:", error);
  }
};

const fetchAlumni = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/v1/alumni/${alumniId.value}`);
    generasi.value = response.data.generasi;
    unitPendidikan.value = response.data.unit_id;
    linkGrup.value = response.data.link;
  } catch (error) {
    console.error("Gagal fetch detail alumni:", error);
    alert("Gagal memuat data alumni.");
  }
};

// Update data alumni
const updateAlumni = async () => {
  if (!generasi.value || !unitPendidikan.value || !linkGrup.value) {
    alert("Semua kolom harus diisi!");
    return;
  }

  try {
    const payload = {
      generasi: generasi.value,
      unit_id: unitPendidikan.value,
      link: linkGrup.value,
    };

    await axios.put(`${API_BASE_URL}/api/v1/alumni/${alumniId.value}`, payload);

    alert("Data alumni berhasil diperbarui!");
    router.push("/tbAlumni");
  } catch (error) {
    console.error("Gagal memperbarui alumni:", error);
    alert("Gagal memperbarui data. Periksa konsol untuk detail.");
  }
};

onMounted(() => {
  fetchUnits();
  fetchAlumni();
});
</script>

<template>
  <div class="flex">
    <Sidebar />
    <div class="mx-auto my-10 w-screen bg-white p-6 shadow-lg border border-gray-300 rounded-lg text-left max-w-xl">
      <h2 class="text-2xl font-bold mb-4">Edit Data Alumni</h2>

      <form @submit.prevent="updateAlumni">
        <!-- Generasi -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Generasi Ke-</label>
          <input
            type="number"
            v-model="generasi"
            class="w-full p-2 border rounded-lg"
            placeholder="Masukkan generasi"
            required
          />
        </div>

        <!-- Dropdown Unit Pendidikan -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Unit Pendidikan</label>
          <select
            v-model="unitPendidikan"
            class="w-full p-2 border rounded-lg"
            required
          >
            <option value="" disabled>Pilih unit pendidikan</option>
            <option v-for="unit in unitList" :key="unit.id" :value="unit.id">
              {{ unit.pendidikan }}
            </option>
          </select>
        </div>

        <!-- Link Grup WhatsApp -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Link Grup WhatsApp</label>
          <input
            type="text"
            v-model="linkGrup"
            class="w-full p-2 border rounded-lg"
            placeholder="Masukkan link grup WhatsApp"
            required
          />
        </div>

        <!-- Tombol -->
        <div class="mt-6">
          <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
          >
            Simpan Perubahan
          </button>

          <router-link
            to="/tbAlumni"
            class="ml-4 text-gray-500 hover:underline"
          >
            Batal
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
</style>
