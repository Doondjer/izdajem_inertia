<template>

    <Head title="Lista Oglasa" />

    <div class="uk-section uk-section-small" uk-height-viewport="expand: true">
        <div class="uk-container">
            <div class="uk-grid uk-grid-collapse">
                <h1 class="uk-h2 uk-width-expand">Lista Oglasa</h1>
                <div class="uk-width-auto">
                    <Link :href="route('admin.listing.create')" class="uk-button uk-button-danger">Kreiraj Novi</Link>
                </div>
            </div>
        </div>
        <div class="uk-grid uk-grid-small uk-padding" uk-grid>
            <div class="uk-display-block"  :class="isFullFilter ? 'uk-modal-full uk-modal uk-open uk-padding-remove' : 'uk-visible@xl uk-width-medium uk-first-column'">

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
                >
                    <text-input
                        placeholder="Id Korisnika..."
                        label="Id Korisnika"
                        icon="user"
                        v-model="form.user"
                        inputClass="uk-input"
                    ></text-input>

                    <selectbox-input
                        class="uk-padding-small"
                        label="Stanje Oglasa"
                        :showLabel="true"
                        v-model="form.trashed"
                    >
                        <option value="">Neobrisani Oglasi...</option>
                        <option value="with">Sa Obrisanim</option>
                        <option value="only">Samo Obrisani</option>
                    </selectbox-input>

                    <selectbox-input
                        class="uk-padding-small"
                        label="Status"
                        :showLabel="true"
                        v-model="form.status"
                    >
                        <option value="">Status...</option>
                        <option v-for="(text, status) in aggregations.statuses" :value="status">{{ text }}</option>
                    </selectbox-input>
                </filter-card>

            </div>
            <div class="uk-width-expand">
                <div class="uk-margin">

                    <search-card
                        :per_page_list="per_page"
                        v-model:isFullFilter="isFullFilter"
                        v-model:per_page="form.per_page"
                        v-model:q="form.q"
                   />

                    <p v-if="listings.total" class="uk-text-bold">Prikazano {{ listings.from }} - {{ listings.to }} od {{ listings.total }}</p>

                </div>


                <listing-wide-card v-if="Object.keys(listings.data).length" :listings="listings.data" brakepoint="l" />


                <div v-else class="uk-text-center">
                    <p class="uk-h4 uk-text-bold">Nema rezultata za zadatu pretragu</p>
                </div>

                <div class="uk-margin-small-top" v-if="listings.last_page > 1">
                    <div class="uk-card uk-card-default uk-margin uk-margin-large-bottom uk-border-rounded-xl">

                        <pagination :dataSet="listings" v-model:page="form.page" class="uk-margin-small uk-margin-small-top"></pagination>

                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AppLayout.vue";
export default {
    layout: AdminLayout
}
</script>

<script setup>
    import {reactive, ref, watch} from "vue";
    import Pagination from "@/Shared/Pagination.vue";
    import FilterCard from "@/Shared/FilterCard.vue";
    import SearchCard from "@/Shared/SearchCard.vue";
    import {Inertia} from "@inertiajs/inertia";
    import SelectboxInput from "@/Shared/SelectboxInput.vue";
    import TextInput from "@/Shared/TextInput.vue";
    import ListingWideCard from "@/Shared/ListingWideCard.vue";

    let props = defineProps({
        listings: Object,
        filters: Object,
        aggregations: Object,
    })

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
        user: props.filters.user || null,
        trashed: props.filters.trashed || '',
        show_rented: props.filters.show_rented,
        page: props.filters.page || 1,
        per_page: props.filters.per_page || 10,
        furnish: props.filters.furnish || [],
        renovation: props.filters.renovation || [],
        structure: props.filters.structure || [],
        type: props.filters.type || [],
        status: props.filters.status || '',
    });

    watch(form, _.throttle(
            (newValue, oldValue) => {
                Inertia.get(route('admin.listing.index'), newValue, { preserveState: true });
            }, 200)
        ,{deep: true}
    )
</script>
