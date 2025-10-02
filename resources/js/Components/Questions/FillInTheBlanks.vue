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
    <div class="flex gap-3 lg:gap-6 items-start lg:items-center">
        <span class="rounded-full flex-none bg-black w-8 h-8 text-white flex items-center justify-center shadow-md font-extrabold">
            {{ question.order }}
        </span>

        <p class="text-lg flex-1">
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

            <span v-if="isSubmitted && !isCorrect" class="ml-2 text-green-600 font-semibold">
                ({{ question.answer }})
            </span>
        </p>
    </div>
</template>
