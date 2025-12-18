<script setup>
import Sidebar from '../Sidebar.vue';
import dashboard from './component/dashboard.vue';
</script>

<template>
    <div class="flex">
    <Sidebar />
    <dashboard />
    </div>
    <footer class="text-center bg-(--primary) py-3 text-white text-sm">
© 2025 Yayasan Hosana Tebas. All Rights Reserved.
</footer>
</template>