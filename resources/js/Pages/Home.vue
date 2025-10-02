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

    const correctCount = Object.values(results.value).filter(Boolean).length;
    const totalCount = props.exercise.questions.length;
};
</script>

<template>
    <Head title="Daily Game" />
    <main class="w-full max-w-5xl m-auto p-4 lg:p-8">
        <h1 class="mb-6 font-bold text-3xl lg:mb-8">{{ exercise.title }}</h1>
        <p class="mb-6 lg:mb-8 text-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin mauris justo, rhoncus eget tellus non, dictum eleifend risus. Nam quis neque accumsan, dapibus lectus in, varius tortor. Nulla sit amet posuere risus.</p>

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
            class="rounded-full bg-black text-white px-6 py-2 shadow-md font-extrabold hover:bg-gray-800 transition-colors cursor-pointer"
        >
            Submit
        </button>
    </main>
</template>
