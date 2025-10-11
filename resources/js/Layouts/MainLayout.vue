<script setup>
import HeaderMenu from "@/Components/Menus/HeaderMenu.vue";
</script>

<template>
    <HeaderMenu />

    <main class="min-h-screen flex items-center justify-center">
        <slot></slot>
    </main>
</template>
