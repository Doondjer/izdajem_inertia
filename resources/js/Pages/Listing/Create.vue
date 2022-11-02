<template>

    <Head title="Oglasite nekretninu za izdavanje - Pronađite stanara odmah" />

    <div class="uk-section-small uk-section-default" uk-height-viewport="expand: true">
        <div class="uk-container uk-container-xsmall">
            <div class="uk-card uk-card-small">
                <div class="uk-card-header">
                    <h1 class="uk-card-title">Na kojoj adresi se nalazi nekretnina?</h1>
                </div>
                <form @submit.prevent="submit">
                    <div class="uk-card-body">

                        <notice message="Zbog bržeg izdavanja ostavite što više detalja o vašoj nekretnini, mi smo tu da vam na tom putu pomognemo." color="primary" />

                        <notice v-if="form.street" icon="warning" message="Adresu nije moguće promeniti jednom kada nastavite" />
                        <div class="uk-margin">
<!--                            <label for="address_search" class="uk-text-bold">Adresu nije moguće promeniti jednom kada nastavite</label>-->
                            <label for="address_search" class="uk-text-bold">Počnite sa unosom grada i ulice pa odaberite adresu iz padajuće liste</label>
                            <div class="uk-inline uk-width-1-1">
                                    <span v-if="autocomplete.processing || location.processing" class="uk-form-icon uk-text-danger" uk-spinner></span>
                                   <span v-else uk-icon="search" class="uk-form-icon uk-icon"></span>
                                   <button type="button" uk-icon="icon: close" v-if="address.length" title="Očisti" class="uk-form-icon uk-form-icon-flip uk-text-danger" @click.prevent="clear"></button>

                                   <input type="text"
                                          id="address_search"
                                          placeholder="npr. Ljutice Bogdana 10, Beograd"
                                          class="uk-input uk-form-large"
                                          :class="{'uk-form-danger': autocomplete.errors.search || autocomplete.processing || location.processing}"
                                          v-model="address"
                                          @keyup="isAutocomplete = true"
                                          autocomplete="off"
                                   >

                            </div>
                            <div class="uk-dropdown uk-open uk-dropdown-search" v-if="autocomplete.hasData">
                                <ul class="uk-nav uk-nav-search">
                                    <li v-for="item in autocomplete.data" :key="item.id">
                                        <a class="uk-text-meta uk-text-italic" href="#" @click.prevent="getLocation(item.id)">
                                            {{ item.title.slice(0,item.highlights.title[0].start) }} <em><b> {{ item.title.slice(item.highlights.title[0].start,item.highlights.title[0].end) }} </b></em> {{ item.title.slice(item.highlights.title[0].end) }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="uk-form-controls"  v-if="form.isDirty">
                            <label for="nb_street" class="uk-form-label uk-text-small">Ukoliko vam se broj u ulici nije pojavio, unesite ga ovde(Opciono):</label>
                            <div class="uk-inline uk-width-1-1">

                                <span uk-icon="location" class="uk-form-icon uk-icon"></span>
                                <input id="nb_street"
                                       v-model="form.street_nb"
                                       class="uk-input uk-form-large uk-width-small"
                                       :class="{'uk-form-danger': form.errors.street_nb}"
                                       type="text"
                                       aria-describedby="ukoliko-vam-se-broj-u-ulici-nije-pojavio,-unesite-ga-ovde(opciono)"
                                       placeholder="Broj ...">

                                <div v-if="form.errors.street_nb" class="uk-text-danger uk-text-left" v-text="form.errors.street_nb"></div>

                            </div>
                        </div>

                        <div v-if="form.isDirty" class="uk-margin-top">
                            Nastavljate sa adresom:
                            <span class="uk-text-bold">{{ `${form.street || ''}${form.street_nb ? ' '+form.street_nb : ''} ${form.postal_code ? ' '+form.postal_code : ''} ${form.city}, ${form.country}` }}</span>

                            <div class="uk-grid uk-grid-small uk-text-meta" v-if="form.street">
                                <div class="uk-width-auto">
                                    <img src="/icons/info.svg" alt="i" uk-svg>
                                </div>
                                <div class="uk-width-expand">Ogalašavate vašu nekretninu besplatno</div>
                            </div>
                            <div class="uk-text-danger uk-text-left" v-else>Morate uneti naziv ulice u polje pretrage, da biste nastavili!</div>
                        </div>

                        <div class="uk-padding-small uk-border-rounded-xl uk-background-muted" v-if="form.hasErrors">
                            <div v-for="(error, name) in form.errors" :key="name">
                                <div class="uk-text-danger uk-text-left" v-text="error"></div>
                            </div>
                        </div>

                        <text-input v-if="store_route !== route('listing.store')"
                            class="uk-margin"
                            v-model="form.user_id"
                            icon="user"
                            label="ID Korisnika koji je vlasnik oglasa"
                            type="text"
                            :error="form.errors.user_id"
                            placeholder="Id Korisnika..."
                        />

                    </div>
                    <div class="uk-card-footer uk-margin-remove-top uk-hr uk-text-right">
                        <loading-button class="uk-button-large"
                                        :class="form.processing || ! form.isDirty || ! form.street ? 'uk-disabled uk-button-default' : 'uk-button-danger'"
                                        :disabled="form.processing || ! form.isDirty || ! form.street"
                        >
                            Nastavi
                        </loading-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <hr class="uk-hr uk-margin-remove" />

    <base-footer v-if="store_route === route('listing.store')" />
</template>

<script setup>
    import {useForm} from "@inertiajs/inertia-vue3";
    import LoadingButton from "@/Shared/LoadingButton.vue";
    import {ref, watch} from "vue";
    import BaseFooter from "@/Shared/Footer.vue";
    import { addressAutocomplete, getFromId } from "@/Services/map.js";
    import Notice from "@/Shared/Notice.vue";
    import TextInput from "@/Shared/TextInput.vue";

    let props = defineProps({
        store_route: {
            type: String,
            default: route('listing.store')
        }
    })

    let address = ref('');
    let loading = ref(false);
    let isAutocomplete = ref(false);
    let autocomplete = addressAutocomplete();
    let location = getFromId();

    let form = useForm({
        city: null,
        county: null,
        country: null,
        district: null,
        postal_code: null,
        street: null,
        street_nb: null,
        location_id: null,
        latitude: null,
        longitude: null,
        user_id: null,
    })

    watch(address, (newValue, oldValue) => {
        if( ! isAutocomplete.value) return;
        autocomplete.search(newValue)
    });
    let clear = () => {
        isAutocomplete.value = false;
        address.value = '';
        autocomplete.clearData();
        form.reset();
    }
    let clearErrors = () => {
        form.clearErrors();
    }

    let getLocation = (id) => {
        location.fetch(id);
    }

    watch(() => location.data, function (newValue, oldValue){
        if(newValue.address) {
            clear();
            address.value = newValue.title;


            form.location_id = newValue.id;
            form.city = newValue.address.city || null;
            form.county = newValue.address.county || null;
            form.district = newValue.address.district || null;
            form.postal_code = newValue.address.postalCode || null;
            form.street = newValue.address.street || null;
            form.street_nb = newValue.address.houseNumber || null;
            form.country = newValue.address.countryName || null;
            form.latitude = newValue.position.lat;
            form.longitude = newValue.position.lng;
        }

    }, { deep: true })

    let submit = () => {
        form.post(props.store_route);
    }
</script>

<style scoped>

</style>
