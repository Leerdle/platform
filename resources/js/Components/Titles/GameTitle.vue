<script setup>
defineProps({
    title: {
        type: String,
        default: 'Daily Game'
    },
    description: {
        type: String,
        default: 'No Daily Game available right now. Please check back later.'
    }
});
</script>

<template>
    <div class="text-white text-center mb-8">
        <h1 class="text-3xl md:text-4xl !font-bold mb-6">{{ title }}</h1>
        <p class="text-md md:text-lg text-white/90 mb-8">{{ description }}</p>
    </div>
</template>
