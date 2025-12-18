<script setup>
import Sidebar from "../Sidebar.vue";
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router"; 
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

const router = useRouter(); 

const judul = ref("");
const isi = ref("");
const penulis = ref("");
const tanggal_berita = ref("");
const kategoriList = ref([]);
const selectedKategori = ref([]);
const mediaFiles = ref([]);
const mediaPreviews = ref([]);

onMounted(async () => {
  try {
    const res = await axios.get(`${API_BASE_URL}/api/v1/kategori`);
    kategoriList.value = res.data;
  } catch (error) {
    console.error("Gagal ambil data kategori:", error);
  }
});

const handleMediaUpload = (event) => {
  const files = event.target.files;
  mediaFiles.value = Array.from(files);
  mediaPreviews.value = Array.from(files).map((file) =>
    file.type.startsWith("image/") ? URL.createObjectURL(file) : null
  );
};

const addBerita = async () => {
  if (!judul.value || !isi.value || !tanggal_berita.value) {
    alert("Lengkapi semua data berita terlebih dahulu!");
    return;
  }

  if (mediaFiles.value.length === 0) {
    alert("Harap upload minimal satu media (gambar)!");
    return;
  }

  try {
    const formData = new FormData();
    formData.append("judul", judul.value);
    formData.append("isi", isi.value);
    formData.append("penulis", penulis.value);
    formData.append("tanggal_berita", tanggal_berita.value);

    selectedKategori.value.forEach((id) =>
      formData.append("kategori_id[]", id)
    );

    mediaFiles.value.forEach((file) => {
      formData.append("media[]", file);
    });

    await axios.post(`${API_BASE_URL}/api/v1/berita`, formData, {
      headers: { "Content-Type": "multipart/form-data" },
    });

    alert("Berita berhasil ditambahkan!");
    router.push("/tbBerita");
  } catch (error) {
    console.error("Error saat tambah berita:", error);
    alert("Gagal menambahkan berita. Periksa konsol untuk detail.");
  }
};

</script>

<template>
  <div class="flex">
    <Sidebar />
    <div
      class="mx-auto my-10 w-screen bg-white p-6 shadow-lg border rounded-lg text-left max-w-3xl"
    >
      <h2 class="text-2xl font-bold mb-6">Tambah Berita</h2>

      <form @submit.prevent="addBerita">
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Judul Berita</label>
          <input
            v-model="judul"
            type="text"
            class="w-full p-2 border rounded-lg"
            placeholder="Masukkan judul berita"
            required
          />
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Isi Berita</label>
          <textarea
            v-model="isi"
            rows="5"
            class="w-full p-2 border rounded-lg"
            placeholder="Tulis isi berita..."
            required
          ></textarea>
        </div>
<!-- 
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Penulis</label>
          <input
            v-model="penulis"
            type="text"
            class="w-full p-2 border rounded-lg"
            placeholder="Nama penulis (opsional)"
          />
        </div> -->

        <!-- Tanggal Berita -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Tanggal Berita</label>
          <input
            v-model="tanggal_berita"
            type="date"
            class="w-full p-2 border rounded-lg"
            required
          />
        </div>

        
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2">Kategori Berita</label>
          <div class="flex flex-wrap gap-4">
            <label
              v-for="kategori in kategoriList"
              :key="kategori.id"
              class="flex items-center space-x-2 cursor-pointer"
            >
              <input type="checkbox" :value="kategori.id" v-model="selectedKategori" />
              <span>{{ kategori?.nama_kategori }}</span>
            </label>
          </div>
        </div>

        <!-- Upload Media -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2"
            >Upload Media (hanya foto)</label
          >
          <input
            type="file"
            multiple
            accept="image/*,video/mp4"
            @change="handleMediaUpload"
            class="w-full p-2 border rounded-lg"
          />
        </div>

        <!-- Preview Media -->
        <div v-if="mediaPreviews.length" class="grid grid-cols-2 gap-4 mb-4">
          <div
            v-for="(preview, index) in mediaPreviews"
            :key="index"
            class="border rounded-lg p-2"
          >
            <template v-if="preview">
              <img
                :src="preview"
                alt="Preview"
                class="w-full h-40 object-cover rounded-lg"
              />
            </template>
            <template v-else>
              <p class="text-gray-500 text-center">🎬 File video</p>
            </template>
          </div>
        </div>

        <!-- Tombol -->
        <div class="mt-6">
          <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
          >
            Tambah
          </button>
          <router-link to="/tbBerita" class="ml-4 text-gray-500 hover:underline">
            Batal
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>
