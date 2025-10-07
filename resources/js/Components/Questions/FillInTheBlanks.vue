<script setup>
import { ref, computed } from "vue";

const givenAnswer = ref('');
const isSubmitted = ref(false);
const isCorrect = ref(false);
const isHiding = ref(false);
const hide = ref(false);

const props = defineProps({
    question: Object,
    zIndex: Number,
    index: Number
});

const setupInputField = computed(() => {
    return props.question.text.split('<mask>');
});

const inputClasses = computed(() => {
    return 'border-b-2 outline-none px-1 mx-1 w-36 transition-colors';
});

const checkAnswer = () => {
    isCorrect.value = givenAnswer.value === props.question.answer;
    isSubmitted.value = true;
};

const hideCard = () => {
    isHiding.value = true;
    setTimeout(function() {
        hide.value = true;
    }, 500);
};
</script>

<template>
    <div class="bg-white rounded-2xl p-6 md:p-14 shadow-xl w-full text-center min-h-[330px] flex flex-col items-center justify-center transition-all duration-500"
         :style="{
            zIndex: zIndex,
            transform: isHiding ? 'translateY(-50px)' : 'translateY(0)',
            opacity: isHiding ? 0 : 1,
            display: hide ? 'none' : 'block'
         }">
        <form @submit.prevent="checkAnswer" class="flex flex-col items-center justify-center h-full">
            <span class="text-lg leading-relaxed text-gray-800">
                <template v-for="(part, index) in setupInputField" :key="index">
                    {{ part }}
                    <input
                        v-if="index < setupInputField.length - 1"
                        type="text"
                        v-model="givenAnswer"
                        :class="[inputClasses, {
                            'border-green-500 bg-green-50' : isSubmitted && isCorrect,
                            'border-red-500 bg-red-50' : isSubmitted && !isCorrect
                        }]"
                        :placeholder="question.metadata.infinitive"
                        :readonly="isSubmitted"
                        autocomplete="off"
                        aria-label="Fill in the blank"
                    />
                </template>
                <span class="!font-bold">({{ question.metadata.infinitive }})</span>
            </span>

            <div v-if="isSubmitted" class="mt-8">
                <div v-if="isCorrect" class="flex items-center gap-2 justify-center text-green-600 font-semibold text-lg">
                    <span class="text-2xl">✓</span>
                    <span class="!font-bold">Proficiat!</span>
                </div>
                <div v-else class="text-red-600">
                    <div class="flex items-center gap-2 justify-center font-semibold mb-1">
                        <span class="text-xl">✕</span>
                        <span class="!font-bold">Fout!</span>
                    </div>
                    <div class="text-gray-700 text-sm">
                        Antwoord: <strong class="!font-bold text-red-600">{{ question.answer }}</strong>
                    </div>
                </div>
            </div>

            <div class="flex gap-10 mt-8 justify-center">
                <button type="submit"
                    v-if="!isSubmitted"
                    class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-2xl cursor-pointer hover:scale-110 transition-transform">
                    ✓
                </button>
                <button type="button"
                    @click="hideCard"
                    v-else
                    class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-2xl cursor-pointer hover:scale-110 transition-transform">
                    →
                </button>
            </div>
        </form>
    </div>
</template>
