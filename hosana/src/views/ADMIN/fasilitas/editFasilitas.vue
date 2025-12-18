<script setup>
import Sidebar from "../Sidebar.vue";
import { ref, onMounted } from "vue";
import axios from "axios";
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

import { useRoute, useRouter } from "vue-router";

const route = useRoute();
const router = useRouter();

const fasilitasId = ref(route.params.id); 

const namaFasilitas = ref("");
const deskripsi = ref("");
const unitPendidikan = ref("");
const image = ref(null);

const previewImage = ref(null);
const oldImageUrl = ref(null);

const unitList = ref([]);

const fetchUnits = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/v1/unit`);
    unitList.value = response.data;
  } catch (error) {
    console.error("Gagal fetch unit pendidikan:", error);
  }
};

const fetchFasilitas = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/v1/fasilitas/${fasilitasId.value}`);
    const data = response.data;
    namaFasilitas.value = data.namaFasilitas;
    deskripsi.value = data.deskripsi;
    unitPendidikan.value = data.unit_id;

    oldImageUrl.value = data.image ? `${API_BASE_URL}/storage/${data.image}` : null;
  } catch (error) {
    console.error("Gagal fetch detail fasilitas:", error);
    alert("Gagal memuat data fasilitas.");
  }
};

const handleFileUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    image.value = file;
    previewImage.value = URL.createObjectURL(file);
  }
};

const updateFasilitas = async () => {
  if (!namaFasilitas.value || !deskripsi.value || !unitPendidikan.value) {
    alert("Semua kolom harus diisi!");
    return;
  }

  try {
    const formData = new FormData();
    formData.append("namaFasilitas", namaFasilitas.value);
    formData.append("deskripsi", deskripsi.value);
    formData.append("unit_id", unitPendidikan.value);

    if (image.value) {
      formData.append("image", image.value);
    }

    await axios.post(
      `${API_BASE_URL}/api/v1/fasilitas/${fasilitasId.value}?_method=PUT`,
      formData,
      {
        headers: { "Content-Type": "multipart/form-data" },
      }
    );

    alert("Data fasilitas berhasil diperbarui!");
    router.push("/tbFasilitas");
  } catch (error) {
    console.error("Gagal memperbarui data fasilitas:", error);
    alert("Gagal memperbarui data. Periksa konsol untuk detail.");
  }
};

onMounted(() => {
  fetchUnits();
  fetchFasilitas();
});
</script>

<template>
  <div class="flex">
    <Sidebar />
    <div
      class="mx-auto my-10 w-screen bg-white p-6 shadow-lg border border-gray-300 rounded-lg text-left max-w-xl"
    >
      <h2 class="text-2xl font-bold mb-4">Edit Data Fasilitas</h2>

      <form @submit.prevent="updateFasilitas">
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
          <label class="block text-gray-700 font-medium mb-2">Ganti Foto (Opsional)</label>
          <input
            type="file"
            @change="handleFileUpload"
            accept="image/*"
            class="w-full p-2 border rounded-lg"
          />
        </div>

        <div v-if="oldImageUrl && !previewImage" class="mb-4">
          <p class="text-gray-700 font-medium mb-2">Foto Saat Ini:</p>
          <img
            :src="oldImageUrl"
            alt="Foto Lama"
            class="w-full h-48 object-cover rounded-lg border"
          />
        </div>

        <div v-if="previewImage" class="mb-4">
          <p class="text-gray-700 font-medium mb-2">Preview Foto Baru:</p>
          <img
            :src="previewImage"
            alt="Preview Baru"
            class="w-full h-48 object-cover rounded-lg border"
          />
        </div>

        <div class="mt-6">
          <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
          >
            Simpan Perubahan
          </button>

          <router-link
            to="/tbFasilitas"
            class="ml-4 text-gray-500 hover:underline"
          >
            Batal
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>
