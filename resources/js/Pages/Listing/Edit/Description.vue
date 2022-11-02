<template>
    <edit
        :percent="4/6*100"
        :l="listing.data"
        step="opis"
        title="Opis nekretnine"
        :proceed="form.description.length > 7 && ! form.processing"
        :loading="form.processing"
        :nextText="form.isDirty ? 'Sačuvaj & nastavi' : 'Nastavi'"
        :prevLink="route('listing.edit', {listing: listing.data.slug, step: 'cena'})"
        @next="submit"
    >

        <tip-tap-textarea v-model:content="form.description" :error="form.errors.description" />

        <div v-if="form.description.length < 100">
            <span class="uk-text-danger" uk-icon="warning"></span>
            Opis je suviše kratak. Napišite detalje kao što su bitne karakteristike, udaljenosti do obližnjih lokacija i prevoza, šta se nalazi u okruženju
        </div>
        <div v-else>
            <span class="uk-text-success" uk-icon="check"></span>
            Odlično! Ovo je opis sa dovoljno karaktera!
        </div>
    </edit>
</template>

<script setup>
    import Edit from "@/Pages/Listing/Edit.vue";
    import {useForm} from "@inertiajs/inertia-vue3";
    import TipTapTextarea from "@/Shared/TipTapTextarea.vue";

    let props = defineProps({
        listing: Object,
    })

    let form = useForm({
        description: props.listing.data.description || '',
    })

    let submit = () => {
        form.patch(route('listing.update', {listing: props.listing.data.slug, step: 'opis'}), {
            preserveScroll: true
        });
    }
</script>
