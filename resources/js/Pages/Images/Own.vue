<template>
    <MainLayout>
        <div class="flex w-full gap-8">
            <div v-for="image in images" class="flex flex-col items-center">
                <div class="flex gap-4">
                    <h4>{{ image.desc }}</h4>
                    <span>🗑</span>
                </div>
                <span>({{ image.width + "x" + image.height }})</span>
                <a :href="'/imgs/' + image.filename"
                    ><img :src="'/thumbnail/' + image.filename"
                /></a>
            </div>
        </div>
    </MainLayout>
</template>
<script setup lang="ts">
import MainLayout from "../../Layouts/MainLayout.vue";
import { Image } from "../../types";

defineProps<{
    images?: Array<Image>;
}>();
</script>
