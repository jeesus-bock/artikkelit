<template>
    <div>WUMPUS!{{ joku }}</div>
</template>
<script setup lang="ts">
defineProps<{
    joku?: string;
}>();
</script>
