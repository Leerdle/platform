<script setup>
import HeaderMenu from "@/Components/Menus/HeaderMenu.vue";
</script>

<template>
    <HeaderMenu />

    <main class="min-h-screen">
        <div class="bg-[#f4f4f4] min-h-screen py-10 px-4">
            <section class="max-w-3xl m-auto">
                <slot></slot>
            </section>
        </div>
    </main>
</template>
