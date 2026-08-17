<!-- resources/js/Components/HeaderLogo.vue -->
<script setup lang="ts">
import headerLogo from '@/images/logo-header.png';
</script>

<template>
    <img 
        :src="headerLogo" 
        alt="ノートびより" 
        class="h-10 w-auto object-contain" 
    />
</template>