<template>
        <div class="uk-section uk-section-small uk-section-default uk-card" v-if="message">
            <div class="uk-container uk-container-small">

                <p class="uk-grid uk-grid-small"><span class="uk-width-auto"><img src="/icons/info.svg" alt="i" width="40" height="40" uk-svg></span><span class="uk-width-expand" v-text="message"></span></p>
            </div>
        </div>
        <hr class="uk-hr uk-margin-remove" v-if="message">

</template>

<script setup>
defineProps({
    message: String
})
</script>

<style scoped>

</style>
