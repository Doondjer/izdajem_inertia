<template>
    <card class="hr-split" bodyClass="uk-card-body uk-padding-remove">

        <template #header>
            <div class="uk-card-header">Filteri</div>
        </template>

        <template #body>
            <div class="uk-modal-close-full right" @click="$emit('close_modal')" ref="closeFilterModal" v-if="isModal">
                <div class="map-close-button-first"></div>
                <div class="map-close-button-second"></div>
            </div>


            <div class="uk-card-header" v-if="isModal">
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
    </card>
</template>

<script setup>
    import SelectboxInput from "@/Shared/SelectboxInput.vue";
    import Card from "@/Shared/Card.vue";
    import Checkbox from "@/Shared/Checkbox.vue";
    import CheckboxesRow from "@/Shared/CheckboxRow.vue";
    import { defineEmits, watch } from "vue";
    import throttle from "lodash/throttle";

    const emit = defineEmits(['close_modal', 'update:modelValue']);

    let props = defineProps(['aggregations', 'isModal', 'per_page', 'modelValue'])

    watch(props.modelValue, (value) => {
        console.log(value);
    })
</script>

<style scoped>

</style>
