<script setup>
import Sidebar from "../Sidebar.vue";
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

const namaFasilitas = ref("");
const deskripsi = ref("");
const image = ref(null);
const unitPendidikan = ref("");


const previewImage = ref(null);

const unitList = ref([]);

const fetchUnits = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/v1/unit`);
    unitList.value = response.data;
  } catch (error) {
    console.error("Gagal fetch unit pendidikan:", error);
  }
};

const handleFileUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    image.value = file;

    previewImage.value = URL.createObjectURL(file);
  }
};

const addFasilitas = async () => {
  if (!namaFasilitas.value || !deskripsi.value || !image.value || !unitPendidikan.value) {
    alert("Semua kolom harus diisi!");
    return;
  }
  if (deskripsi.value.length > 255) {
    alert(`Deskripsi terlalu panjang! (${deskripsi.value.length}/255 karakter)`);
    return;
  }

  try {
    const formData = new FormData();
    formData.append("namaFasilitas", namaFasilitas.value);
    formData.append("deskripsi", deskripsi.value);
    formData.append("image", image.value);
    formData.append("unit_id", unitPendidikan.value);

    await axios.post(`${API_BASE_URL}/api/v1/fasilitas`, formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });

    alert("Data berhasil ditambahkan!");
    router.push("/tbFasilitas");

  } catch (error) {
    console.error("Error menambahkan data:", error);
    alert("Gagal menambahkan data. Periksa konsol untuk detail.");
  }
};

onMounted(() => {
  fetchUnits();
});
</script>

<template>
  <div class="flex">
    <Sidebar />
    <div
      class="mx-auto my-10 w-screen bg-white p-6 shadow-lg border border-gray-300 rounded-lg text-left max-w-xl"
    >
      <h2 class="text-2xl font-bold mb-4">Tambah Data Fasilitas</h2>

      <form @submit.prevent="addFasilitas">
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Nama Fasilitas</label>
          <input
            type="text"
            v-model="namaFasilitas"
            class="w-full p-2 border rounded-lg"
            placeholder="Masukkan Nama Fasilitas"
            required
          />
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
          <input
            type="text"
            v-model="deskripsi"
            class="w-full p-2 border rounded-lg"
            placeholder="Masukkan Deskripsi"
            required
          />      
          <p :class="deskripsi.length > 255 ? 'text-red-500' : 'text-gray-500'">
        {{ deskripsi.length }}/255 karakter
      </p>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Unit Pendidikan</label>
          <select v-model="unitPendidikan" class="w-full p-2 border rounded-lg" required>
            <option value="" disabled>Pilih unit pendidikan</option>
            <option v-for="unit in unitList" :key="unit.id" :value="unit.id">
              {{ unit.pendidikan }}
            </option>
          </select>
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

        <div v-if="previewImage" class="mb-4">
          <p class="text-gray-700 font-medium mb-2">Preview:</p>
          <img
            :src="previewImage"
            alt="Preview"
            class="w-full h-48 object-cover rounded-lg border"
          />
        </div>

        <div class="mt-6">
          <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
          >
            Tambah
          </button>

          <router-link to="/tbFasilitas" class="ml-4 text-gray-500 hover:underline">
            Batal
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>
