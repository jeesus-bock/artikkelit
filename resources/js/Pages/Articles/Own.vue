<template>
    <MainLayout>
        <Head title="Omat" />
        {{ success }}
        <div class="flex flex-col w-full items-center">
            <ArticlePanel
                v-for="article in articles"
                :article="article"
                editable
                class="mb-8 last:mb-0"
            />
        </div>
    </MainLayout>
</template>
<script setup lang="ts">
import MainLayout from "../../Layouts/MainLayout.vue";
import ArticlePanel from "@/Components/ArticlePanel.vue";
import { Article } from "../../types";
import { Head } from "@inertiajs/vue3";
import { useSnackbar } from "vue3-snackbar";
import { onMounted } from "vue";
const snackbar = useSnackbar();

onMounted(() => {
    if (props.success) {
        snackbar.add({
            type: "success",
            text: props.success,
        });
    }
});
const props = defineProps<{
    articles?: Array<Article>;
    success?: string;
}>();
</script>
