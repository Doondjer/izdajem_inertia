<template>
    <div class="filter-container uk-display-block" :class="isFilterModal ? 'uk-modal-full uk-modal uk-open uk-padding-remove' : 'uk-visible@l'">
        <div class="uk-card uk-card-default uk-card-small">

            <div class="uk-card-header" v-text="__('base.Filteri')"></div>

<!--            <div class="uk-modal-close-full right" @click="$emit('close_modal')" ref="closeFilterModal" v-if="isFilterModal">
                <div class="map-close-button-first"></div>
                <div class="map-close-button-second"></div>
            </div>


            <div class="uk-card-header" v-if="isFilterModal">
                <label for="per_page_modal_selectbox" class="uk-text-small uk-text-bold" v-text="`${translation.Rezultata_po_stranici}:`"></label>
                <select name="per_page" id="per_page_modal_selectbox" class="uk-select" v-model="form.per_page" @change="$emit('make_search')">
                    <option :value="perpage" v-for="perpage in per_page" :key="perpage" v-text="perpage"></option>
                </select>
            </div>


            <selectbox-row
                v-if="aggregations && aggregations.city && aggregations.city.buckets.length"
                :form="form"
                :label="translation.Grad"
                :placeholder="translation.Grad___"
                :items="aggregations.city.buckets"
                :item="'city'"
            ></selectbox-row>

            <selectbox-row
                v-if="aggregations && aggregations.district && aggregations.district.buckets.length"
                :form="form"
                :label="translation.Opstina"
                :placeholder="translation.Opstina___"
                :items="aggregations.district.buckets"
                :item="'district'"
            ></selectbox-row>

            <selectbox-row
                v-if="aggregations && aggregations.county && aggregations.county.buckets.length"
                :form="form"
                :label="translation.Okrug"
                :placeholder="translation.Okrug___"
                :items="aggregations.county.buckets"
                :item="'county'"
            ></selectbox-row>-->

            <checkboxes-row
                v-if="aggregations && aggregations.type && aggregations.type.buckets.length"
                :form="form"
                label="translation.Tip"
                :items="aggregations.type.buckets"
                :item="'type'"
            ></checkboxes-row>

            <checkboxes-row
                v-if="aggregations && aggregations.nb_room && aggregations.nb_room.buckets.length"
                :form="form"
                label="translation.Struktura"
                :items="aggregations.nb_room.buckets"
                :item="'structure'"
            ></checkboxes-row>

            <checkboxes-row
                v-if="aggregations && aggregations.furnish_type && aggregations.furnish_type.buckets.length"
                :form="form"
                label="translation.Namestenost"
                :items="aggregations.furnish_type.buckets"
                :item="'furnish'"
            ></checkboxes-row>
<!--
            <inputFromToRow
                :form="form"
                :label="__('base.Cena')"
                :from="'price_from'"
                :to="'price_to'"
                :placeholder_from="translation.Od___"
                :placeholder_to="translation.Do___"
                :from_icon="'euro'"
                :to_icon="'euro'"
            ></inputFromToRow>

            <inputFromToRow
                :form="form"
                :label="__('base.Povrsina')"
                :from="'size_from'"
                :to="'size_to'"
                :placeholder_from="translation.Od___"
                :placeholder_to="translation.Do___"
                :from_icon="'square-meter'"
                :to_icon="'square-meter'"
            ></inputFromToRow>

            <div class="uk-card-header">
                <label :for="`show_rented_container`" class="uk-text-small uk-text-bold" v-text="`${translation.Prikazi_Izdate}`"></label>
                <ul class="uk-nav" :id="`show_rented_container`">
                    <input type="checkbox"
                           class="uk-checkbox uk-margin-small-right"
                           name="show_rented"
                           v-model="form.show_rented"
                           :id="`show_rented_checkbox`"
                           @change="$emit('make_search')"
                    >
                    <label :for="`show_rented_checkbox`" v-text="`${translation.Prikazi_Izdate}`"></label>
                </ul>
            </div>-->

            <div class="uk-card-header">
                <button type="button" class="uk-button uk-button-danger uk-width-1-1" @click.prevent="$emit('make_search')">Search</button>
            </div>
        </div>
    </div>
</template>

<script>
import CheckboxesRow from "@/Shared/CheckboxRow.vue";
export default {

    props: ['form', 'aggregations', 'isFilterModal', 'per_page'],
    components: {
        CheckboxesRow,
    }
}
</script>
