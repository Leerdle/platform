<script setup>
import HeaderMenu from "@/Components/Menus/HeaderMenu.vue";
</script>

<template>
    <div class="h-full bg-[#4d88f9] p-5 w-full min-h-screen flex">
        <div class="flex flex-col items-center w-full justify-center">
            <slot></slot>
        </div>
    </div>
</template>
