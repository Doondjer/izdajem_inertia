<template>

    <edit
        :percent="3/6*100"
        :l="listing.data"
        step="cena"
        title="Dostupnost & Cena"
        :proceed="!!form.price && !!form.available_from && ! form.processing"
        :loading="form.processing"
        :prevLink="route('listing.edit', {listing: listing.data.slug, step: 'opremljenost'})"
        :nextText="form.isDirty ? 'Sačuvaj & nastavi' : 'Nastavi'"
        @next="submit"
    >
        <div class="uk-margin-small-bottom">
            <div class="uk-text-muted uk-form-label">Useljivo_od</div>
                <div class="uk-form-controls">
                    <DatePicker v-model="form.available_from"
                                :timezone="timezone"
                                :model-config="modelConfig"
                                class="uk-inline uk-width-1-1"
                                :class="{'form-input-danger': form.errors.available_from}"
                                @input="form.clearErrors('available_from')"
                    >
                        <template v-slot="{ inputValue, inputEvents }" class="uk-inline">
                            <div class="uk-form-icon">
                               <img src="/icons/calendar.svg" uk-svg>
                            </div>

                            <button class="uk-form-icon uk-form-icon-flip"
                                    :class="form.available_from ? 'uk-text-danger' : 'uk-hidden'"
                                    type="button" uk-icon="icon: close"
                                    :disabled="!form.available_from"
                                    title="ocisti"
                                    @click="form.available_from =''"
                            ></button>
                            <input
                                id="date_modal"
                                class="uk-input modified-input uk-form-large"
                                :class="{ 'form-input-danger': form.errors.available_from }"
                                placeholder="DD-MM-GGGG"
                                :value="inputValue"
                                v-on="inputEvents"
                            />
                        </template>
                    </DatePicker>
                    <span class="uk-text-danger uk-text-left" v-text="form.errors.available_from" v-if="form.errors.available_from"></span>
                </div>
            </div>
            <text-input
                class="uk-margin"
                v-model="form.price"
                icon="eur"
                label="Cena(mesečno)"
                type="text"
                :error="form.errors.price"
                placeholder="Cena..."
            />
            <text-input
                class="uk-margin"
                v-model="form.deposit"
                icon="eur"
                label="Depozit(opciono)"
                help="Ovo je novac koji stanar daje stanodavcu pre nego što se useli u njega. Služi da bi se naknadila eventualna šteta, ili naplatila neplaćena stanarina... U slučaju da je sve uredu i nema naknadnih troškova ovaj novac je potrebno vratiti stanarima."
                type="text"
                :error="form.errors.deposit"
                placeholder="Depozit..."
            />
    </edit>
</template>

<script setup>
    import Edit from "@/Pages/Listing/Edit.vue";
    import {useForm} from "@inertiajs/inertia-vue3";
    import { DatePicker } from 'v-calendar';
    import 'v-calendar/dist/style.css';
    import TextInput from "@/Shared/TextInput.vue";
    import {computed} from "vue";

    let props = defineProps({
        listing: Object,
    })
    const modelConfig = {
            type: 'string',// Uses 'iso' if missing
            mask: 'YYYY-MM-DD', // Uses 'iso' if missing

        };
    const timezone = 'Europe/Brussels';

    let l = computed(() => {
        return props.listing.data;
    })

    let form = useForm({
        available_from: props.listing.data.available_from || new Date(),
        price: props.listing.data.price || null,
        deposit: props.listing.data.deposit || null,
    })

    let submit = () => {
        form.patch(route('listing.update', {listing: props.listing.data.slug, step: 'cena'}), {
            preserveScroll: true
        });
    }
</script>
