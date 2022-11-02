<template>
    <div class="uk-card uk-card-default uk-card-small uk-border-rounded-xl">
        <div class="uk-card-body">
            <div class="uk-grid uk-grid-small">
                <label class="uk-inline uk-width-expand" for="top_bar_search">
                    <a href="#" class="uk-form-icon uk-form-icon-flip uk-text-danger" uk-icon="close" v-if="q" @click="$emit('update:q', '')"></a>
                    <a href="#" class="uk-form-icon uk-form-icon-flip" uk-icon="search" aria-label="Pretraži..." v-else></a>

                    <input class="uk-input modified-input"
                           type="search"
                           id="top_bar_search"
                           placeholder="Pretraži..."
                           v-model="q"
                           @keyup.enter="$emit('update:q', $event.target.value)"
                           @blur="$emit('update:q', $event.target.value)"
                    >

                </label>
                <div class="uk-width-auto">

                    <selectbox-input
                        class="uk-visible@xl"
                        v-model="per_page"
                        @change="$emit('update:per_page', $event.target.value)"
                        :large="false"
                    >
                        <option :value="perpage" v-for="perpage in per_page_list" :key="perpage" v-text="perpage"></option>
                    </selectbox-input>
                    <button class="uk-button uk-button-default uk-button-small icon-button uk-border-rounded uk-hidden@xl" aria-label="Filteri" @click.prevent="$emit('update:isFullFilter', true)">
                        <img src="/icons/filter.svg" alt="filter" uk-svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="uk-card-footer uk-visible@l">
            <div class="uk-grid">
                <div class="uk-width-large">Detalji Oglasa</div>
                <div class="uk-width-expand uk-margin-left">
                    <div class="uk-grid uk-grid uk-child-width-1-4">
                        <div>Status</div>
                        <div>Pregleda</div>
                        <div>Prati</div>
                        <div>Poruka</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup>
    import SelectboxInput from "@/Shared/SelectboxInput.vue";

    defineProps({
        per_page_list: Array,
        per_page: [String, Number],
        isFullFilter: Boolean,
        q: Object,
    })
</script>
