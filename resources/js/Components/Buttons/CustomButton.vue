<script setup>
const props = defineProps({
    isSubmit: {
        type: Boolean,
        default: true
    }
});
</script>

<template>
    <button
        :type="isSubmit ? 'submit' : 'button'"
        class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-2xl cursor-pointer hover:scale-110 transition-transform">
        <slot></slot>
    </button>
</template>
