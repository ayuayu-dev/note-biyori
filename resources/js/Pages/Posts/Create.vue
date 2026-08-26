<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="新規投稿" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                新規投稿
            </h2>
        </template>

        <div>
            <!-- 新規投稿画面 -->
        </div>
    </AuthenticatedLayout>
</template>