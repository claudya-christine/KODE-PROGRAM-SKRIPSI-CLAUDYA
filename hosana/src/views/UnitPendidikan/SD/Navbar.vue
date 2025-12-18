<script setup>
import logo from '@/assets/logo.svg'
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()
const searchQuery = ref('')
const open = ref(false)
const activeDropdown = ref(null)
const role = ref('guest')

const updateRole = () => {
  const savedRole = localStorage.getItem('userRole')
  role.value = savedRole || 'guest'
}

onMounted(() => {
  updateRole()
  window.addEventListener('storage', updateRole)
})

const Links = computed(() => {
  const commonLinks = [
    { name: "BERANDA", link: "/" },
    { name: "INFORMASI YAYASAN", link: "/Informasi" },
    {
      name: "UNIT PENDIDIKAN",
      children: [
        { name: "TK IMANNUEL TEBAS", link: "/TK" },
        { name: "SDS PROTESTAN TEBAS", link: "/SD" },
        { name: "SMPS HOSANA TEBAS", link: "/SMP" },
        { name: "SMKS HOSANA TEBAS", link: "/SMK" },
      ]
    },
    {
      name: "GURU & STAFF",
      children: [
        { name: "TK", link: "/GSTK" },
        { name: "SD", link: "/GSSD" },
        { name: "SMP", link: "/GSSMP" },
        { name: "SMK", link: "/GSSMK" },
      ]
    },
    { name: "ALUMNI", link: "/Alumni" },
    { name: "BERITA", link: "/BeritaAll" },
    { name: "KONTAK", link: "/Kontak" },
  ]

  if (role.value === 'admin') {
    return [
      ...commonLinks,
      { name: "DASHBOARD", link: "/admin" },
      { name: "LOGOUT", link: "/", action: 'logout' }
    ]
  } else if (role.value === 'user') {
    return [
      ...commonLinks,
      { name: "AKUN", link: "/Setting" },
      { name: "LOGOUT", link: "/", action: 'logout' }
    ]
  } else {
    return [
      ...commonLinks,
      { name: "DAFTAR/LOGIN", link: "/DaftarAkun" },
    ]
  }
})

const toggleMenu = () => open.value = !open.value
const toggleDropdown = (linkName) =>
  (activeDropdown.value = activeDropdown.value === linkName ? null : linkName)

const handleClick = (link) => {
  if (link.action === 'logout') {
    const confirmLogout = window.confirm('Apakah Anda yakin ingin logout?')
    if (confirmLogout) {
      localStorage.removeItem('userRole')
      localStorage.removeItem('token')
      localStorage.removeItem('userId')
      role.value = 'guest'
      router.push('/Login')
    }
  }
}
</script>

<template>
  <header class="sticky top-0 z-50 bg-(--sd) py-4 px-5 md:px-0">
    <div class="container mx-auto flex justify-between items-center md:px-10">
      <div class="flex items-center gap-3">
        <img :src="logo" alt="Logo" class="md:w-[10%] w-[10%]" />
        <h3 class="text-white font-bold text-base">YAYASAN HOSANA TEBAS</h3>
      </div>

      <button class="md:hidden text-3xl" @click="toggleMenu">
        <i :class="open ? 'ri-close-fill text-white' : 'ri-menu-fill text-white'"></i>
      </button>

      <nav
        class="absolute md:relative top-full md:top-0 left-0 w-full md:w-auto 
        bg-(--sd) md:bg-transparent md:flex md:items-center 
        transition-all duration-300 shadow-md md:shadow-none z-50"
        :class="open ? 'block' : 'hidden md:flex'"
      >
        <ul class="text-white text-xs md:flex md:items-center py-3 md:py-0 px-1">
          <li
            v-for="link in Links"
            :key="link.name"
            class="relative group hover:border-b-2 hover:border-yellow-500 hover:text-yellow-300"
            :class="{
              'text-white rounded-md md:bg-transparent': open && route.path === link.link,
              'md:bg-transparent': !open
            }"
          >
            <div
              v-if="link.children"
              @click="toggleDropdown(link.name)"
              class="block px-2 cursor-pointer py-1.5 pl-2 md:py-0 md:pl-0 hover:border-b-1 hover:border-yellow-500 flex items-center justify-between w-full"
              :class="{
                'font-bold text-yellow-200': link.children.some(
                  (child) => route.path === child.link
                )
              }"
            >
              {{ link.name }}
            </div>

            <router-link
              v-else
              :to="link.link"
              class="block py-2 px-2"
              :class="{
                'font-bold text-yellow-200':
                  (!link.children && route.path === link.link) ||
                  (link.children &&
                    link.children.some((child) =>
                      route.path.startsWith('/' + child.link)
                    ))
              }"
              @click="handleClick(link)"
            >
              {{ link.name }}
            </router-link>

            <ul
              v-if="link.children && activeDropdown === link.name"
              class="bg-[#4da302] md:bg-white md:absolute md:top-full md:left-0 md:mt-2 shadow-lg md:min-w-[200px] z-50 transition duration-300 ease-in-out"
            >
              <li v-for="child in link.children" :key="child.name">
                <router-link
                  :to="child.link"
                  class="block py-2 px-4 text-xs hover:bg-gray-200 text-sm md:text-black text-white"
                  @click="activeDropdown = null"
                >
                  {{ child.name }}
                </router-link>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </header>
</template>

<style scoped>
ul li a {
  transition: color 300ms;
}
</style>
