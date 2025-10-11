<script setup>
import GameListCard from "@/Components/Cards/GameListCard.vue";
import PageTitle from "@/Components/Titles/PageTitle.vue";
</script>

<template>
    <Head title="Home" />

    <PageTitle
        title="Today's Exercises"
        description="Practice your Dutch with today's fresh exercises. Complete them at your own pace, and come back tomorrow for new challenges. Consistent daily practice is the key to mastering Dutch!"
    />

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <GameListCard
            color="lilac"
            title="Gap Attack"
            subtitle="Imperfectum"
            start-href="gap-attack.show"
            :is-start-disabled="false"
            :is-past-disabled="true"
        />

        <GameListCard
            color="lavender"
            title="Gap Attack"
            subtitle="Presens"
            :is-start-disabled="true"
            :is-past-disabled="true"
        />

        <GameListCard
            color="green"
            title="Gap Attack"
            subtitle="Perfectum"
            :is-start-disabled="true"
            :is-past-disabled="true"
        />

        <GameListCard
            color="grey"
            title="Gap Attack"
            subtitle="Futurum"
            :is-start-disabled="true"
            :is-past-disabled="true"
        />
    </div>
</template>
