<script setup>
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import axios from "axios";
const userId = ref(localStorage.getItem("userId"));
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;
const successMessage = ref('');
const commentSection = ref(null);

const deleteComment = async (id) => {
  const token = localStorage.getItem("token");

  if (!confirm("Yakin ingin menghapus komentar ini?")) return;

  try {
    await axios.delete(`${API_BASE_URL}/api/v1/komentar/${id}`, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
    fetchComments(); 
  } catch (error) {
    console.error("Gagal menghapus komentar:", error.response?.data || error);
    alert("Gagal menghapus komentar!");
  }
};

const route = useRoute();
const berita = ref(null);
const selectedMedia = ref(null);
const comments = ref([]);
const role = ref('guest');
const newComment = ref("");
const defaultAvatar = `${API_BASE_URL}/storage/profile_image/default.png`;
const formatTanggal = (tanggal) => {
  if (!tanggal) return '';
  const date = new Date(tanggal);
  return date.toLocaleString("id-ID", {
    day: "2-digit",
    month: "short",
    year: "numeric",

  });
};

const fetchBeritaDetail = async () => {
  try {
    const id = route.params.id;
    const res = await axios.get(`${API_BASE_URL}/api/v1/berita/${id}`);
    berita.value = res.data;

    if (berita.value.media && berita.value.media.length > 0) {
      selectedMedia.value = berita.value.media[0];
    }
  } catch (error) {
    console.error("Gagal memuat detail berita:", error);
  }
};

const submitComment = async () => {
  if (!newComment.value.trim()) return;

  try {
    const userId = localStorage.getItem("userId");
    const token = localStorage.getItem("token");
    const id = route.params.id;

    if (!userId) {
      alert("Kamu harus login dulu untuk berkomentar!");
      return;
    }

    await axios.post(
      `${API_BASE_URL}/api/v1/komentar`,
      {
        berita_id: id,
        user_id: userId,
        isi_komentar: newComment.value,
      },
      {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      }
    );

  newComment.value = "";

  successMessage.value = 
    "Komentar berhasil dikirim dan akan ditampilkan setelah divalidasi oleh admin.";

  commentSection.value?.scrollIntoView({
  behavior: 'smooth',
  block: 'start'
});

  setTimeout(() => {
    successMessage.value = "";
  }, 5000);


  } catch (error) {
    console.error("Gagal menambah komentar:", error.response?.data || error);
  }
};


const fetchComments = async () => {
  try {
    const id = route.params.id;
    const res = await axios.get(`${API_BASE_URL}/api/v1/komentar/${id}`);
    comments.value = res.data;
    console.log(comments.value);
  } catch (error) {
    console.error("Gagal memuat komentar:", error);
    console.log(error.response.data);
  }
};

onMounted(() => {
  const savedRole = localStorage.getItem('userRole');
  role.value = savedRole || 'guest';
  fetchBeritaDetail();
  fetchComments();
});

const isGuest = () => role.value === 'guest';
</script>

<template>
  <Navbar />

  <div class="md:p-10 p-5 bg-gray-100 min-h-screen" v-if="berita">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 ">
      <div class="lg:col-span-2 space-y-3 bg-white rounded-xl p-6">
        <div v-if="selectedMedia">
          <img 
            v-if="selectedMedia.tipe === 'foto'"
            :src="`${API_BASE_URL}/storage/${selectedMedia.file_path}`"
            alt="Media Utama"
            class="rounded-xl shadow-md w-full object-cover"
          />
          <video 
            v-else 
            controls 
            class="rounded-xl shadow-md w-full object-cover"
          >
            <source :src="`${API_BASE_URL}/storage/${selectedMedia.file_path}`" type="video/mp4" />
          </video>
        </div>

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

        <div class="">
          <div class="flex items-center space-x-2 text-gray-600 mb-2">
            <div class="w-5 h-5 text-red-500">
              <i class="ri-calendar-line"></i>
            </div>
      <span class="mt-1">{{ formatTanggal(berita.tanggal_berita) }}</span>
          </div>

          <div class="text-sm text-right text-gray-700 mb-3">
            {{ berita.kategoris && berita.kategoris.length 
              ? berita.kategoris.map(k => k.nama_kategori).slice(0,3).join(', ') 
              : '-' }}
          </div>

          <h2 class="text-xl font-semibold mb-4">
            {{ berita.judul }}
          </h2>

          <p class="text-gray-600 mb-4 md:text-md text-sm leading-relaxed text-justify whitespace-pre-line">
            {{ berita.isi }}
          </p>
        </div>
      </div>


      <div 
        ref="commentSection"
        class="bg-white rounded-xl shadow-md p-6 flex flex-col"
      >

        <h3 class="font-bold text-lg mb-4">KOMENTAR</h3>

        <div 
  v-if="successMessage"
  class="mb-3 px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg text-sm"
>
  {{ successMessage }}
</div>


        <div class="space-y-4 flex-1">
          <div v-if="comments.length === 0" class="text-gray-500 text-sm italic">
            Belum ada komentar.
          </div>
          <div  
  v-for="(comment, index) in comments"
  :key="index"
  class="flex flex-col mb-4 border-b pb-3"
>
  <div class="flex items-start gap-2">
  <img
    :src="comment.user?.profile_image 
      ? `${API_BASE_URL}/storage/profile_image/${comment.user.profile_image}` 
      : defaultAvatar"
    class="w-8 h-8 rounded-full"
  />
    <div class="flex-1">
      <p class="font-semibold text-sm">{{ comment.user?.name || 'Anonim' }}</p>
      <p class="text-gray-600 text-sm">{{ comment.isi_komentar }}</p>

      <div 
        v-for="(t, idx) in comment.tanggapan || []" 
        :key="idx"
        class="ml-8 mt-2 bg-blue-50 border-l-4 border-(--primary) pl-3 py-1 rounded"
      >
        <p class="font-semibold text-(--primary) text-sm">
          {{ t.admin?.name || 'Admin' }}
        </p>
        <p class="text-gray-600 text-sm">{{ t.isi }}</p>
      </div>
    </div>
  </div>

  <button
    v-if="comment.user_id == userId"
    @click="deleteComment(comment.id)"
    class="text-red-500 hover:text-red-700 self-end mt-2"
  >
        <i class="ri-delete-bin-5-fill text-lg"></i>

  </button>
</div>




        </div>

      <div class="mt-4 flex gap-2" v-if="!isGuest() && role !== 'admin'">
        <input
          type="text"
          v-model="newComment"
          placeholder="Ketik Komentar..."
          class="flex-1 px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-400"
          @keyup.enter="submitComment"
        />
        <button
          @click="submitComment"
          class="px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600"
        >
          Kirim
        </button>
      </div>


        <div v-else-if="role === 'admin'" class="mt-4 text-center text-gray-500 text-sm italic">
          Admin tidak dapat mengirim komentar.
        </div>

        <div v-else class="mt-4">
          <input
            type="text"
            placeholder="Login untuk memberikan komentar"
            readonly
            class="w-full px-4 py-2 border rounded-full bg-gray-100 cursor-not-allowed"
          />
        </div>
      </div>
    </div>
  </div>

  <Footer />
</template>
