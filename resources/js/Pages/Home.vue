<script setup>
defineProps({
    exercise: Object
});

const splitText = (text) => {
    return text.split(/(<mask>)/).filter(part => part !== '');
}

const submitAnswers = () => {
    console.log('Submitted answers:');
}
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-purple-50 to-blue-50 p-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-4">
                <h1 class="text-4xl font-bold text-blue-600 mb-2">Nederlands Oefening</h1>
                <p class="text-gray-600">Vul de juiste werkwoordsvorm in</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-4">
                <div class="space-y-6">
                    <div v-for="question in exercise.questions" :key="question.id" class="flex gap-4">
                        <div class="flex-shrink-0 w-8 h-8 bg-purple-200 rounded-full flex items-center justify-center text-purple-700 font-semibold">
                            {{ question.order }}
                        </div>
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <template v-for="(part, index) in splitText(question.text)" :key="index">
                                    <span v-if="part !== '<mask>'">{{ part }}</span>
                                    <input
                                        v-else
                                        type="text"
                                        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400 min-w-[120px]"
                                        placeholder="..."
                                    >
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-8">
                    <button
                        @click="submitAnswers"
                        class="px-8 py-3 bg-purple-400 hover:bg-purple-500 text-white font-semibold rounded-lg transition-colors"
                    >
                        Antwoorden Indienen
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
