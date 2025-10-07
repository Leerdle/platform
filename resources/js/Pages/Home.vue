<script setup>
import FillInTheBlanks from "@/Components/Questions/FillInTheBlanks.vue";

defineProps({
    exercise: Object
});
</script>

<template>
    <Head title="Daily Game" />

    <main class="bg-[#404db6] min-h-screen flex items-center justify-center p-5">
        <div class="grid w-full max-w-md">
            <FillInTheBlanks
                v-for="(question, index) in exercise.questions"
                :key="index"
                :question="question"
                :z-index="exercise.questions.length - index"
                :index="index"
                class="col-start-1 row-start-1"
            />
        </div>
    </main>
</template>
