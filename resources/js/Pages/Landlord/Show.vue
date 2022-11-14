<template>
    <div class="uk-section uk-section-default">
        <div class="uk-container">
            <div class="uk-grid uk-grid-small uk-grid-divider" uk-grid>
                <div class="uk-width-expand">
                    <div class="uk-grid-collapse uk-flex-middle uk-padding-remove-vertical uk-grid" uk-grid>
                        <a href="#" class="uk-width-auto">
                            <img class="uk-border-circle uk-visible@s" width="120" height="90" :data-src="`${$page.props.config.image_base_route}/small/${landlord.data.profile_image}`" uk-img>
                            <img class="uk-border-circle uk-hidden@s" width="60" height="60" :data-src="`${$page.props.config.image_base_route}/75x75/${landlord.data.profile_image}`" uk-img>
                        </a>
                        <div class="uk-width-expand">
                            <div href="#" class="uk-h3 uk-text-bold uk-margin-remove">{{ landlord.data.fullname }}</div>

                            <p class="uk-text-meta uk-margin-remove-top">
                                Član od {{ landlord.data.since_human }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="uk-width-auto@s uk-width-1-1">
                    <div class="uk-margin-small-top">
                        <a href="#contact_user_form" class="uk-button uk-button-danger uk-width-1-1">Pošalji poruku</a>
                    </div>
                    <div class="uk-margin-small-top">
                        <a :href="`tel:${landlord.data.phone}`" class="uk-button uk-button-default uk-width-1-1">
                            <img src="/icons/phone.svg" alt="tel" uk-svg />
                            <span class="uk-margin-small-left uk-text-middle">Pozovi</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
        <div class="uk-section uk-section-muted">
            <div class="uk-container">
                <div class="uk-grid uk-grid-small" id="details_grid" uk-grid>
                    <div class="uk-width-expand">
                        <div id="ll">
                            <card class="hr-split uk-border-rounded-xl" bodyClass="uk-card-body uk-padding-remove">
                                <template #header>
                                    <div class="uk-card-header">
                                        <h2 class="uk-card-title">{{ landlord.data.fullname}} - Nekretnine</h2>
                                        <p class="uk-text-muted">Nekretnine za izdavanje koje je oglasio {{ landlord.data.fullname }}</p>
                                    </div>
                                </template>
                                <template #body>
                                    <HereMap
                                        class="uk-padding-remove"
                                        :center="{ lat: 44.8125, lng: 20.4612 }"
                                        :markers="locations"
                                        :is_center_marker="false"
                                        ref="addressMap"
                                    />
                                </template>
                            </card>

                            <p v-if="listings.meta.total" class="uk-text-bold">Prikazano {{ listings.meta.from }} - {{ listings.meta.to }} od {{ listings.meta.total }} nekretnina za izdavanje.</p>
                            <p v-else class="uk-text-bold">Korisnik nema oglašenih nekretnina za izdavanje</p>

                            <div class="uk-grid-small uk-grid uk-position-relative l-wrapper l-2-rows" uk-grid="masonry: true">
                                <listing-card v-for="listing in listings.data" :listing="listing" :key="listing.id" />
                            </div>

                            <button v-if="form.per_page === 3 && listings.meta.last_page > 1" class="uk-button uk-button-default uk-button-large uk-margin-top uk-width-1-1" @click.prevent="form.per_page = 10">Učitaj više nekretnina</button>

                            <div v-if="form.per_page !== 3 && listings.meta.last_page > 1" class="uk-card uk-card-default uk-margin uk-border-rounded">
                                <pagination :dataSet="listings.meta" v-model:page="form.page" class="uk-margin-small uk-margin-small-top"></pagination>
                            </div>
                        </div>


                        <div id="contact_user_form" class="uk-border-rounded-xl uk-margin-large-top">

                            <contact-user-form class="uk-width" :user="landlord.data" />

                        </div>
                    </div>

                    <div class="uk-width-xmedium uk-visible@m">
                        <div class="uk-position-z-index" uk-sticky="end: #ll; offset: 80">

                            <card class="hr-split uk-border-rounded-xl">
                                <template #body>

                                    <user-form-row :user="landlord.data" />

                                    <div>
                                        <div>
                                            <a href="#contact_user_form" class="uk-button uk-button-danger uk-width">Pošalji poruku</a>
                                        </div>
                                        <div class="uk-margin-small-top">
                                            <a :href="`tel:${landlord.data.phone}`" class="uk-button uk-button-default uk-width-1-1">
                                                <img src="/icons/phone.svg" alt="tel" uk-svg />
                                                <span class="uk-margin-small-left uk-text-middle">Pozovi</span>
                                            </a>
                                        </div>
                                    </div>
                                </template>
                            </card>
                        </div>
                    </div>
                </div>
            </div>

        </div>
</template>

<script setup>
    import UserFormRow from "@/Shared/UserFormRow.vue";
    import HereMap from "@/Shared/HereMap.vue";
    import ContactUserForm from "@/Shared/ContactUserForm.vue";
    import Card from "@/Shared/Card.vue";
    import ListingCard from "@/Shared/ListingCard.vue";
    import Pagination from "@/Shared/Pagination.vue";
    import {reactive, watch} from "vue";
    import {Inertia} from "@inertiajs/inertia";

    let props = defineProps({
        landlord: Object,
        listings: Object,
        filters: Object,
        locations: Object,
    })

    let form = reactive({
        page: props.filters.page ? props.filters.page : 1,
        per_page: props.filters.per_page ? 10 : 3,
    })

    watch(form, _.throttle(
            (newValue, oldValue) => {
                Inertia.get(route('landlord.show', props.landlord.data.id), newValue, { preserveState: true, preserveScroll: true });
            }, 200)
        ,{deep: true}
    )
</script>

<style scoped>

</style>
