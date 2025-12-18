import { createRouter, createWebHashHistory } from 'vue-router'
import Beranda from '../views/Beranda/Beranda.vue'
import Informasi from '@/views/Info/Informasi.vue';
import TK from '@/views/UnitPendidikan/TK/TK.vue';
import SD from '@/views/UnitPendidikan/SD/SD.vue';
import SMP from '@/views/UnitPendidikan/SMP/SMP.vue';
import SMK from '@/views/UnitPendidikan/SMK/SMK.vue';
import GSTK from '@/views/GuruStaff/TK/GSTK.vue';
import GSSD from '@/views/GuruStaff/SD/GSSD.vue';
import GSSMP from '@/views/GuruStaff/SMP/GSSMP.vue';
import GSSMK from '@/views/GuruStaff/SMK/GSSMK.vue';
import Alumni from '@/views/Alumni/Alumni.vue';
import BeritaAll from '@/views/Berita/BeritaAll.vue';
import BeritaDetail from '@/views/Berita/BeritaDetail.vue';
import Kontak from '@/views/Kontak/Kontak.vue';
import DaftarAkun from '@/views/Akun/DaftarAkun.vue';
import Login from '@/views/Akun/Login.vue';
import Setting from '@/views/Akun/Setting.vue';
import Menudashboard from '@/views/ADMIN/dashboard/Menudashboard.vue';
import tbBanner from '@/views/ADMIN/banner/tbBanner.vue';
import createBanner from '@/views/ADMIN/banner/createBanner.vue';
import editBanner from '@/views/ADMIN/banner/editBanner.vue';
import tbStatistic from '@/views/ADMIN/statistic/tbStatistic.vue';
import editStatistic from '@/views/ADMIN/statistic/editStatistic.vue';
import tbAlumni from '@/views/ADMIN/InfoAlumni/tbAlumni.vue';
import createAlumni from '@/views/ADMIN/InfoAlumni/createAlumni.vue';
import editAlumni from '@/views/ADMIN/InfoAlumni/editAlumni.vue';
import tbBerita from '@/views/ADMIN/berita/tbBerita.vue';
import createBerita from '@/views/ADMIN/berita/createBerita.vue';
import editBerita from '@/views/ADMIN/berita/editBerita.vue';
import tbKategori from '../views/ADMIN/kategoriBerita/tbKategori.vue';
import createKategori from '../views/ADMIN/kategoriBerita/createKategori.vue';
import editKategori from '@/views/ADMIN/kategoriBerita/editKategori.vue';
import tbGuruStaff from '@/views/ADMIN/GuruStaff/tbGuruStaff.vue';
import createGuruStaff from '@/views/ADMIN/GuruStaff/createGuruStaff.vue';
import editGuruStaff from '@/views/ADMIN/GuruStaff/editGuruStaff.vue';
import tbKontak from '@/views/ADMIN/kontak/tbKontak.vue';
import editKontak from '../views/ADMIN/kontak/editKontak.vue';
import tbFasilitas from '@/views/ADMIN/fasilitas/tbFasilitas.vue';
import createFasilitas from '@/views/ADMIN/fasilitas/createFasilitas.vue';
import editFasilitas from '@/views/ADMIN/fasilitas/editFasilitas.vue';
import tbKegiatan from '@/views/ADMIN/kegiatan/tbKegiatan.vue';
import createKegiatan from '@/views/ADMIN/kegiatan/createKegiatan.vue';
import editKegiatan from '@/views/ADMIN/kegiatan/editKegiatan.vue';
import Menutanggapan from '@/views/ADMIN/tanggapan/Menutanggapan.vue';
import tanggapanDetail from '@/views/ADMIN/tanggapan/component/tanggapanDetail.vue';
import tbUser from '@/views/ADMIN/dashboard/tbUser.vue';

const router = createRouter({
  history: createWebHashHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'Beranda', component: Beranda,},
    { path: '/Informasi', name: 'Informasi', component: Informasi,},
    { path: '/TK', name: 'TK', component: TK, },
    { path: '/SD', name: 'SD', component: SD, },
    { path: '/SMP', name: 'SMP', component: SMP, },
    { path: '/SMK', name: 'SMK', component: SMK, },
    { path: '/GSTK', name: 'GSTK', component: GSTK, },
    { path: '/GSSD', name: 'GSSD', component: GSSD, },
    { path: '/GSSMP', name: 'GSSMP', component: GSSMP, },
    { path: '/GSSMK', name: 'GSSMK', component: GSSMK, },
    { path: '/Alumni', name: 'Alumni', component: Alumni, },
    { path: '/BeritaAll', name: 'BeritaAll', component: BeritaAll, },
    { path: '/BeritaDetail/:id', name: 'BeritaDetail', component: BeritaDetail, },
    { path: '/Kontak', name: 'Kontak', component: Kontak, },
    { path: '/DaftarAkun', name: 'DaftarAkun', component: DaftarAkun, },
    { path: '/Login', name: 'Login', component: Login, },
    { path: '/Setting', name: 'Setting', component: Setting, },

    { path: '/admin', name: 'Menudashboard', component: Menudashboard,},
    { path: '/tbBanner', name: 'tbBanner', component: tbBanner,},
    { path: '/createBanner', name: 'createBanner', component: createBanner,},
    { path: '/editBanner/:id', name: 'editBanner', component: editBanner,},
    { path: '/tbStatistic', name: 'tbStatistic', component: tbStatistic,},
    { path: '/editStatistic/:id', name: 'editStatistic', component: editStatistic,},
    { path: '/tbAlumni', name: 'tbInfoAlumni', component: tbAlumni,},
    { path: '/createAlumni', name: 'createAlumni', component: createAlumni,},
    { path: '/editAlumni/:id', name: 'editAlumni', component: editAlumni,},
    { path: '/tbBerita', name: 'tbInfoBerita', component: tbBerita,},
    { path: '/createBerita', name: 'createBerita', component: createBerita,},
    { path: '/editBerita/:id', name: 'editBerita', component: editBerita,},
    { path: '/tbKategori', name: 'tbKategori', component: tbKategori,},
    { path: '/createKategori', name: 'createKategori', component: createKategori,},
    { path: '/editKategori/:id', name: 'editKategori', component: editKategori,},
    { path: '/tbGuruStaff', name: 'tbInfoGuruStaff', component: tbGuruStaff,},
    { path: '/createGuruStaff', name: 'createGuruStaff', component: createGuruStaff,},
    { path: '/editGuruStaff/:id', name: 'editGuruStaff', component: editGuruStaff,},
    { path: '/tbKontak', name: 'tbKontak', component: tbKontak,},
    { path: '/editKontak/:id', name: 'editKontak', component: editKontak,},
    { path: '/tbFasilitas', name: 'tbFasilitas', component: tbFasilitas,},
    { path: '/createFasilitas', name: 'createFasilitas', component: createFasilitas,},
    { path: '/editFasilitas/:id', name: 'editFasilitas', component: editFasilitas,},
    { path: '/tbKegiatan', name: 'tbKegiatan', component: tbKegiatan,},
    { path: '/createKegiatan', name: 'createKegiatan', component: createKegiatan,},
    { path: '/editKegiatan/:id', name: 'editKegiatan', component: editKegiatan,},
    { path: '/Menutanggapan', name: 'Menutanggapan', component: Menutanggapan,},
    { path: '/tanggapanDetail/:id', name: 'TanggapanDetail',component: tanggapanDetail,},
    { path: '/tbUser', name: 'tbUser', component: tbUser,},
    
    
    
  ],
  scrollBehavior(to, from, savedPosition) {
    return { top: 0 }; 
  }
})

export default router
