<script setup>
import FillInTheBlanks from "@/Components/Questions/FillInTheBlanks.vue";
import GameTitle from "@/Components/Titles/GameTitle.vue";
import GameLayout from "@/Layouts/GameLayout.vue";

const props = defineProps({
    exercise: Object
});
</script>

<template>
    <Head :title="props.exercise?.title ?? 'Daily Game'" />

    <GameLayout>
        <GameTitle v-if="props.exercise?.title !== '' && props.exercise?.description !== ''"
                   :title="props.exercise.title"
                   :description="props.exercise.description" />

        <div class="grid w-full max-w-md" v-if="props.exercise?.questions?.length > 0">
            <FillInTheBlanks
                v-for="(question, index) in props.exercise?.questions"
                :key="index"
                :question="question"
                :z-index="props.exercise?.questions.length - index"
                :index="index"
                class="col-start-1 row-start-1"
            />
        </div>
    </GameLayout>
</template>
