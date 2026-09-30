<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

// ページャーで渡ってくるデータの型定義（TypeScript対応）
interface PostImage {
    id: number;
    image_path: string;
}

interface Post {
    id: number;
    images: PostImage[];
}

interface PostsPaginator {
    data: Post[];
    current_page: number;
    next_page_url: string | null;
}

defineProps<{
    posts: PostsPaginator;
}>();
</script>

<template>
    <Head title="新着投稿一覧" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                新着投稿一覧
            </h2>
        </template>

        <div class="py-6">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <!-- 投稿が一件もない場合の表示 -->
                <div v-if="posts.data.length === 0" class="py-12 text-center text-gray-500">
                    まだ投稿がありません。
                </div>

                <!-- インスタ風グリッドレイアウト -->
                <div v-else class="grid grid-cols-3 gap-2 md:gap-4">
                    <div 
                        v-for="post in posts.data" 
                        :key="post.id" 
                        class="relative bg-gray-100 overflow-hidden rounded-md shadow-sm"
                        style="aspect-ratio: 1 / 1;"
                    >
                        <!-- 投稿に紐づく画像を表示 -->
                        <img 
                            v-if="post.images && post.images.length > 0"
                            :src="'/storage/' + post.images[0].image_path" 
                            alt="投稿画像" 
                            class="h-full w-full object-cover hover:opacity-95 transition cursor-pointer"
                        />
                        <!-- 画像がない場合のフォールバック -->
                        <div v-else class="flex h-full w-full items-center justify-center text-sm text-gray-400">
                            No Image
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>