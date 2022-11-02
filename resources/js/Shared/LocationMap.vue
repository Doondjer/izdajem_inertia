<template>

    <div class="uk-card-default uk-card-small">

        <div class="uk-modal uk-open map-modal">

            <HereMap
                :searchDistance="searchDistance"
                :center="{ lat: l.latitude, lng: l.longitude }"
                :isAutocomplete="isAutocomplete"
                :destLocation="destLocation"
                @autocomplete="updateAutocomplete"
                :distance="distance.data"
                @update:distance="updateDistance"
                v-model:processing="processing"
                ref="addressMap"
            />

            <div class="map-close-container">
                <div class="map-close-container-overlay"></div>
                <div class="uk-modal-close-full" ref="closeModal" @click.prevent="$emit('close_map')">
                    <div class="map-close-button-first"></div>
                    <div class="map-close-button-second"></div>
                </div>
            </div>
            <div class="map-input-container uk-width-1-1">
                <div class="uk-card" :class="{'uk-card-default': distance.data.length}">
                     <span class="uk-inline uk-width-1-1" v-if="distance.data.length">
                         <span class="uk-form-icon uk-icon">
                             <img src="/icons/map-distance.svg" alt="udaljenost" uk-svg>
                         </span>
                         <span class="uk-input modified-input uk-text-truncate">{{ `${l.street}, ${l.district}, ${l.city}` }}</span>
                     </span>
                    <span class="uk-inline uk-width-1-1">
                        <span v-if="processing" class="uk-form-icon uk-text-danger" uk-spinner></span>
                        <span v-else uk-icon="search" class="uk-form-icon uk-icon"></span>
                        <button type="button" uk-icon="icon: close" v-if="searchDistance.length" title="Očisti" class="uk-form-icon uk-form-icon-flip uk-text-danger" @click.prevent="clearAutocomplete"></button>

                        <input type="text"
                              placeholder="Udaljenost Od..."
                              class="uk-input"
                              :class="{'uk-form-danger': processing}"
                              v-model="searchDistance"
                              @focus="isAutocomplete = true"
                              @blur="isAutocomplete = false"
                        >

                    </span>
                    <div class="uk-padding-small" v-if="distance.data.length">
                        <a href="#"
                           @click.prevent="changeMode('car')"
                           :class="routeMode === 'car' ? 'uk-border-pill flat-button uk-button uk-button-small uk-disabled uk-button-danger-outline uk-text-lowercase' : 'uk-icon uk-icon-button uk-button-default uk-margin-left'"
                        >
                            <img src="/icons/car.svg" alt="automobil" uk-svg>
                            <span class="uk-text-middle" v-if="routeMode === 'car' && ! processing">{{ `${Math.floor(distance.data.duration / 60)  +' min '+ (distance.data.duration % 60)  + ' sec'} ( ${distance.data.length < 1000 ? distance.data.length+'m' : distance.data.length / 1000 + 'km'})` }}</span>
                        </a>

                        <a href="#"
                           @click.prevent="changeMode('pedestrian')"
                           class=" uk-margin-left"
                           :class="routeMode === 'pedestrian' ? 'uk-border-pill flat-button uk-button uk-button-small uk-disabled uk-button-danger-outline uk-text-lowercase' : 'uk-icon uk-button-default uk-icon-button'"
                        >
                            <img src="/icons/walk.svg" alt="pesak" uk-svg>
                            <span class="uk-text-middle" v-if="routeMode === 'pedestrian' && ! processing">{{ `${Math.floor(distance.data.duration / 60)  +' min '+ (distance.data.duration % 60)  + ' sec'} ( ${distance.data.length < 1000 ? distance.data.length+'m' : distance.data.length / 1000 + 'km'})` }}</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="map-search-results uk-width-1-1" v-if="autocomplete.length">
                <div class="modern-dropdown uk-dropdown uk-open uk-dropdown-search uk-width-1-1">
                    <ul class="uk-nav uk-nav-search">
                        <li v-for="(search,id) in autocomplete" :key="id">
                            <a class="uk-text-italic" href="#" @click.prevent="calculateRoute(search)" v-if="search.position">
                                <span class="uk-icon">
                                   <img src="/icons/location.svg" alt="lokacija" uk-svg>
                                </span>

                                <div class="uk-display-inline-block">
                                    <div class="ts" v-html="search.highlightedTitle"></div>
                                    <span class="uk-text-meta" v-if="search.vicinity" v-html="search.vicinity.replace('<br/>', ', ')"></span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import HereMap from "@/Shared/HereMap.vue";
    import {reactive, ref, watch} from "vue";

    defineProps({
        l: Object
    })
    let autocomplete = reactive([]);
    let destLocation = reactive([]);
    let searchDistance = ref('');
    let processing = ref(false);
    let isAutocomplete = ref(true);
    let distance = reactive({data: {}});
    let routeMode = ref('car');

    let updateAutocomplete = (values) => {
        Object.assign(autocomplete, values);
    }
    let calculateRoute = (value) => {
        if (value.position) {
            value.position.push(routeMode.value);
            Object.assign(destLocation, value.position);
            autocomplete.splice(0, autocomplete.length);
            searchDistance.value = value.title;
        }

    }
    let clearAutocomplete = () => {
        searchDistance.value = '';
     //   destLocation.splice(0,destLocation.length);
        Object.assign(distance, {data: {}});
    }

    let updateDistance = (data) => {
        Object.assign(distance.data, data);
    }
    let changeMode = (value) => {
        if(! destLocation.length) return;
        destLocation[2] = routeMode.value = value;
    }
</script>

<style scoped>

</style>
