<script setup>
const props = defineProps({
    href: String,
    isDisabled: Boolean
});
</script>

<template>
    <Link :href="route(props.href)" as="button"
        class="text-sm font-medium w-full h-10 rounded-full border-1 border-card-grey cursor-pointer hover:bg-grey-hover"
        :class="{
            'opacity-50 cursor-not-allowed pointer-events-none': props.isDisabled
        }"
    >
        <slot></slot>
    </Link>
</template>
