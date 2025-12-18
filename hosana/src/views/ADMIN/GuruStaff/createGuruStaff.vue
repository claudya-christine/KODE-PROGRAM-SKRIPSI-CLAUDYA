<script setup>
import Sidebar from "../Sidebar.vue";
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

const staffID = ref("");
const namalengkap = ref(""); 
const posisi = ref(""); 
const tanggal_lahir = ref(""); 
const image = ref(null);
const unitPendidikan = ref(""); 
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

const addGuruStaff = async () => {
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

    await axios.post(`${API_BASE_URL}/api/v1/gurustaff`, formData, {
      headers: { "Content-Type": "multipart/form-data" },
    });

    alert("Data berhasil ditambahkan!");
       router.push("/tbGuruStaff");

  } catch (error) {
    console.error("Error menambahkan data:", error);

    if (error.response?.status === 422) {
      const errors = error.response.data.errors;

      if (errors?.staffID) {
        alert(" ID Guru/Staff sudah digunakan. Silakan pakai ID lain!");
      } else {
        alert(" Gagal menambahkan data. Periksa input Anda.");
      }}
  }
};


onMounted(() => {
  fetchUnits();
});
</script>


<template>
  <div class="flex">
    <Sidebar />
    <div class="mx-auto my-10 w-screen bg-white p-6 shadow-lg border border-gray-300 rounded-lg text-left max-w-xl">
      <h2 class="text-2xl font-bold mb-4">Tambah Data Guru dan Staff</h2>

      <form @submit.prevent="addGuruStaff">
        
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">ID Guru atau Staff</label>
          <input
            type="text"
            v-model="staffID"
            class="w-full p-2 border rounded-lg"
            placeholder="Masukkan ID Staff atau Guru"
            required
          />
        </div>
        
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
          <input
            type="text"
            v-model="namalengkap"
            class="w-full p-2 border rounded-lg"
            placeholder="Masukkan Nama Lengkap"
            required
          />
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Tanggal Lahir</label>
          <input
            type="date"
            v-model="tanggal_lahir"
            class="w-full p-2 border rounded-lg"
            placeholder="Masukkan Tanggal Lahir"
            required
          />
        </div>
        
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Posisi</label>
          <input
            type="text"
            v-model="posisi"
            class="w-full p-2 border rounded-lg"
            placeholder="Masukkan Posisi"
            required
          />
        </div>

              <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">Upload Foto</label>
        <input
          type="file"
          @change="handleFileUpload"
          accept="image/*"
          class="w-full p-2 border rounded-lg"
          required
        />
      </div>

      <!-- Preview -->
      <div v-if="previewImage" class="mb-4">
        <p class="text-gray-700 font-medium mb-2">Preview:</p>
        <img
          :src="previewImage"
          alt="Preview"
          class="w-full h-48 object-cover rounded-lg border"
        />
      </div>

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
            Tambah
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

<style scoped>
</style>
