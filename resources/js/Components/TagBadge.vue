<template>
    <div
        class="rounded-full py-0.5 px-2 border border-gray-400"
        :style="{ 'background-color': tag.color }"
    >
        {{ tag.name }}
    </div>
</template>
<script setup lang="ts">
import type { Tag } from "@/types";
const props = defineProps<{
    tag: Tag;
}>();
</script>
