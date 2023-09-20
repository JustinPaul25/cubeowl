<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <p class="block font-medium text-sm text-gray-700">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </p>
</template>
