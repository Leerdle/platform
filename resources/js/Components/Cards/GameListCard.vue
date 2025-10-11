<script setup>
import {computed} from "vue";
import gapAttackIcon from '/public/storage/icons/gap-attack-icon.png';
import LinkItem from "@/Components/Links/LinkItem.vue";

const props = defineProps({
    color: {
        text: String,
        default: 'card-grey'
    },
    title: String,
    subtitle: String,
    startHref: {
        type: String,
        default: 'home'
    },
    isStartDisabled: Boolean,
    pastHref: {
        type: String,
        default: 'home'
    },
    isPastDisabled: Boolean
});

const bgColorClass = computed(() => {
    const colorMap = {
        'grey': 'bg-card-grey',
        'lavender': 'bg-card-lavender',
        'green': 'bg-card-green',
        'lilac': 'bg-card-lilac'
    };

    return colorMap[props.color];
});
</script>

<template>
    <div class="rounded-lg overflow-hidden">
        <div class="h-[200px] flex justify-center items-center" :class="bgColorClass">
            <div class="text-center">
                <img class="m-auto pb-5" :src="gapAttackIcon" :alt="props.title" />
                <h2 class="pb-1 !font-semibold">{{ props.title }}</h2>
                <h3 class="text-sm ">{{ props.subtitle }}</h3>
            </div>
        </div>

        <div class="bg-white border-1 border-t-0 rounded-b-lg border-card-grey p-4">
            <LinkItem class="mb-3" :href="props.startHref" :is-disabled="props.isStartDisabled">Start</LinkItem>
            <LinkItem :href="props.pastHref" :is-disabled="props.isPastDisabled">Past Exercises</LinkItem>
        </div>
    </div>
</template>
