<script setup>
const props = defineProps({
    title: String,
    description: String
})
</script>

<template>
    <div class="pb-8 lg:pb-12">
        <h1 class="text-2xl font-semibold text-center pb-4 lg:pb-6">{{ props.title }}</h1>
        <p class="text-center">{{ props.description }}</p>
    </div>
</template>
