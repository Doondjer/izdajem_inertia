<template>
    <div class="uk-card-body uk-text-center">
        <div class="uk-text-right">
            <a class="uk-icon-button uk-button-default" title="Podeli sa drugima" href="#" @click.prevent="show = true">
                <img src="/icons/social.svg" alt="podeli_sa_drugima_icon" height="24" width="24" uk-svg />
            </a>
            <Link class="uk-icon-button uk-button-default uk-margin-small-left"
                  :class="{'uk-disabled uk-text-meta': l.is_owner, 'uk-button-danger': l.is_bookmarked }"
                  :title="l.is_bookmarked ? 'Izbaci iz odabranih' : 'Dodaj u odabrane'"
                  :href="route('bookmark.store', l.slug)"
                  as="button"
                  method="POST"
                  preserve-scroll
            >
                <img src="/icons/star.svg" alt="sacuvaj_icon" height="24" width="24" uk-svg />
            </Link>
        </div>
        <h1 class="uk-card-title uk-margin-small-top" v-text="`${l.street}, ${l.city}, ${l.district}`"></h1>
        <div class="uk-grid uk-grid-small uk-grid-divider uk-flex-center" uk-grid>
            <div>
                <span class="uk-margin-small-left" v-text="l.type_human"></span>
            </div>
            <div>
                <img src="/icons/floor-plan.svg" alt="plan_objekta_icon" uk-svg />
                <span class="uk-margin-small-left" v-text="l.nb_room_human"></span>
            </div>
            <div>
                <img src="/icons/kvadratura.svg" alt="kvadratura_icon" uk-svg />
                <span class="uk-margin-small-left" v-text="l.size ? l.size + '  m²' : ''"></span>
            </div>
            <div>
                <img src="/icons/namestenost.svg" alt="namestenost_icon" uk-svg />
                <span class="uk-margin-small-left" v-text="l.furnish_type_human"></span>
            </div>
        </div>
    </div>
    <div class="uk-flex uk-flex-middle uk-flex-center@m uk-padding-small uk-text-center@m" v-if="l.status !== 'rented'">
        <div class="uk-width-expand">
            <div class="uk-text-bold"><span class="uk-text-danger uk-text-large">{{ l.price_for_human }}</span><span class="uk-visible@xs"> / Mesečno</span></div>
            <div v-if="l.deposit">Depozit <span class="uk-text-bold">{{ l.deposit_for_human }}</span></div>
        </div>
        <div class="uk-hidden@m" v-if="l.available_from_formated">
            Dostupno: <span class="uk-text-danger uk-text-bold uk-margin-small-left">{{ l.available_from_formated }}</span>
        </div>
    </div>
    <div v-else class="uk-flex uk-flex-center uk-text-center uk-h1 uk-text-bold uk-text-danger uk-margin">Izdato</div>
    <div class="uk-flex uk-flex-bottom uk-flex-center uk-visible@m uk-padding-small" v-if="l.available_from_formated">
        Dostupno: <span class="uk-text-bold uk-margin-small-left">{{ l.available_from_formated }}</span>
    </div>

    <sharing-modal :l="l" v-if="show" @close="show = false"/>

</template>

<script setup>

    const SharingModal = defineAsyncComponent(() =>  import('@/Shared/SharingModal.vue'));


    import {defineAsyncComponent, ref} from "vue";
    import {Inertia} from "@inertiajs/inertia";

    let props = defineProps({
        l: Object,
        user: Object
    })

    let show = ref(false);

    let bookmark = () => {
        Inertia.post(route('bookmark.store', props.l.slug), {
            preserveScroll: true
        });
    }
</script>

<style>

</style>
