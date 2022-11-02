<template>
    <div>
        <h2 class="uk-h5 uk-text-bold">Osnovne informacije</h2>
        <div class="uk-grid uk-child-width-1-1  uk-child-width-1-2@s">
            <div class="uk-margin-small-bottom"><span class="uk-text-muted">Struktura</span><span class="uk-align-right">{{ l.nb_room_human }}</span></div>
            <div class="uk-margin-small-bottom"><span class="uk-text-muted">Površina</span><span class="uk-align-right">{{ `${l.size} m²` }}</span></div>
            <div class="uk-margin-small-bottom" v-if="l.nb_floor"><span class="uk-text-muted">Sprat</span><span class="uk-align-right">{{ l.nb_floor }}</span></div>
            <div class="uk-margin-small-bottom" v-if="l.total_floor"><span class="uk-text-muted">Ukupno spratova</span><span class="uk-align-right">{{ l.total_floor }}</span></div>
            <div class="uk-margin-small-bottom"><span class="uk-text-muted">Vrsta objekta</span><span class="uk-align-right">{{ l.type_human }}</span></div>
            <div class="uk-margin-small-bottom"><span class="uk-text-muted">Nameštenost</span><span class="uk-align-right">{{ l.furnish_type_human }}</span></div>
        </div>
    </div>
</template>

<script setup>
    defineProps({
        l: Object
    })
</script>
