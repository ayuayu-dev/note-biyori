<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';

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

const props = defineProps<{
    posts: PostsPaginator;
}>();

// 投稿リストを保持するリアクティブ配列（追加読み込みしたデータをここへ push する）
const postList = ref<Post[]>([...props.posts.data]);
const nextPageUrl = ref<string | null>(props.posts.next_page_url);
const isLoading = ref<boolean>(false);

// スクロール検知用のトリガー要素
const loadMoreTrigger = ref<HTMLElement | null>(null);
let observer: IntersectionObserver | null = null;

// 次のページの投稿を取得する処理
const loadMorePosts = () => {
    // 次のページがない、または現在読み込み中なら何もしない
    if (!nextPageUrl.value || isLoading.value) {
        return;
    }

    isLoading.value = true;

    router.get(
        nextPageUrl.value,
        {},
        {
            preserveState: true,
            preserveScroll: true,
            only: ['posts'],
            onSuccess: (page) => {
                const newPosts = page.props.posts as PostsPaginator;
                // 新しく取得した投稿を既存の配列に追加
                postList.value.push(...newPosts.data);
                // 次のページURLを更新（最後のページなら null になる）
                nextPageUrl.value = newPosts.next_page_url;
                isLoading.value = false;
            },
            onError: () => {
                isLoading.value = false;
            },
        }
    );
};

onMounted(() => {
    // IntersectionObserverで最下部のトリガー要素を監視
    observer = new IntersectionObserver(
        (entries) => {
            if (entries[0].isIntersecting) {
                loadMorePosts();
            }
        },
        { rootMargin: '200px' } // 画面下端の200px手前に来たら先読みを開始
    );

    if (loadMoreTrigger.value) {
        observer.observe(loadMoreTrigger.value);
    }
});

onUnmounted(() => {
    // 画面を離れる際に監視を解除
    if (observer) {
        observer.disconnect();
    }
});
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
            <!-- 最大幅を少し狭く（max-w-2xl）して、インスタのフィード感に近づける -->
            <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                <!-- 投稿が一件もない場合の表示 -->
                <div v-if="postList.length === 0" class="py-12 text-center text-gray-500">
                    まだ投稿がありません。
                </div>

                <!-- 確実に横3列にするためのグリッド（gap-1で隙間を詰める） -->
                <div v-else class="grid grid-cols-3 gap-1">
                    <div 
                        v-for="post in postList" 
                        :key="post.id" 
                        class="relative aspect-square bg-gray-100 overflow-hidden"
                    >
                        <!-- 投稿に紐づく画像を表示 -->
                        <img 
                            v-if="post.images && post.images.length > 0"
                            :src="'/storage/' + post.images[0].image_path" 
                            alt="投稿画像" 
                            class="h-full w-full object-cover hover:opacity-95 transition cursor-pointer"
                        />
                        <!-- 画像がない場合のフォールバック -->
                        <div v-else class="flex h-full w-full items-center justify-center text-xs text-gray-400">
                            No Image
                        </div>
                    </div>
                </div>

                <!-- 👇 スクロール検知用トリガー ＆ ローディング表示エリア -->
                <div ref="loadMoreTrigger" class="py-6 text-center">
                    <p v-if="isLoading" class="text-sm text-gray-500">
                        読み込み中...
                    </p>
                    <p v-else-if="!nextPageUrl && postList.length > 0" class="text-xs text-gray-400">
                        すべての投稿を表示しました
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>