<template>

    <Head>
        <title>Oglasite nekretninu za izdavanje - Pronađite stanara odmah</title>
        <meta head-key="og:title" property="og:title" content="Oglasite nekretninu za izdavanje - Pronađite stanara odmah" />
        <meta head-key="description"  name="description" :content="meta.description">
        <meta head-key="og:description" property="og:description" :content="meta.description" />
    </Head>

    <div class="uk-section-muted uk-section">
        <div class="uk-container uk-container-xsmall">
            <div class="uk-card uk-card-small">
                <div class="uk-card-header">
                    <img src="/icons/house.svg" alt="kuća" width="50" height="50" uk-svg>
                    <h1 class="uk-card-title uk-margin-remove-top uk-text-bold">Oglasite vašu nekretninu</h1>
                    <p>
                        Steknite pristup tržištu izdavanja nekretnina u Srbiji. Oglasite svoj stan, kuću ili poslovni prostor na sajtu specijalizovanom za oglašavanje izdavanja nekretnina.
                    </p>
                </div>
                <div class="uk-card-body uk-padding-remove-top">
                    <h2 class="uk-h4 uk-text-bold">Brzo i lako napravite oglas za izdavanje</h2>
                    <div class="uk-list">
                        <div class="uk-margin-left"><img class="uk-text-danger" src="/icons/check-circle.svg" alt="icon" uk-svg> <span class="uk-text-middle">Besplatan oglas za izdavanje na izdajem.rs</span></div>
                        <div class="uk-margin-left"><img class="uk-text-danger" src="/icons/check-circle.svg" alt="icon" uk-svg> <span class="uk-text-middle">Oglašavajte se dok ne pronađete stanare</span></div>
                        <div class="uk-margin-left"><img class="uk-text-danger" src="/icons/check-circle.svg" alt="icon" uk-svg> <span class="uk-text-middle">Kreirajte, izmenite ili sačuvajte oglas za lako ponovno objavljivanje</span></div>
                        <div class="uk-margin-left"><img class="uk-text-danger" src="/icons/check-circle.svg" alt="icon" uk-svg> <span class="uk-text-middle">Primite obaveštenja od budućih stanara na izdajem.rs email ili sms</span></div>
                        <div class="uk-margin-left"><img class="uk-text-danger" src="/icons/check-circle.svg" alt="icon" uk-svg> <span class="uk-text-middle">Steknite pristup tržištu za izdavanja nekretnina</span></div>
                       <div class="uk-text-meta uk-margin-left">* Nema naknade za postavljanje oglasa</div>
                    </div>
                </div>
                <div class="uk-card-footer">
                    <Link class="uk-button uk-button-danger uk-button-large uk-width-auto@s uk-width-1-1" :href="route('listing.create')">Kliknite ovde da postavite oglas</Link>
                </div>
            </div>
        </div>
    </div>
    <div class="uk-section-default uk-section">
        <div class="uk-container">
            <div class="">
                <h2 class="uk-h2 uk-text-center">Često postavljana pitanja</h2>
                <div class="uk-alert uk-border-rounded-xl uk-padding-remove" v-for="q in qa" :key="q.id">
                    <div class="uk-grid-collapse uk-grid uk-padding-small" style="cursor: pointer" @click.prevent="addQa(q.id)" uk-grid>
                        <div class="uk-width-expand uk-text-emphasis">{{ q.title }}</div>
                        <div class="uk-width-auto">
                            <img :src="`/icons/chevron-${show.includes(q.id) ? 'up' : 'down'}.svg`" alt="više" uk-svg>
                        </div>
                    </div>
                    <p class="uk-padding-small" v-html="q.message" v-show="show.includes(q.id)"></p>
                </div>
            </div>
        </div>
    </div>

    <div class="uk-section-muted uk-section">
        <div class="uk-container">
            <h2 class="uk-h2 uk-text-bold">Spremni da oglasite vašu nekretninu?</h2>
            <p class="uk-text-bold uk-margin-left uk-text-meta">Steknite pristup tržištu izdavanja nekretnina u Srbiji</p>
            <div class="uk-grid uk-gird-collapse uk-flex-center" uk-grid>
                <div class="uk-width-large">
                    <div class="uk-card uk-card-default">
                        <div class="uk-card-body">
                            <div>
                                <img src="/icons/house-outline.svg" alt="kuća" width="50" height="50" uk-svg>
                                <p class="uk-text-bold uk-text-large">Želim da oglasim izdavanje stana, kuće ili poslovnog prostora u Srbiji!</p>
                            </div>
                        </div>
                        <div class="uk-card-footer">
                            <Link class="uk-button uk-button-large uk-button-danger uk-width-1-1" :href="route('listing.create')">Oglasi odmah</Link>
                        </div>
                    </div>
                </div>
                <div class="uk-width-auto">
                    <img src="/images/apartment-rent.svg" alt="kuća" width="480" height="320" uk-svg>
                </div>
            </div>
        </div>
    </div>

    <base-footer />
</template>

<script setup>
import {reactive} from "vue";
import BaseFooter from "@/Shared/Footer.vue";

    defineProps({
        qa: Object,
        meta: Object,
    })

    let show = reactive([]);

    let addQa = (id) => {
        let i = show.findIndex((s) => s === id);
         if( i === -1) {
            show.push(id);
        } else {
            show.splice(i, 1);
        }
    }

</script>

<style scoped>

</style>
