<template>
    <MainLayout>
        <Head title="Kaikki" />
        <div class="flex flex-col w-full items-center">
            <ArticlePanel
                v-for="article in articles"
                :article="article"
                :editable="false"
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

defineProps<{
    articles?: Array<Article>;
}>();
</script>
