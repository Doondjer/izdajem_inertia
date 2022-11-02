<template>
    <edit
        :percent="100"
        :l="listing.data"
        step="provera"
        title="Provera detalja"
        :proceed="form.terms && ! Object.keys(errors).length && ! form.processing"
        :loading="form.processing"
        :prevLink="route('listing.edit', {listing: listing.data.slug, step: 'slike'})"
        :nextText="listing.data.is_published ? null : 'Objavi'"
        @next="submit"
    >
                <notice v-if="Object.keys(errors).length" icon="warning" color="danger">
                    Da biste objavili oglas morate ispraviti sledeće informacije na prethodnim koracima:
                    <ul class="uk-margin-small-top">
                        <li v-for="(error, name) in errors" :key="name">{{ error[0] }} </li>
                    </ul>
                </notice>
                <div v-if="! listing.data.is_published">
                    <h3 class="uk-h4 uk-text-bold">Proverite detalje oglasa pre nego što ga objavite.</h3>
                    <p>Posle objavljivanja vaš oglas će biti vidljiv za druge. Kako bi unapredili iskustvo drugih korisnika sadržaj oglasa će biti proveren i od strane našeg tima.</p>
                </div>
                <div v-else>
                    <h3 class="uk-h4 uk-text-bold">Vaš oglas je već objavljen.</h3>
                    <p>Vaš oglas je vidljiv za druge sa detaljima koji se nalaze ispod. Kako to izgleda drugima saznajte klikom <Link class="uk-text-bold uk-text-danger" :href="route('listing.show', listing.data.slug)">OVDE</Link>.</p>
                </div>

                <ul class="uk-tab">
                    <li :class="{'uk-active': tab === 1}">
                        <a @click.prevent="show=true; tab=1" href="#">
                            <img class="uk-margin-small-right" src="/icons/ul.svg" width="24" height="24" alt="Oglas" uk-svg>
                            <span class="uk-text-middle">Oglas</span>
                        </a>
                    </li>
                    <li :class="{'uk-active': tab === 2}">
                        <a @click.prevent="show=false;tab=2" href="#">
                            <img class="uk-margin-small-right" src="/icons/home.svg" width="24" height="24" alt="Nekretnina" uk-svg>
                            <span class="uk-text-middle">Nekretnina</span>
                        </a>
                    </li>
                </ul>
                <div v-show="show">
                    <div class="uk-h4 uk-text-bold uk-position-relative">
                        <img class="uk-margin-small-right" src="/icons/user.svg" alt="korisnik" width="30" height="30" uk-svg>
                        <span class="uk-text-middle">Kontakt</span>
                        <Link class="uk-position-right uk-text-small" :href="route('profile.show', listing.data.user.id)">Izmeni</Link>
                    </div>
                    <p>{{ listing.data.user.fullname }} {{ listing.data.user.phone }}</p>

                    <notice v-if="!listing.data.user.phone" message="Vaš profil ne sadrži broj telefona, pa će potencijalni stanari moći da vas kontaktiraju samo putem poruka na izdajem.rs." />

                    <hr class="uk-hr">

                    <div class="uk-h4 uk-text-bold uk-position-relative">
                        <img class="uk-margin-small-right" src="/icons/file-text.svg" alt="Opis" width="30" height="30" uk-svg>
                        <span class="uk-text-middle">Opis</span>
                        <Link :href="route('listing.edit', {listing: listing.data.slug, step: 'opis'})" class="uk-position-right uk-text-small">Izmeni</Link>
                    </div>
                    <p v-html="listing.data.description"></p>
                </div>
                <div v-show=" ! show">
                    <div class="uk-h4 uk-text-bold uk-position-relative">
                        <img class="uk-margin-small-right" src="/icons/info.svg" alt="Info" width="30" height="30" uk-svg>
                        <span class="uk-text-middle">Dostupnost & Cena</span>
                        <Link :href="route('listing.edit', {listing: listing.data.slug, step: 'cena'})" class="uk-position-right uk-text-small">Izmeni</Link>
                    </div>
                    <div class="uk-grid uk-child-width-1-2">
                        <div>Slobodno od:</div><div>{{ listing.data.available_from }}</div>
                        <div>Cena izdavanja:</div><div><img class="uk-margin-small-right" src="/icons/eur.svg" alt="E" uk-svg> <span class="uk-text-middle">{{ listing.data.price }}</span></div>
                        <div>Depozit:</div><div><img class="uk-margin-small-right" src="/icons/eur.svg" alt="E" uk-svg> <span class="uk-text-middle">{{ listing.data.deposit }}</span></div>
                    </div>

                    <hr class="uk-hr">

                    <div class="uk-h4 uk-text-bold uk-position-relative">
                        <img class="uk-margin-small-right" src="/icons/options.svg" alt="Opcije" width="30" height="30" uk-svg>
                        <span class="uk-text-middle">Opremljenost nekretnine</span>
                        <Link :href="route('listing.edit', {listing: listing.data.slug, step: 'opremljenost'})" class="uk-position-right uk-text-small">Izmeni</Link>
                    </div>
                    <div class="uk-grid uk-child-width-1-2">
                        <div v-for="amenity in listing.data.amenities">
                            <img class="uk-margin-small-right" :src="`/icons/${amenity.icon}.svg`" :alt="amenity.icon" uk-svg> <span class="uk-text-middle">{{ amenity.name }}</span>
                        </div>
                        <div v-for="security in listing.data.securities">
                            <img class="uk-margin-small-right" :src="`/icons/${security.icon}.svg`" :alt="security.icon" uk-svg> <span class="uk-text-middle">{{ security.name }}</span>
                        </div>
                    </div>
                    <hr class="uk-hr">

                    <div class="uk-h4 uk-text-bold uk-position-relative">
                        <img class="uk-margin-small-right" src="/icons/kvadratura.svg" alt="Kvadratura" width="30" height="30" uk-svg>
                        <span class="uk-text-middle">Površina i tip nekretnine</span>
                        <Link :href="route('listing.edit', {listing: listing.data.slug, step: 'detalji'})" class="uk-position-right uk-text-small">Izmeni</Link>
                    </div>
                    <div class="uk-grid uk-child-width-1-2">
                        <div>Površina</div><div><span class="uk-text-middle">{{ listing.data.size || 'null' }}</span> <img width="16" height="16" src="/icons/square-meter.svg" alt="m2" uk-svg></div>
                        <div>Tip</div><div class="uk-text-capitalize">{{ listing.data.type}}</div>
                    </div>
                    <hr class="uk-hr">

                    <div class="uk-h4 uk-text-bold uk-position-relative">
                        <img class="uk-margin-small-right" src="/icons/images.svg" alt="Slike" width="30" height="30" uk-svg>
                        <span class="uk-text-middle">Slike</span>
                        <Link :href="route('listing.edit', {listing: listing.data.slug, step: 'slike'})" class="uk-position-right uk-text-small">Izmeni</Link>
                    </div>
                    <div class="uk-grid-small" uk-grid>
                        <div v-for="image in listing.data.images">
                            <img height="200" width="200" class="uk-border-rounded uk-margin-small" :src="`${$page.props.config.image_base_route}/200/${image.filename}`">
                        </div>
                    </div>
                </div>

                <hr class="uk-hr" />

                <div class="uk-flex-center uk-flex uk-text-center">
                    <listing-card :listing="listing.data" />
                </div>

                <hr v-if="! listing.data.is_published" class="uk-hr" />

                <div v-if="! listing.data.is_published">


                    <div class="uk-h4 uk-text-bold">
                        <img class="uk-margin-small-right" src="/icons/publish.svg" alt="Objavi" width="30" height="30" uk-svg>
                        <span class="uk-text-middle">Objavljivanje oglasa</span>
                    </div>
                    <notice v-if=" ! Object.keys(errors).length" color="">
                        Postavljanje oglasa na izdajem.rs se ne naplaćuje. Nadamo se da ćete brzo izdati vašu nekretninu!
                    </notice>

                    <notice v-if="Object.keys(errors).length" message="Ne možete objaviti oglas dok ne ispravite informacije na prethodnim koracima!" icon="warning" />

                    <p v-if=" ! Object.keys(errors).length">
                        <checkbox v-model:checked="form.terms" :disabled="!!Object.keys(errors).length" name="terms">Slažem se sa <a href="#">pravilima i uslovima oglašavanja.</a></checkbox>
                    </p>
                </div>

    </edit>
</template>

<script setup>
    import Edit from "@/Pages/Listing/Edit.vue";
    import {useForm} from "@inertiajs/inertia-vue3";
    import ListingCard from "@/Shared/ListingCard.vue";
    import Checkbox from "@/Shared/Checkbox.vue";
    import Notice from "@/Shared/Notice.vue";
    import {ref} from "vue";

    let props = defineProps({
        listing: Object,
        errors: Object,
    })

    let show = ref(true);
    let tab = ref(1);

    let form = useForm({
        terms: false,
    })

    let submit = () => {
        form.transform(data => ({
            ...data,
            ...props.listing.data,
        })).patch(route('listing.publish', {listing: props.listing.data.slug}), {
            preserveScroll: true
        });
    }
</script>
