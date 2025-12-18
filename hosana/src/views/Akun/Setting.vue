<template>
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <div class="w-64 bg-(--primary) shadow-md flex flex-col justify-between h-screen">
      <div>
        <div class="pt-10 flex flex-col items-center text-white">
          <img :src="profileImage" class="w-20 h-20 rounded-full object-cover" alt="Profile" />
          <h2 class="mt-2 font-semibold">{{ name }}</h2>
        </div>
        <ul class="mt-6 text-white">
          <li class="px-4 py-2 bg-[#294d87] cursor-pointer rounded">Informasi Akun</li>
          <li class="px-4 py-2 hover:bg-[#294d87] cursor-pointer rounded" @click="logout">Log Out</li>
        </ul>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-10 bg-gray-50">
      <div class="text-right mb-6">
        <router-link to="/">
          <button class="bg-(--primary) hover:animate-pulse cursor-pointer text-white px-3 py-1 text-sm rounded-full">
            Kembali <i class="ri-arrow-right-long-fill ml-2"></i>
          </button>
        </router-link>
      </div>

      <h1 class="text-2xl font-semibold mb-6">Informasi Akun</h1>

      <form class="grid grid-cols-2 gap-6" @submit.prevent="saveChanges">
        <!-- Username -->
                <div>
          <label class="block text-sm font-medium text-gray-700">Nama</label>
          <input
            type="text"
            v-model="name"
            maxlength="15"
            class="mt-1 block w-full p-3 border-gray-300 rounded-md shadow-sm"
          />
          <p class="text-sm text-gray-500 mt-1">{{ name.length }}/15 karakter</p>
        </div>
        <!-- Email -->
        <div class="col-span-2">
          <label class="block text-sm font-medium text-gray-700" >Email</label>
          <input type="email" readonly v-model="email" class="mt-1 block w-full p-3  border-gray-300 rounded-md shadow-sm" />
          <span class="text-green-500 text-sm">Verified</span>
        </div>

        <!-- Buttons -->
        <div class="col-span-2 flex gap-4 mt-4">
          <button type="button" @click="discardChanges" class="px-4 cursor-pointer py-2 border border-(--primary) rounded text-(--primary)">
            Batal
          </button>
          <button type="submit" class="px-4 py-2 bg-(--primary) cursor-pointer text-white rounded">
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from '@/axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const name = ref('')
const email = ref('')
const profileImage = ref('/assets/images/default.png')

let originalData = {}

onMounted(async () => {
  try {
    const res = await axios.get('/user-profile')
    const userData = res.data.user 

    name.value = userData.name
    email.value = userData.email
    profileImage.value = userData.profile_image || '/assets/images/default.png'

    originalData = {
      name: userData.name,
      email: userData.email,
    }
  } catch (err) {
    console.error('Error fetching user data:', err)
    alert('Gagal mengambil data user. Silakan login kembali.')
    router.push('/Login')
  }
})


const saveChanges = async () => {
  try {
    await axios.put('/user-profile', {
      name: name.value,
      email: email.value,
    })
    alert('Perubahan berhasil disimpan!')
    originalData.name = name.value
    originalData.email = email.value
  } catch (err) {
    console.error('Error saving changes:', err)

    if (err.response && err.response.status === 422) {
      const errors = err.response.data.errors

      if (errors.name) {
        alert('Nama sudah digunakan oleh pengguna lain!')
      } else if (errors.email) {
        alert('Email sudah digunakan oleh pengguna lain!')
      } else {
        alert('Data tidak valid. Silakan periksa kembali.')
      }
    } else {
      alert('Gagal menyimpan perubahan!')
    }
  }
}


const discardChanges = () => {
  name.value = originalData.name
  email.value = originalData.email
}

const logout = () => {
  if(confirm('Apakah kamu yakin ingin logout?')) {
    localStorage.removeItem('userRole')
    localStorage.removeItem('token')
    router.push('/Login')
  }
}
</script>
