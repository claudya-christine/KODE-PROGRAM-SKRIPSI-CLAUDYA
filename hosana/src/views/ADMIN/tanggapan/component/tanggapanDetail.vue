<script setup>
import Sidebar from '../../Sidebar.vue';
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from '@/axios';
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

const route = useRoute();
const beritaId = route.params.id;

const berita = ref(null);
const komentarList = ref([]);
const newTanggapan = ref('');
const selectedKomentarId = ref(null);
const admin = ref(null);
const selectedMedia = ref(null); 

const fetchAdmin = async () => {
  try {
    const res = await axios.get('user-profile');
    admin.value = res.data;
  } catch (err) {
    console.error('Gagal fetch admin:', err);
  }
};

const fetchBeritaDetail = async () => {
  try {
    const res = await axios.get(`/v1/berita/${beritaId}`);
    berita.value = res.data;
    komentarList.value = res.data.komentar;

    if (berita.value.media && berita.value.media.length > 0) {
      selectedMedia.value = berita.value.media[0];
    }
  } catch (err) {
    console.error("Gagal fetch berita:", err);
  }
};

const sendTanggapan = async (komentarId) => {
  if (!newTanggapan.value) return;
  try {
    const res = await axios.post('/v1/tanggapan', {
      komentar_id: komentarId,
      isi: newTanggapan.value,
    });

    const kom = komentarList.value.find((k) => k.id === komentarId);
    if (!kom.tanggapan) kom.tanggapan = [];
    kom.tanggapan.push({
      ...res.data,
      admin: { name: admin.value?.name || 'Admin' },
    });

    newTanggapan.value = '';
    selectedKomentarId.value = null;
  } catch (err) {
    console.error('Gagal kirim tanggapan:', err);
  }
};

const approveKomentar = async (id) => {
  try {
    await axios.patch(`/v1/komentar/${id}/approve`);
    const kom = komentarList.value.find(k => k.id === id);
    if (kom) kom.status = 'approved';
  } catch (err) {
    console.error('Gagal approve komentar:', err);
  }
};



const deleteKomentar = async (komentarId) => {
  if (!confirm('Yakin ingin menghapus komentar ini?')) return;
  try {
    await axios.delete(`/v1/komentar/${komentarId}`);
    komentarList.value = komentarList.value.filter(k => k.id !== komentarId);
  } catch (err) {
    console.error('Gagal hapus komentar:', err);
  }
};

const deleteTanggapan = async (tanggapanId, komentarId) => {
  if (!confirm('Yakin ingin menghapus tanggapan ini?')) return;
  try {
    await axios.delete(`/v1/tanggapan/${tanggapanId}`);
    const kom = komentarList.value.find(k => k.id === komentarId);
    if (kom && kom.tanggapan) {
      kom.tanggapan = kom.tanggapan.filter(t => t.id !== tanggapanId);
    }
  } catch (err) {
    console.error('Gagal hapus tanggapan:', err);
  }
};


const formatTanggal = (tanggal) => {
  if (!tanggal) return '';
  const date = new Date(tanggal);
  return date.toLocaleString("id-ID", {
    day: "2-digit",
    month: "short",
    year: "numeric",

  });
};
onMounted(() => {
  fetchAdmin();
  fetchBeritaDetail();
});
</script>

<template>
  <div class="flex">
    <Sidebar />

    <div class="w-full bg-gray-100 min-h-screen p-6">
      <h1 class="text-2xl font-bold mb-6">TANGGAPAN</h1>

      <div class="flex gap-6">
        <!-- BERITA -->
        <div class="flex-1 space-y-4" v-if="berita">
          <!-- Gambar/Video Utama -->
<div v-if="selectedMedia" class="mb-4">
  <img
    v-if="selectedMedia.tipe === 'foto'"
    :src="`${API_BASE_URL}/storage/${selectedMedia.file_path}`"
    alt="Media Utama"
    class="w-full h-64 object-cover rounded-xl shadow-md"
  />

  <!-- <video
    v-else
    controls
    class="w-full h-64 object-cover rounded-xl shadow-md"
  >
    <source
      :src="`${API_BASE_URL}/storage/${selectedMedia.file_path}`"
      type="video/mp4"
    />
  </video> -->
</div>

<!-- Thumbnail -->
<div class="flex space-x-3 overflow-x-auto pb-2"
     v-if="berita.media && berita.media.length > 1">
  <div
    v-for="(item, index) in berita.media"
    :key="index"
    @click="selectedMedia = item"
    class="relative cursor-pointer flex-shrink-0 w-1/4"
  >
    <template v-if="item.tipe === 'foto'">
      <img
        :src="`${API_BASE_URL}/storage/${item.file_path}`"
        class="rounded-lg shadow w-full transition hover:grayscale-0 duration-200"
        :class="selectedMedia.file_path === item.file_path ? 'ring-2 ring-blue-500' : 'grayscale'"
      />
    </template>

    <template v-else>
      <video
        :src="`${API_BASE_URL}/storage/${item.file_path}`"
        muted
        class="rounded-lg shadow w-full grayscale"
      ></video>
      <div
        class="absolute inset-0 flex items-center justify-center"
      >
        <i class="ri-play-fill text-white text-2xl"></i>
      </div>
    </template>
  </div>
</div>


          <div class="bg-white rounded-xl p-4 shadow">
            <div class="flex justify-between items-center text-gray-500 text-sm mb-2">
        <div class="flex items-center space-x-2 text-gray-600 mb-2">
            <div class="w-5 h-5 text-red-500">
              <i class="ri-calendar-line"></i>
            </div>
      <span class="mt-1">{{ formatTanggal(berita.tanggal_berita) }}</span>
          </div>  <br>           
          <span>{{ berita.kategoris.map(k => k.nama_kategori).join(', ') }}</span>
            </div>
            <p class="font-semibold mb-2">{{ berita.judul }}</p>
            <p class="text-gray-600 text-sm whitespace-pre-line">{{ berita.isi }}</p>
          </div>
        </div>

        <!-- KOMENTAR -->
        <div class="w-96 bg-white rounded-xl p-4 shadow flex flex-col">
          <h2 class="font-bold mb-4">KOMENTAR</h2>

          <div
            v-for="c in komentarList"
            :key="c.id"
            class="flex flex-col gap-2 mb-4 border-b pb-3 group relative"
          >
            <div class="flex items-start gap-2">
              <div class="w-8 h-8 rounded-full bg-gray-300"></div>
              <div class="flex-1">
                <div class="flex justify-between items-center">
                  <p class="font-semibold text-gray-700">
                    {{ c.user?.name || 'User' }}
                  </p>

                  <!-- Tombol Hapus Komentar -->
                  <button
                    v-if="admin"
                    @click="deleteKomentar(c.id)"
                    class="text-red-500 hover:text-red-700 cursor-pointer opacity-0 group-hover:opacity-100 transition"
                    title="Hapus komentar"
                  >
                            <i class="ri-delete-bin-5-fill text-lg"></i>

                  </button>
                </div>

                <p class="text-gray-600 text-sm">{{ c.isi_komentar }}</p>

                <!-- Tombol Balas -->
                <button
                v-if="c.status === 'approved'"
                class="text-gray-400 hover:text-gray-600 text-sm mt-1"
                @click="selectedKomentarId = c.id"
              >
                ↩ Balas
              </button>


                <div class="flex gap-2 mt-1" v-if="c.status === 'pending'">
          <button
            @click="approveKomentar(c.id)"
            class="text-green-600 text-sm hover:underline cursor-pointer"
          >
            ✔ Approve
          </button>

          
        </div>

                <!-- DAFTAR TANGGAPAN -->
                <div
                  v-for="t in c.tanggapan || []"
                  :key="t.id"
                  class="ml-6 mt-2 flex items-start gap-2 group relative"
                >
                  <div class="w-8 h-8 rounded-full bg-blue-300"></div>
                  <div class="flex-1">
                    <div class="flex justify-between items-center">
                      <p class="font-semibold text-blue-600 text-sm">
                        {{ t.admin?.name || 'Admin' }}
                      </p>

                      <!-- Tombol Hapus Tanggapan -->
                      <button
                        v-if="admin"
                        @click="deleteTanggapan(t.id, c.id)"
                        class="text-red-500 hover:text-red-700 cursor-pointer opacity-0 group-hover:opacity-100 transition"
                        title="Hapus tanggapan"
                      >
                                <i class="ri-delete-bin-5-fill text-lg"></i>

                      </button>
                    </div>

                    <p class="text-gray-600 text-sm">{{ t.isi }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- INPUT TANGGAPAN -->
            <div v-if="selectedKomentarId === c.id" class="ml-6 mt-2 flex gap-2">
              <input
                v-model="newTanggapan"
                type="text"
                placeholder="Ketik tanggapan..."
                class="flex-1 border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                @keyup.enter="sendTanggapan(c.id)"
              />
              <button
                @click="sendTanggapan(c.id)"
                class="px-4 py-2 bg-blue-500 text-white rounded-full"
              >
                Kirim
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="text-center text-white bg-(--primary) py-3 text-sm">
    © 2025 Yayasan Hosana Tebas. All Rights Reserved.
  </footer>
</template>
