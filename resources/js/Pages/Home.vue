<script setup>
import FillInTheBlanks from "@/Components/Questions/FillInTheBlanks.vue";

defineProps({
    exercise: Object
});
</script>

<template>
    {{ console.log(exercise) }}
    <Head title="Daily Game" />

    <main class="bg-[#404db6] min-h-screen flex items-center justify-center p-5">
        <div class="flex flex-col items-center w-full">
            <div v-if="exercise.title && exercise.title !== '' && exercise.description && exercise.description !== ''" class="text-white text-center mb-8">
                <h1 class="text-3xl md:text-4xl !font-bold mb-6">{{ exercise.title }}</h1>
                <p class="text-md md:text-lg text-white/90 mb-8">{{ exercise.description }}</p>
            </div>

            <div class="grid w-full max-w-md" v-if="exercise.questions && exercise.questions.length > 0">
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
