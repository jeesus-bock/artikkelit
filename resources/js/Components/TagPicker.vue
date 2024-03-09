<template>
    <div class="flex border border-gray-400 rounded-md bg-white">
        <TagBadge v-if="value" :tag="value" class="m-0.5" />

        <div
            class="border-l border-gray-400 cursor-pointer text-xl bg-gray-100 rounded-r-full"
        >
            ⌄
        </div>
    </div>
</template>
<script setup lang="ts">
import TagBadge from "@/Components/TagBadge.vue";
import type { Tag } from "@/types";
import { onMounted, ref } from "vue";

const tags = ref<Array<Tag>>([]);
const value = ref<Tag>();
onMounted(async () => {
    const { data } = await window.axios.get("/api/tags");
    tags.value = data;
    value.value = tags.value[0];
});
</script>
