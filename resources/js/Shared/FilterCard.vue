<template>
    <card class="hr-split" bodyClass="uk-card-body uk-padding-remove">

        <template #header>
            <div class="uk-card-header">Filteri</div>
        </template>

        <template #body>
            <div class="uk-modal-close-full right" @click.prevent="$emit('update:isFullFilter')" ref="closeFilterModal" v-if="isFullFilter">
                <div class="map-close-button-first"></div>
                <div class="map-close-button-second"></div>
            </div>


            <div class="uk-card-header" v-if="isFullFilter">
                <label for="per_page_modal_selectbox" class="uk-text-small uk-text-bold">Rezultata po stranici</label>
                <selectbox-input
                    v-model="per_page"
                    @change="$emit('update:per_page', $event.target.value)"
                >
                    <option :value="perpage" v-for="perpage in per_page_list" :key="perpage" v-text="perpage"></option>
                </selectbox-input>
            </div>

            <selectbox-input
                class="uk-padding-small"
                label="Grad:"
                :showLabel="true"
                v-model="city"
                @change="$emit('update:city', $event.target.value)"
            >
                <option value="">Grad...</option>
                <option v-for="city in aggregations.city.buckets" :value="city.key">{{ city.key + (city.doc_count ? ` (${city.doc_count})` : '') }}</option>
            </selectbox-input>

            <selectbox-input
                class="uk-padding-small"
                label="Opština:"
                :showLabel="true"
                v-model="district"
                @change="$emit('update:district', $event.target.value)"
            >
                <option value="">Opština...</option>
                <option v-for="district in aggregations.district.buckets" :value="district.key">{{ district.key + (district.doc_count ? ` (${district.doc_count})` : '') }}</option>
            </selectbox-input>

            <selectbox-input
                class="uk-padding-small"
                label="Okrug"
                :showLabel="true"
                v-model="county"
                @change="$emit('update:county', $event.target.value)"
            >
                <option value="">Okrug...</option>
                <option v-for="county in aggregations.county.buckets" :value="county.key">{{ county.key + (county.doc_count ? ` (${county.doc_count})` : '') }}</option>
            </selectbox-input>

            <checkboxes-row
                v-model="type"
                v-if="aggregations.type.buckets.length"
                :form="form"
                label="Tip"
                :items="aggregations.type.buckets"
                item="type"
            ></checkboxes-row>

            <checkboxes-row
                v-model="structure"
                v-if="aggregations.nb_room.buckets.length"
                :form="form"
                label="Struktura"
                :items="aggregations.nb_room.buckets"
                item="structure"
            ></checkboxes-row>

            <checkboxes-row
                v-model="furnish_type"
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
                v-model:start="price_from"
                v-model:end="price_to"
                @update:start="$emit('update:price_from', $event)"
                @update:end="$emit('update:price_to', $event)"
            />

            <text-input-range
                iconStart="square-meter"
                iconEnd="square-meter"
                label="Površina"
                v-model:start="size_from"
                v-model:end="size_to"
                @update:start="$emit('update:size_from', $event)"
                @update:end="$emit('update:size_to', $event)"
            />

            <div v-if="!$page.props.user || ! $page.props.user.is_admin" class="uk-padding-small">
                <label for="show_rented_container" class="uk-text-small uk-text-bold">Prikaži Izdate</label>
                <ul class="uk-nav">
                    <li>
                        <checkbox v-model:checked="show_rented" @change="$emit('update:show_rented', $event.target.checked)" name="show_rented">Prikaži Izdate</checkbox>
                    </li>
                </ul>
            </div>

            <slot />

            <div class="uk-padding-small">
                <button @click.prevent="$emit('update:isFullFilter')" type="button" class="uk-button uk-button-danger uk-width-1-1">Search</button>
            </div>
        </template>
    </card>
</template>

<script setup>
import SelectboxInput from "@/Shared/SelectboxInput.vue";
import Card from "@/Shared/Card.vue";
import Checkbox from "@/Shared/Checkbox.vue";
import CheckboxesRow from "@/Shared/CheckboxRow.vue";
import TextInputRange from "@/Shared/TextInputRange.vue";

defineProps({
    per_page_list: Array,
    isFullFilter: Boolean,
    aggregations: Object,
    form: Object,
    per_page: [String, Number],
    city: String,
    district: String,
    county: String,
    type: Array,
    structure: Array,
    furnish_type: Array,
    price_from: [String, Number],
    price_to: [String, Number],
    size_from: [String, Number],
    size_to: [String, Number],
    show_rented: Boolean,
})
</script>
