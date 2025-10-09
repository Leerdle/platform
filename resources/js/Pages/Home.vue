<script setup>
import { computed } from "vue";
import FillInTheBlanks from "@/Components/Questions/FillInTheBlanks.vue";

const props = defineProps({
    exercise: Object
});

const title = computed(() => {
    return props.exercise?.title && props.exercise?.title !== ''
        ? props.exercise.title
        : "Daily Game";
});

const description = computed(() => {
    return props.exercise?.description && props.exercise?.description !== ''
        ? props.exercise.description
        : "No Daily Game available right now. Please check back later.";
});
</script>

<template>
    <Head :title="title" />

    <main class="bg-[#404db6] min-h-screen flex items-center justify-center p-5">
        <div class="flex flex-col items-center w-full">
            <div class="text-white text-center mb-8">
                <h1 class="text-3xl md:text-4xl !font-bold mb-6">{{ title }}</h1>
                <p class="text-md md:text-lg text-white/90 mb-8">{{ description }}</p>
            </div>

            <div class="grid w-full max-w-md" v-if="exercise?.questions && exercise.questions.length > 0">
                <FillInTheBlanks
                    v-for="(question, index) in exercise.questions"
                    :key="index"
                    :question="question"
                    :z-index="exercise.questions.length - index"
                    :index="index"
                    class="col-start-1 row-start-1"
                />
            </div>
        </div>
    </main>
</template>
