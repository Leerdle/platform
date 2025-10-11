<script setup>
import { ref, computed } from "vue";
import Button from "@/Components/Buttons/CustomButton.vue";
import CheckMark from "@/Components/Icons/CheckMark.vue";
import ArrowRight from "@/Components/Icons/ArrowRight.vue";

const givenAnswers = ref([]);
const isSubmitted = ref(false);
const answerResults = ref([]);
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

const infinitiveList = computed(() => {
    return props.question.metadata.infinitive.join(', ');
});

const allCorrect = computed(() => {
    return answerResults.value.every(result => result === true);
});

const allIncorrect = computed(() => {
    return answerResults.value.every(result => result === false);
});

const submitPress = () => {
    if (!isSubmitted.value) {
        checkAnswer();
    } else {
        hideCard();
    }
};

const checkAnswer = () => {
    // Ensure answers array is properly initialized
    const answers = Array.isArray(props.question.answer)
        ? props.question.answer
        : [props.question.answer];

    // Check each answer
    answerResults.value = answers.map((correctAnswer, index) => {
        const userAnswer = givenAnswers.value[index] || '';
        return userAnswer.toLowerCase() === correctAnswer.toLowerCase();
    });

    isSubmitted.value = true;
};

const hideCard = () => {
    isHiding.value = true;

    setTimeout(function() {
        hide.value = true;
    }, 500);
};

const getInputClass = (index) => {
    if (!isSubmitted.value) return inputClasses.value;

    const isCorrect = answerResults.value[index];
    return [
        inputClasses.value,
        {
            'border-green-500 bg-green-50': isCorrect,
            'border-red-500 bg-red-50': !isCorrect
        }
    ];
};
</script>

<template>
    <div class="bg-white rounded-2xl p-6 md:p-14 shadow-xl w-full text-center min-h-[330px] flex flex-col items-center justify-center transition-all duration-500"
         :style="{
            zIndex: zIndex,
            transform: isHiding ? 'translateY(50px)' : 'translateY(0)',
            opacity: isHiding ? 0 : 1,
            display: hide ? 'none' : 'block'
         }">
        <form @submit.prevent="submitPress" class="flex flex-col items-center justify-center h-full">
            <span class="text-lg leading-relaxed text-gray-800">
                <template v-for="(part, index) in setupInputField" :key="index">
                    {{ part }}
                    <input
                        v-if="index < setupInputField.length - 1"
                        type="text"
                        autocapitalize="none"
                        v-model="givenAnswers[index]"
                        :class="getInputClass(index)"
                        :placeholder="question.metadata.infinitive[index]"
                        :readonly="isSubmitted"
                        autocomplete="off"
                        :aria-label="`Fill in blank ${index + 1}`"
                    />
                </template>
                <span class="!font-bold">({{ infinitiveList }})</span>
            </span>

            <div v-if="isSubmitted" class="mt-8">
                <div v-if="allCorrect" class="flex items-center gap-2 justify-center text-green-600 font-semibold text-lg">
                    <span class="text-2xl">✓</span>
                    <span class="!font-bold">Proficiat!</span>
                </div>
                <div v-else-if="allIncorrect" class="text-red-600">
                    <div class="flex items-center gap-2 justify-center font-semibold mb-2">
                        <span class="text-xl">✕</span>
                        <span class="!font-bold">Fout!</span>
                    </div>
                    <div class="text-gray-700 text-sm space-y-1">
                        <div v-for="(answer, idx) in (Array.isArray(question.answer) ? question.answer : [question.answer])" :key="idx">
                            <span class="text-gray-600">{{ question.metadata.infinitive[idx] }}:</span>
                            <strong class="!font-bold text-red-600 ml-1">{{ answer }}</strong>
                        </div>
                    </div>
                </div>
                <div v-else class="text-gray-700">
                    <div class="flex items-center gap-2 justify-center font-semibold mb-2 text-orange-600">
                        <span class="text-xl">~</span>
                        <span class="!font-bold">Gedeeltelijk correct</span>
                    </div>
                    <div class="text-sm space-y-1">
                        <div v-for="(answer, idx) in (Array.isArray(question.answer) ? question.answer : [question.answer])" :key="idx">
                            <span v-if="answerResults[idx]" class="text-green-600">
                                <span class="text-gray-600">{{ question.metadata.infinitive[idx] }}:</span>
                                <strong class="!font-bold ml-1">{{ answer }}</strong> ✓
                            </span>
                            <span v-else class="text-red-600">
                                <span class="text-gray-600">{{ question.metadata.infinitive[idx] }}:</span>
                                <strong class="!font-bold ml-1">{{ answer }}</strong> ✕
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-10 mt-8 justify-center">
                <Button :is-submit="true">
                    <CheckMark v-if="!isSubmitted" />
                    <ArrowRight v-else />
                </Button>
            </div>
        </form>
    </div>
</template>
