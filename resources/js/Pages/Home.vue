<script setup>
import { ref } from 'vue';
import FillInTheBlanks from "@/Components/Questions/FillInTheBlanks.vue";

const props = defineProps({
    exercise: Object
});

const answers = ref({});
const results = ref({});
const isSubmitted = ref(false);

const checkAnswers = () => {
    results.value = {};
    props.exercise.questions.forEach(question => {
        const userAnswer = answers.value[question.id]?.trim().toLowerCase() || '';
        const correctAnswer = question.answer.trim().toLowerCase();
        results.value[question.id] = userAnswer === correctAnswer;
    });

    isSubmitted.value = true;
};
</script>

<template>
    <Head title="Daily Game" />

    <main>
        <div class="max-w-7xl mx-auto p-4 h-screen lg:p-6 lg:grid lg:grid-cols-2 lg:gap-8">
            <div class="mb-6 lg:md-8">
                <h1 class="mb-4 !font-bold text-2xl lg:mb-6">{{ exercise.title }}</h1>
                <p class="text-md">{{ exercise.description }}</p>
            </div>

            <div class="pb-6 lg:p-6 lg:overflow-y-scroll">
                <div class="flex flex-col gap-6 mb-6 lg:gap-8 lg:mb-8">
                    <FillInTheBlanks
                        v-for="(question, index) in exercise.questions"
                        :key="index"
                        :question="question"
                        v-model="answers[question.id]"
                        :is-correct="results[question.id]"
                        :is-submitted="isSubmitted"
                    />
                </div>

                <button
                    @click="checkAnswers"
                    class="rounded-md bg-primary text-white px-6 py-4 w-full shadow-md !font-extrabold hover:bg-primary-hover transition-colors cursor-pointer"
                >
                    Submit Answers
                </button>
            </div>
        </div>
    </main>
</template>
