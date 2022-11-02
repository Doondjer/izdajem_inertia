<template>
    <div>
        <h2 class="uk-h5 uk-text-bold">Opšti uslovi izdavanja</h2>
        <div class="uk-grid uk-child-width-1-1  uk-child-width-1-2@s">
            <div class="uk-margin-small-bottom" v-if="l.deposit"><span class="uk-text-muted">Depozit</span><span class="uk-align-right">{{ l.deposit_for_human }}</span></div>
            <div class="uk-margin-small-bottom" v-if="l.lease_min_moths"><span class="uk-text-muted">Minimalni zakup</span><span class="uk-align-right">{{ l.lease_min_moths_human }}</span></div>
            <div class="uk-margin-small-bottom" v-if="l.payment_interval"><span class="uk-text-muted">Period plaćanja</span><span class="uk-align-right">{{ l.payment_interval_human }}</span></div>
            <div class="uk-margin-small-bottom" v-if="l.available_from_formated"><span class="uk-text-muted">Useljivo od</span><span class="uk-align-right">{{ l.available_from_formated }}</span></div>
        </div>
        <div class="uk-margin-small-bottom">
                                    <span class="uk-text-muted uk-margin-right" v-if=" ! (l.pets && l.pets.length)">
                                        <s>Dozvoljeni ljubimci</s>
                                    </span>
            <span class="uk-text-muted uk-margin-right" v-else>Dozvoljeni ljubimci</span>

            <span class="uk-label uk-margin-small-left" v-for="pet in l.pets" :key="pet.id">{{ pet.name }}</span>
            <s class="uk-text-muted" v-if="! (l.pets && l.pets.length)">Nema informacija</s>
        </div>
    </div>
</template>

<script setup>
    defineProps({
        l: Object
    });
</script>
