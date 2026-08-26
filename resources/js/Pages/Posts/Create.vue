<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
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
            <div class="px-4 py-6">
                <!-- 投稿エリア全体 -->
                <div
                    class="mx-auto w-full"
                    style="max-width: 500px;"
                >
                    <!-- 画像追加エリア -->
                    <div
                        class="flex h-auto w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50"
                        style="aspect-ratio: 1 / 1;"
                    >
                        <div class="mb-3 text-4xl text-gray-400">
                            ＋
                        </div>

                        <p class="text-base font-medium text-gray-700">
                            写真を追加する
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            クリックして写真を選択
                        </p>
                    </div>

                    <!-- 投稿ボタン -->
                    <div class="mt-6 text-center">
                        <PrimaryButton
                            type="button"
                            class="w-full justify-center"
                        >
                            投稿する
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>