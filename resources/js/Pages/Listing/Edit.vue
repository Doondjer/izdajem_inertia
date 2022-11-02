<template>

    <Head title="Oglasite nekretninu za izdavanje - Pronađite stanara odmah" />

    <div class="uk-section-xsmall uk-section-default" uk-height-viewport="expand: true">
        <div class="uk-grid uk-grid-collapse uk-text-center uk-child-width-1-6 uk-visible@m" uk-grid>
            <div><Link class="uk-button uk-button-link uk-padding-small uk-width" :class="{'uk-text-bold uk-disabled': step ==='detalji'}" :href="route('listing.edit',{listing: l.slug, step: 'detalji'})">Detalji</Link></div>
            <div><Link class="uk-button uk-button-link uk-padding-small uk-width" :class="{'uk-text-bold uk-disabled': step === 'opremljenost'}" :href="route('listing.edit',{listing: l.slug, step: 'opremljenost'})">Opremljenost</Link></div>
            <div><Link class="uk-button uk-button-link uk-padding-small uk-width" :class="{'uk-text-bold uk-disabled': step === 'cena'}" :href="route('listing.edit',{listing: l.slug, step: 'cena'})">Cena</Link></div>
            <div><Link class="uk-button uk-button-link uk-padding-small uk-width" :class="{'uk-text-bold uk-disabled': step === 'opis'}" :href="route('listing.edit',{listing: l.slug, step: 'opis'})">Opis</Link></div>
            <div><Link class="uk-button uk-button-link uk-padding-small uk-width" :class="{'uk-text-bold uk-disabled': step === 'slike'}" :href="route('listing.edit',{listing: l.slug, step: 'slike'})">Slike</Link></div>
            <div><Link class="uk-button uk-button-link uk-padding-small uk-width" :class="{'uk-text-bold uk-disabled': step === 'provera'}" :href="route('listing.edit',{listing: l.slug, step: 'provera'})">Provera</Link></div>
        </div>
        <div class="uk-padding-small uk-padding-remove-vertical"><progress id="js-progressbar" class="uk-progress" max="100" :value="percent"></progress></div>
        <div class="uk-container uk-container-xsmall uk-height-viewport">

            <card :title="title" :border="false">

                <template #body>

                    <slot />

                </template>

                <template #footer>
                    <div class="uk-padding-small uk-padding-remove-horizontal uk-margin-remove-top uk-hr uk-grid uk-grid-small uk-child-width-1-2" uk-grid>
                        <div>
                            <Link as="button" v-if="prevLink" :href="prevLink" class="uk-button uk-button-large uk-button-default">{{ prevText }}</Link>
                        </div>
                        <div v-if="nextText">
                            <loading-button class="uk-button-large uk-button-default uk-width-1-1 uk-text-nowrap uk-padding-remove-horizontal"
                                            :class=" ! proceed ? 'uk-disabled ' : 'uk-button-danger'"
                                            :disabled=" ! proceed"
                                            :loading="loading"
                                            @click.prevent="$emit('next')"
                            >
                                {{ nextText }}
                            </loading-button>
                        </div>
                    </div>
                </template>

            </card>
        </div>
    </div>

    <hr class="uk-hr uk-margin-remove" />

    <base-footer />
</template>

<script setup>
    import Card from "@/Shared/Card.vue";
    import LoadingButton from "@/Shared/LoadingButton.vue";
    import BaseFooter from "@/Shared/Footer.vue";

    defineProps({
        percent: Number,
        l: Object,
        step: String,
        title: String,
        proceed: {
            type: Boolean,
            default: false
        },
        loading: {
            type: Boolean,
            default: false
        },
        nextText: {
            type: String,
            default: 'Sačuvaj & Nastavi'
        },
        prevLink: String,
        prevText: {
            type: String,
            default: 'Prethodno'
        }
    })
    defineEmits(['next'])
</script>
