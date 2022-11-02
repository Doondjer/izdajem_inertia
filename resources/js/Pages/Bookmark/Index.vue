<template>

    <Head title="Sačuvane nekretnine" />

    <div class="uk-section uk-section-small" uk-height-viewport="expand: true">
        <div class="uk-container">
                <h1 class="uk-h2 uk-width-expand">Sačuvani Oglasi</h1>
        </div>

        <div class="uk-container uk-margin">

            <div class="uk-grid-small uk-position-relative uk-grid l-wrapper l-3-wrapper" v-if="Object.keys(listings.data).length" uk-grid="masonry: true">
                <listing-card class="spy" :listing="listing" v-for="listing in listings.data" :key="listing.id" />
            </div>
            <div v-else class="uk-text-center uk-margin-large-top">
                <p class="uk-h4 uk-text-bold">Ne pratite nijedan oglas!</p>
                <p><span class="uk-text-middle">Kliknite na</span> <img class="uk-text-danger" src="/icons/star-outline.svg" alt="zvezda" uk-svg> <span class="uk-text-middle">na bilo kom oglasu da dodate nekretninu u sačuvane oglase</span> </p>
            </div>
        </div>
    </div>
    <base-footer />
</template>

<script setup>
    import ListingCard from "@/Shared/ListingCard.vue";
    import BaseFooter from "@/Shared/Footer.vue";

    let props = defineProps({
        listings: Object,
    })
</script>
