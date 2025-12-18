<script setup>
import Sidebar from "../Sidebar.vue";
import { ref, onMounted } from "vue";
import axios from "axios";
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

import { useRoute, useRouter } from "vue-router";

const route = useRoute();
const router = useRouter();

const guruStaffId = ref(route.params.id);

const staffID = ref("");
const namalengkap = ref("");
const posisi = ref("");
const tanggal_lahir = ref("");
const unitPendidikan = ref("");
const image = ref(null); 
const currentImage = ref(null); 
const previewImage = ref(null); 

const unitList = ref([]);

const handleFileUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    image.value = file;
    previewImage.value = URL.createObjectURL(file);
  }
};

const fetchUnits = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/v1/unit`);
    unitList.value = response.data;
  } catch (error) {
    console.error("Gagal fetch unit pendidikan:", error);
  }
};

const fetchGuruStaff = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/v1/gurustaff/${guruStaffId.value}`);
    staffID.value = response.data.staffID;
    namalengkap.value = response.data.namalengkap;
    tanggal_lahir.value = response.data.tanggal_lahir;
    posisi.value = response.data.posisi;
    unitPendidikan.value = response.data.unit_id;
    currentImage.value = response.data.image; // simpan gambar lama
  } catch (error) {
    console.error("Gagal fetch detail guru/staff:", error);
    alert("Gagal memuat data guru/staff.");
  }
};

const updateGuruStaff = async () => {
  if (!staffID.value || !namalengkap.value || !tanggal_lahir.value || !posisi.value || !unitPendidikan.value) {
    alert("Semua kolom harus diisi!");
    return;
  }

  try {
    const formData = new FormData();
    formData.append("staffID", staffID.value);
    formData.append("namalengkap", namalengkap.value);
    formData.append("tanggal_lahir", tanggal_lahir.value);
    formData.append("posisi", posisi.value);
    formData.append("unit_id", unitPendidikan.value);

    if (image.value) {
      formData.append("image", image.value);
    }

    await axios.post(`${API_BASE_URL}/api/v1/gurustaff/${guruStaffId.value}?_method=PUT`, formData, {
      headers: { "Content-Type": "multipart/form-data" },
    });

    alert("Data berhasil diperbarui!");
    router.push("/tbGuruStaff");
  } catch (error) {
    console.error("Gagal memperbarui data:", error);
    alert("Gagal memperbarui data. Periksa konsol untuk detail.");
  }
};

onMounted(() => {
  fetchUnits();
  fetchGuruStaff();
});
</script>

<template>
  <div class="flex">
    <Sidebar />
    <div class="mx-auto my-10 w-screen bg-white p-6 shadow-lg border border-gray-300 rounded-lg text-left max-w-xl">
      <h2 class="text-2xl font-bold mb-4">Edit Data Guru & Staff</h2>

      <form @submit.prevent="updateGuruStaff">
        <!-- ID Staff -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">ID Guru/Staff</label>
          <input
            type="text"
            v-model="staffID"
            class="w-full p-2 border rounded-lg"
            readonly
          />
        </div>

        <!-- Nama -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
          <input
            type="text"
            v-model="namalengkap"
            class="w-full p-2 border rounded-lg"
            required
          />
        </div>

        <!-- Tanggal Lahir -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Tanggal Lahir</label>
          <input
            type="date"
            v-model="tanggal_lahir"
            class="w-full p-2 border rounded-lg"
            required
          />
        </div>

        <!-- Posisi -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Posisi</label>
          <input
            type="text"
            v-model="posisi"
            class="w-full p-2 border rounded-lg"
            required
          />
        </div>

        <!-- Upload Foto -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Upload Foto</label>
          <input
            type="file"
            @change="handleFileUpload"
            accept="image/*"
            class="w-full p-2 border rounded-lg"
          />
        </div>

        <!-- Preview -->
        <div class="mb-4">
          <p class="text-gray-700 font-medium mb-2">Preview:</p>

          <img
            v-if="previewImage"
            :src="previewImage"
            alt="Preview"
            class="w-full h-48 object-cover rounded-lg border"
          />

          <img
            v-else-if="currentImage"
            :src="`${API_BASE_URL}/storage/${currentImage}`"
            alt="Current Image"
            class="w-full h-48 object-cover rounded-lg border"
          />

          <span v-else class="text-gray-400 italic">Tidak ada gambar</span>
        </div>

        <!-- Unit Pendidikan -->
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

        <!-- Tombol -->
        <div class="mt-6">
          <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
          >
            Simpan Perubahan
          </button>

          <router-link
            to="/tbGuruStaff"
            class="ml-4 text-gray-500 hover:underline"
          >
            Batal
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>
