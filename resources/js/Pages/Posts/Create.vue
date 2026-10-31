<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const fileInput = ref<HTMLInputElement | null>(null);
const imagePreview = ref<string | null>(null);
const imageError = ref<string | null>(null);
const selectedFile = ref<File | null>(null);

const openFileDialog = () => {
    fileInput.value?.click();
};

// --- 変数定義に追加（投稿完了メッセージ） ---
const successMessage = ref<string | null>(null);

const handleFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement;

    if (!target.files || target.files.length === 0) {
        return;
    }

    const file = target.files[0];

    // エラーをリセット
    imageError.value = null;
    //前回の完了メッセージをリセット
    successMessage.value = null; // 👈 次の画像を選んだら完了メッセージを消す

    // 許可する画像形式
    const allowedTypes = [
        'image/jpeg',
        'image/png',
        'image/webp',
    ];

    // 画像形式のチェック
    if (!allowedTypes.includes(file.type)) {
        imagePreview.value = null;
        selectedFile.value = null;
        imageError.value = 'JPEG、PNG、WebP形式の画像を選択してください。';

        target.value = '';

        return;
    }

    // ファイルサイズのチェック（5MBまで）
    const maxSize = 5 * 1024 * 1024;

    if (file.size > maxSize) {
        imagePreview.value = null;
        selectedFile.value = null;
        imageError.value = '画像サイズは5MB以下にしてください。';

        target.value = '';

        return;
    }

    // バリデーション成功
    selectedFile.value = file;
    imagePreview.value = URL.createObjectURL(file);
};

const submitPost = () => {
    if (!selectedFile.value) {
        imageError.value = '画像を選択してください。';

        return;
    }

    const formData = new FormData();

    formData.append('image', selectedFile.value);

    //投稿後に画像プレビューをリセットする
    router.post('/posts', formData, {
        onSuccess: () => {
            // プレビュー表示用のURLをクリア（「＋」の枠に戻る）
            imagePreview.value = null;

            // 保持しているFileオブジェクトをクリア
            selectedFile.value = null;

            // エラー表示をクリア
            imageError.value = null;

            // inputタグ自体の選択状態をクリア（同じ画像を再選択できるようにする）
            if (fileInput.value) {
                fileInput.value.value = '';
            }

            // 👇 完了メッセージをセット
            successMessage.value = '投稿が完了しました！✨';
        },
    });

};
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

                    <!-- 👇 投稿完了メッセージ表示エリア -->
                    <div
                        v-if="successMessage"
                        class="mb-4 rounded-lg border border-green-200 bg-green-50 p-4 text-center text-sm font-medium text-green-700"
                    >
                        {{ successMessage }}
                    </div>

                    <!-- 画像追加エリア -->
                    <div
                        class="flex h-auto w-full cursor-pointer flex-col items-center justify-center overflow-hidden rounded-lg border-2 border-dashed border-gray-300 bg-gray-50"
                        style="aspect-ratio: 1 / 1;"
                        @click="openFileDialog"
                    >
                        <!-- 画像が選択されていない場合 -->
                        <template v-if="!imagePreview">
                            <div class="mb-3 text-4xl text-gray-400">
                                ＋
                            </div>

                            <p class="text-base font-medium text-gray-700">
                                写真を追加する
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                クリックして写真を選択
                            </p>
                        </template>

                        <!-- 画像が選択されている場合 -->
                        <img
                            v-else
                            :src="imagePreview"
                            alt="選択した写真"
                            class="h-full w-full object-cover"
                        />

                        <input
                            ref="fileInput"
                            type="file"
                            accept="image/jpeg,image/png,image/webp"
                            class="hidden"
                            @change="handleFileChange"
                        />
                    </div>

                    <!-- 画像エラーメッセージ -->
                    <p
                        v-if="imageError"
                        class="mt-2 text-sm text-red-600"
                    >
                        {{ imageError }}
                    </p>

                    <!-- 投稿ボタン -->
                    <div class="mt-6 text-center">
                        <PrimaryButton
                            type="button"
                            class="w-full justify-center"
                            @click="submitPost"
                        >
                            投稿する
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>