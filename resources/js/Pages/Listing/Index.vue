<template>

    <Head title="Pretraga stanova za izdavanje Beograd, Novi Sad, Srbija"/>

    <div class="uk-container m-container" uk-height-viewport="expand: true">
        <div class="uk-grid uk-grid-small uk-margin-top">
            <div class="uk-display-block"  :class="isFullFilter ? 'uk-modal-full uk-modal uk-open uk-padding-remove' : 'uk-visible@l uk-width-medium uk-first-column'">
                <filter-card
                    class="uk-border-rounded-xl"
                    :form="form"
                    :per_page_list="per_page"
                    v-model:isFullFilter="isFullFilter"
                    :aggregations="aggregations"
                    v-model:per_page="form.per_page"
                    v-model:city="form.city"
                    v-model:district="form.district"
                    v-model:county="form.county"
                    v-model:type="form.type"
                    v-model:structure="form.structure"
                    v-model:furnish_type="form.furnish_type"
                    v-model:price_from="form.price_from"
                    v-model:price_to="form.price_to"
                    v-model:size_from="form.size_from"
                    v-model:size_to="form.size_to"
                    v-model:show_rented="form.show_rented"
                />
<!--                <card class="hr-split" bodyClass="uk-card-body uk-padding-remove">

                    <template #header>
                        <div class="uk-card-header">Filteri</div>
                    </template>

                    <template #body>
                        <div class="uk-modal-close-full right" @click.prevent="isFullFilter = false" ref="closeFilterModal" v-if="isFullFilter">
                            <div class="map-close-button-first"></div>
                            <div class="map-close-button-second"></div>
                        </div>


                        <div class="uk-card-header" v-if="isFullFilter">
                            <label for="per_page_modal_selectbox" class="uk-text-small uk-text-bold">Rezultata po stranici</label>
                            <select name="per_page" id="per_page_modal_selectbox" class="uk-select" v-model="form.per_page">
                                <option :value="perpage" v-for="perpage in per_page" :key="perpage" v-text="perpage"></option>
                            </select>
                        </div>

                        <selectbox-input
                            class="uk-padding-small"
                            label="Grad:"
                            :showLabel="true"
                            v-model="form.city"
                        >
                            <option :value="null">Grad...</option>
                            <option v-for="city in aggregations.city.buckets" :value="city.key">{{ city.key + (city.doc_count ? ` (${city.doc_count})` : '') }}</option>
                        </selectbox-input>

                        <selectbox-input
                            class="uk-padding-small"
                            label="Opština:"
                            :showLabel="true"
                            v-model="form.district"
                        >
                            <option :value="null">Opština...</option>
                            <option v-for="district in aggregations.district.buckets" :value="district.key">{{ district.key + (district.doc_count ? ` (${district.doc_count})` : '') }}</option>
                        </selectbox-input>

                        <selectbox-input
                            class="uk-padding-small"
                            label="Okrug"
                            :showLabel="true"
                            v-model="form.county"
                        >
                            <option :value="null">Okrug...</option>
                            <option v-for="county in aggregations.county.buckets" :value="county.key">{{ county.key + (county.doc_count ? ` (${county.doc_count})` : '') }}</option>
                        </selectbox-input>

                        <checkboxes-row
                            v-model="form.type"
                            v-if="aggregations.type.buckets.length"
                            :form="form"
                            label="Tip"
                            :items="aggregations.type.buckets"
                            item="type"
                        ></checkboxes-row>

                        <checkboxes-row
                            v-model="form.structure"
                            v-if="aggregations.nb_room.buckets.length"
                            :form="form"
                            label="Struktura"
                            :items="aggregations.nb_room.buckets"
                            item="structure"
                        ></checkboxes-row>

                        <checkboxes-row
                            v-model="form.furnish_type"
                            v-if="aggregations.furnish_type.buckets.length"
                            :form="form"
                            label="Nameštenost"
                            :items="aggregations.furnish_type.buckets"
                            item="furnish"
                        ></checkboxes-row>

                        <text-input-range
                            iconStart="euro"
                            iconEnd="euro"
                            label="Cena"
                            v-model:start="form.price_from"
                            v-model:end="form.price_to"
                        />

                        <text-input-range
                            iconStart="square-meter"
                            iconEnd="square-meter"
                            label="Površina"
                            v-model:start="form.size_from"
                            v-model:end="form.size_to"
                        />

                        <div class="uk-padding-small">
                            <label for="show_rented_container" class="uk-text-small uk-text-bold">Prikaži Izdate</label>
                            <ul class="uk-nav">
                                <li>
                                    <checkbox v-model:checked="form.show_rented" name="show_rented">Prikaži Izdate</checkbox>
                                </li>
                            </ul>
                        </div>
                        <div class="uk-padding-small">
                            <button type="button" class="uk-button uk-button-danger uk-width-1-1">Search</button>
                        </div>
                    </template>
                </card>-->
            </div>
            <div class="uk-width-expand uk-margin-large-bottom" uk-scrollspy="target: > .spy; cls: uk-animation-fade; delay: 400">


                <div class="card-container m-border-remove">
                    <div class="uk-card uk-card-default uk-card-small uk-border-rounded-xl">
                        <div class="uk-card-body">
                            <div class="uk-grid uk-grid-small">
                                <label class="uk-inline uk-width-expand" for="top_bar_search">
                                    <a href="#" class="uk-form-icon uk-form-icon-flip uk-text-danger" uk-icon="close" v-if="form.q" @click="form.q = ''"></a>
                                    <a href="#" class="uk-form-icon uk-form-icon-flip" uk-icon="search" aria-label="Pretraži..." v-else></a>
                                    <input class="uk-input modified-input" type="search" id="top_bar_search" placeholder="Pretraži..." v-model="form.q">
                                </label>
                                <div class="uk-width-auto">
                                    <select name="per_page" class="uk-select uk-visible@l" v-model="form.per_page">
                                        <option :value="perpage" v-for="perpage in per_page" :key="perpage" v-text="perpage"></option>
                                    </select>
                                    <button class="uk-button uk-button-default uk-button-small icon-button uk-border-rounded uk-hidden@l" aria-label="Filteri" @click="isFullFilter = true">
                                        <img src="/icons/filter.svg" alt="filter" uk-svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h1 class="uk-h5 uk-margin-remove">Pronađite stan ili kuću za izdavanje</h1>
                <h2 class="uk-width-expand uk-h4 uk-margin-top uk-text-center" v-if="Object.keys(listings.data).length">{{ foundText}}</h2>
                <div class="uk-grid-small uk-position-relative m-border-remove uk-grid l-wrapper l-2-wrapper" v-if="Object.keys(listings.data).length" uk-grid="masonry: true">
                    <listing-card class="spy" :listing="listing" v-for="listing in listings.data" :key="listing.id"/>
                </div>
                <div v-else class="uk-text-center uk-margin-large-top">
                    <p class="uk-h4 uk-text-bold">Nema rezultata za ovu pretragu!</p>
                </div>

                <div v-if="listings.last_page > 1" class="uk-card uk-card-default uk-margin uk-margin-large-bottom uk-border-rounded m-border-remove uk-border-rounded-xl spy">

                    <pagination :dataSet="listings" v-model:page="form.page" class="uk-margin-small uk-margin-small-top"></pagination>

                </div>

            </div>

        </div>

<!--        <side-button v-if=" ! isFullFilter"></side-button>-->
    </div>

    <base-footer />
</template>

<script setup>
    import SelectboxInput from "@/Shared/SelectboxInput.vue";
    import Card from "@/Shared/Card.vue";
    import Checkbox from "@/Shared/Checkbox.vue";
    import CheckboxesRow from "@/Shared/CheckboxRow.vue";
    import TextInputRange from "@/Shared/TextInputRange.vue";
    import ListingCard from "@/Shared/ListingCard.vue";
    import Pagination from "@/Shared/Pagination.vue";
    import BaseFooter from "@/Shared/Footer.vue";
    import { ref, watch, reactive, computed } from "vue";
    import { Inertia } from '@inertiajs/inertia';
    import FilterCard from "@/Shared/FilterCard.vue";

    let props = defineProps({
        aggregations: Object,
        listings: Object,
        filters: Object,
    });

    let per_page = [5,10,20,50];
    let isFullFilter = ref(false);
    let form = reactive({
        q: props.filters.q || null,
        city: props.filters.city || '',
        district: props.filters.district || '',
        county: props.filters.county || '',
        price_from: props.filters.price_from || null,
        price_to: props.filters.price_to || null,
        size_from: props.filters.size_from || null,
        size_to: props.filters.size_to || null,
        user: null,
        show_rented: props.filters.show_rented === 'true',
        page: props.filters.page || 1,
        per_page: props.filters.per_page || 10,
        furnish: props.filters.furnish || [],
        renovation: props.filters.renovation || [],
        structure: props.filters.structure || [],
        type: props.filters.type || [],
    })

    watch(form, _.throttle(
        (newValue, oldValue) => {
            Inertia.get(route('listing.index'), newValue, { preserveState: true });
        }, 200)
        ,{deep: true}
    )
    let foundText = computed(() => {
        if(props.listings.total === 1) {
            return `Pronadjen ${props.listings.total} objekat za izdavanje`;
        }
        if(1 < props.listings.total < 5) {
            return `Pronadjeno ${props.listings.total} objekta za izdavanje`;
        }
        if(props.listings.total > 5) {
            return `Pronadjeno ${props.listings.total} objekata za izdavanje`;
        }

        return 'Nisu pronadjeni objekti za zadatu pretragu.';
    })


</script>

<style scoped>

</style>
