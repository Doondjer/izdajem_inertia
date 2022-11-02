<template>

    <edit
        :percent="1/6*100"
        :l="listing.data"
        step="detalji"
        title="Detalji Nekretnine"
        :proceed="form.nb_floor !== null && form.nb_room && form.type && form.furnish_type && ! form.processing"
        :loading="form.processing"
        :nextText="form.isDirty ? 'Sačuvaj & nastavi' : 'Nastavi'"
        @next="submit"
    >
        <div class="uk-form-controls">
            <label class="uk-text-small uk-text-bold">Koju vrstu objekta izdajete?</label>
            <div class="uk-grid uk-padding-small uk-child-width-1-4 uk-text-center">
                <div>
                    <div class="uk-icon-button icon-button-large uk-icon uk-button-default" @click.prevent="form.type = 'stan'" :class="form.type === 'stan' ? 'uk-button-danger' : 'uk-text-meta'">
                        <img src="/icons/building.svg" alt="Stan" width="30" height="30" uk-svg>
                    </div>
                    <p>Stan</p>
                </div>
                <div>
                    <div class="uk-icon-button icon-button-large uk-icon uk-button-default" @click.prevent="form.type = 'stan-u-kuci'" :class="form.type === 'stan-u-kuci' ? 'uk-button-danger' : 'uk-text-meta'">
                        <img src="/icons/building-house.svg" alt="Stan u kući" width="30" height="30" uk-svg>
                    </div>
                    <p>Stan u kući</p>
                </div>
                <div>
                    <div class="uk-icon-button icon-button-large uk-icon uk-button-default" @click.prevent="form.type = 'kuca'" :class="form.type === 'kuca' ? 'uk-button-danger' : 'uk-text-meta'">
                        <img src="/icons/house.svg" alt="Stan" width="30" height="30" uk-svg>
                    </div>
                    <p>Kuća</p>
                </div>
                <div>
                    <div class="uk-icon-button icon-button-large uk-icon uk-button-default" @click.prevent="form.type = 'poslovni-prostor'" :class="form.type === 'poslovni-prostor' ? 'uk-button-danger' : 'uk-text-meta'">
                        <img src="/icons/business.svg" alt="Stan" width="30" height="30" uk-svg>
                    </div>
                     <p>Poslovni prostor</p>
                </div>
            </div>
            <div class="uk-text-danger uk-text-left" v-if="form.errors.type">{{ form.errors.type }}</div>
        </div>

        <selectbox-input
            class="uk-padding-small"
            label="Koliko je opremljen vaš objekat?"
            :error="form.errors.furnish_type"
            v-model="form.furnish_type"
            icon="namestenost"
        >
            <option :value="null">Izaberite nameštenost objekta...</option>
            <option class="uk-text-capitalize" v-for="(name, slug) in fields.furnish_types" :key="slug" :value="slug">{{ name }}</option>
        </selectbox-input>

        <selectbox-input
            class="uk-padding-small"
            label="Kakva je struktura vašeg objekta?"
            :error="form.errors.nb_room"
            v-model="form.nb_room"
            icon="floor-plan"
        >
            <option :value="null">Izaberite strukturu...</option>
            <option class="uk-text-capitalize" v-for="(name, slug) in fields.structure" :key="slug" :value="slug">{{ name }}</option>
        </selectbox-input>

        <selectbox-input
            class="uk-padding-small"
            label="Na kom se spratu nalazi vaš objekat?"
            :error="form.errors.nb_floor"
            v-model="form.nb_floor"
        >
            <option :value="null">Izaberite sprat...</option>
            <option value="-1">Suteren</option>
            <option :value="i"    v-text="i === 0 ? 'Prizemlje' : i" v-for="(n,i) in 31" :key="i"></option>
        </selectbox-input>

        <selectbox-input
            class="uk-padding-small"
            label="Ukupna Spratnost(opciono)"
            :error="form.errors.total_floor"
            v-model="form.total_floor"
        >
            <option :value="null">Izaberite ukupnu spratnost...</option>
            <option :value="i"    v-text="i === 0 ? 'Prizemlje' : i" v-for="(n,i) in 31" :key="i"></option>
        </selectbox-input>

        <text-input
            class="uk-margin"
            v-model="form.size"
            icon="kvadratura"
            icon_right="square-meter"
            label="Površina objekta(opciono)"
            type="text"
            :error="form.errors.size"
            iconPosition="left"
            placeholder="Površina..."
        />
    </edit>
</template>

<script setup>
import Edit from "@/Pages/Listing/Edit.vue";
import TextInput from "@/Shared/TextInput.vue";
import SelectboxInput from "@/Shared/SelectboxInput.vue";
import {useForm} from "@inertiajs/inertia-vue3";

let props = defineProps({
    fields: Object,
    listing: Object,
})

let form = useForm({
    type: props.listing.data.type || 'stan',
    furnish_type: props.listing.data.furnish_type || null,
    nb_room: props.listing.data.nb_room || null,
    nb_floor: props.listing.data.nb_floor || null,
    total_floor: props.listing.data.total_floor || null,
    size: props.listing.data.size || null,
})

let submit = () => {
    form.patch(route('listing.update', {listing: props.listing.data.slug, step: 'detalji'}), {
        preserveScroll: true
    });}
</script>
