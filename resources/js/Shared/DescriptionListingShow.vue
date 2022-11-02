<template>
    <div>
        <h2 v-if="l.description" class="uk-h5 uk-text-bold">Opis</h2>
        <div property="schema:description" v-if="l.description" :class="{ 'view-more': l.description.length > 300, 'view-more-expand': toggle }" v-html="l.description"></div>
        <div v-if="l.description" class="uk-width uk-text-right">
            <a v-if="l.description.length > 300" href="#" @click.prevent="toggle = ! toggle">
                <span class="uk-text-middle">{{ toggle ? 'Manje' : 'Više'}} Informacija</span>
                <img :src="`/icons/${toggle ? 'chevron-up' : 'chevron-down'}.svg`" class="uk-margin-small-left uk-icon" alt="pogledaj više" uk-svg>
            </a>
        </div>
    </div>
</template>

<script setup>
    import {ref} from "vue";

    defineProps({
        l: Object,
    })

    let toggle = ref(false);
</script>
