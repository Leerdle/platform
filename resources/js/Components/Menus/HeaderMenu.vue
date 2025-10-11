<script setup>
import logoUrl from '/public/storage/logo.png';
</script>

<template>
    <div class="w-full h-14 flex">
        <Link :href="route('home')" class="m-auto h-5">
            <img :src="logoUrl" alt="Leerdle Logo" class="h-full"  />
        </Link>
    </div>
</template>
