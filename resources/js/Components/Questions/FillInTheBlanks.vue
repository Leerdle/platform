<script setup>
import { computed } from "vue";

const model = defineModel();

const props = defineProps({
    question: Object,
    isCorrect: Boolean,
    isSubmitted: Boolean
});

const setupInputField = computed(() => {
    return props.question.text.split('<mask>');
});

const inputClasses = computed(() => {
    const baseClasses = 'border-b-2 outline-none px-2 mx-1 w-36 transition-colors';

    if (!props.isSubmitted) {
        return `${baseClasses} border-gray-400 focus:border-black`;
    }

    return props.isCorrect
        ? `${baseClasses} border-green-500 bg-green-50`
        : `${baseClasses} border-red-500 bg-red-50`;
});
</script>

<template>
    <div class="card">
        <template v-for="(part, index) in setupInputField" :key="index">
            {{ part }}
            <input
                v-if="index < setupInputField.length - 1"
                type="text"
                v-model="model"
                :class="inputClasses"
                :placeholder="question.metadata.infinitive"
                :disabled="isSubmitted"
            />
        </template>

        <span class="!font-semibold">({{ question.metadata.infinitive }})</span>

        <div v-if="isSubmitted && !isCorrect" class="mt-4 text-green-600">
            Juiste Antwoord: <span class="!font-bold">{{ question.answer }}</span>
        </div>
    </div>
</template>
