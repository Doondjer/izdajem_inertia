<template>
    <edit
        :percent="2/6*100"
        :l="listing.data"
        step="opremljenost"
        title="Opremljenost Nekretnine(opciono)"
        :proceed="! form.processing"
        :loading="form.processing"
        :nextText="form.isDirty ? 'Sačuvaj & nastavi'  : (form.amenities.length || form.securities.length ? 'Nastavi' : 'Preskoči')"
        :prevLink="route('listing.edit', {listing: listing.data.slug, step: 'detalji'})"
        @next="submit"
    >
        <p class="uk-text-bold">Olakšajte pronalaženje tako što ćete odabrati sve opcije koje vaša nekretnina poseduje</p>
        <div class="uk-grid uk-child-width-1-2 uk-child-width-1-3@m">
            <div class="uk-margin-small-bottom uk-text-weight-500" v-for="(amenity, index) in amenities.data" :key="amenity.name">
                <img :src="`/icons/${amenity.icon}.svg`" class="uk-icon uk-margin-small-right" :class=" form.amenities.includes(amenity.name) ? 'uk-text-danger' : 'text-disabled'" uk-svg>
                <checkbox v-model:checked="form.amenities" :value="amenity.name" name="about[]">{{ amenity.name }}</checkbox>
                <div class="uk-text-danger uk-text-left" v-if="form.errors[`amenities.${index}`]">{{ form.errors[`amenities.${index}`] }}</div>
            </div>
        </div>


        <hr class="uk-hr">

        <div class="uk-grid uk-child-width-1-2 uk-child-width-1-3@m">
            <div class="uk-margin-small-bottom uk-text-weight-500" v-for="(security, index) in securities.data" :key="security.name">
                <img :src="`/icons/${security.icon}.svg`" class="uk-icon uk-margin-small-right" :class=" form.securities.includes(security.name) ? 'uk-text-danger' : 'text-disabled'" uk-svg>
                <checkbox v-model:checked="form.securities" :value="security.name" name="about[]">{{ security.name }}</checkbox>
            </div>
        </div>

        <p>U spisku ne postoji stavka koja bitno ističe vašu nekretninu? Možete je navesti u koraku "Opis Nekretnine"</p>
    </edit>
</template>

<script setup>
    import Edit from "@/Pages/Listing/Edit.vue";
    import {useForm} from "@inertiajs/inertia-vue3";
    import Checkbox from "@/Shared/Checkbox.vue";

    let props = defineProps({
        listing: Object,
        amenities: Object,
        securities: Object,
    })

    let form = useForm({
        amenities: props.listing.data.amenities.map(amenity => amenity.name) || [],
        securities: props.listing.data.securities.map(security => security.name) || [],
    })

    let submit = () => {
        form.patch(route('listing.update', {listing: props.listing.data.slug, step: 'opremljenost'}), {
            preserveScroll: true
        });
    }
</script>
