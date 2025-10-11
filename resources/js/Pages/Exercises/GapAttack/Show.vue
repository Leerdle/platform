<script setup>
import FillInTheBlanks from "@/Components/Questions/FillInTheBlanks.vue";
import PageTitle from "@/Components/Titles/PageTitle.vue";

const props = defineProps({
    exercise: Object
});
</script>

<template>
    <Head :title="props.exercise?.title ?? 'Daily Game'" />
        <PageTitle
            v-if="props.exercise?.title !== '' && props.exercise?.description !== ''"
            :title="props.exercise.title"
            :description="props.exercise.description"
        />

        <div class="grid w-full max-w-md m-auto" v-if="props.exercise?.questions?.length > 0">
            <FillInTheBlanks
                v-for="(question, index) in props.exercise?.questions"
                :key="index"
                :question="question"
                :z-index="props.exercise?.questions.length - index"
                :index="index"
                class="col-start-1 row-start-1"
            />
        </div>
</template>
