<template>

    <Head title="Moje nekretnine" />

    <div class="uk-section uk-section-small" uk-height-viewport="expand: true">
        <div class="uk-container">
            <div class="uk-grid uk-grid-collapse">
                <h1 class="uk-h2 uk-width-expand">Vaši Oglasi</h1>
                <div class="uk-width-auto">
                    <Link :href="route('listing.create')" class="uk-button uk-button-danger">Kreiraj Novi</Link>
                </div>
            </div>
        </div>

        <div class="uk-container uk-margin">

                <search-card
                    :per_page_list="per_page"
                    v-model:isFullFilter="isFullFilter"
                    v-model:per_page="form.per_page"
                    v-model:q="form.q"
                />

                <p v-if="listings.total" class="uk-text-bold">Prikazano {{ listings.from }} - {{ listings.to }} od {{ listings.total }}</p>
<!--            <div class="uk-card uk-card-default uk-card-small uk-border-rounded-xl">
                <div class="uk-card-body">
                    <div class="uk-grid uk-grid-small">
                        <label class="uk-inline uk-width-expand" for="top_bar_search">
                            <a href="#" class="uk-form-icon uk-form-icon-flip uk-text-danger" uk-icon="close" v-if="form.q" @click="form.q = ''"></a>
                            <a href="#" class="uk-form-icon uk-form-icon-flip" uk-icon="search" aria-label="Pretraži..." v-else></a>
                            <input class="uk-input modified-input" type="search" id="top_bar_search" placeholder="Pretraži..." v-model="form.q">
                        </label>
                        <div class="uk-width-auto">
                            <select name="per_page" class="uk-select" v-model="form.per_page">
                                <option :value="perpage" v-for="perpage in per_page" :key="perpage" v-text="perpage"></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="uk-card-footer uk-grid uk-visible@m">
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
            </div>-->
        </div>
        <div class="uk-container">

            <listing-wide-card v-if="Object.keys(listings.data).length" :listings="listings.data" brakepoint="m" />
<!--            <div class="uk-card uk-margin-small uk-card-default uk-card-small uk-border-rounded-xl" v-if="Object.keys(listings.data).length" v-for="listing in listings.data" :key="listing.slug">

                <div class="uk-card uk-grid-collapse uk-grid" uk-grid>
                    <div class="uk-card-media-left uk-width-auto uk-cover-container">
                        <picture>
                            <source class="uk-width" :srcset="`${$page.props.config.image_base_route}/370/${listing.image_webp}`" type="image/webp" v-if="listing.image_webp">
                            <source class="uk-width" :srcset="`${$page.props.config.image_base_route}/370/${listing.image}`" type="image/jpeg">
                            <img :src="`${$page.props.config.image_base_route}/370/${listing.image}`" :alt="`real_estate_image_${listing.slug}`" uk-cover class="uk-width" width="140" height="120">
                        </picture>
                        <canvas width="140" height="120"></canvas>
                    </div>
                    <div class="uk-width-expand">
                        <div class="uk-card-body">
                            <div class="uk-grid">
                                <div class="uk-width-medium">
                                    <Link :href="route('listing.show', listing.slug)" class="uk-button-link"><h3 class="uk-h4 uk-text-bold uk-margin-remove-bottom">{{ listing.street }}</h3></Link>
                                    <div class="uk-text-meta">{{ listing.district }}</div>
                                    <div class="uk-text-meta">{{ listing.city }}</div>

                                    <div class="uk-hidden@m">
                                        <span><img src="/icons/eye.svg" uk-svg> <span class="uk-text-middle">{{ listing.nb_views }}</span></span>
                                        <span><img src="/icons/star-outline.svg" uk-svg> <span class="uk-text-middle">{{ listing.nb_bookmarks }}</span></span>
                                        <span><img src="/icons/mail.svg" uk-svg> <span class="uk-text-middle">{{ listing.nb_messages }}</span></span>
                                    </div>
                                </div>
                                <div class="uk-grid uk-child-width-1-4 uk-width-expand uk-visible@m">
                                    <div><span class="uk-label uk-border-rounded uk-text-capitalize" :class="{'uk-label-danger': listing.status === 'rented', 'uk-label-success': listing.status === 'published'}">{{ listing.status_human }}</span></div>
                                    <div><img class="uk-margin-small-right" src="/icons/eye.svg" uk-svg> <span class="uk-text-middle">{{ listing.nb_views }}</span></div>
                                    <div><img class="uk-margin-small-right" src="/icons/star-outline.svg" uk-svg> <span class="uk-text-middle">{{ listing.nb_bookmarks }}</span></div>
                                    <div><img class="uk-margin-small-right" src="/icons/mail.svg" uk-svg> <span class="uk-text-middle">{{ listing.nb_messages }}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-card-footer uk-grid uk-grid-collapse" uk-grid>
                    <div class="uk-text-meta uk-width-expand"><span class="uk-text-bold uk-visible@m">#{{ listing.id }}</span>
                        <Link class="uk-margin-small-left uk-text-meta uk-visible@m" :href="route('listing.show', listing.slug)">{{ listing.slug }}</Link>
                        <div class="uk-hidden@m">
                            <span class="uk-label uk-border-rounded uk-text-capitalize" :class="{'uk-label-danger': listing.status === 'rented', 'uk-label-success': listing.status === 'published'}">{{ listing.status_human }}</span>
                        </div>
                    </div>
                    <div class="uk-width-auto">
                        <button as="button" method="PATCH" @click.prevent="confirmRent(listing.slug)" v-if="listing.status === 'published'" title="Promeni status oglasa u Izdato!" class="uk-button uk-button-link uk-text-danger uk-button-link uk-margin-small-right" :href="route('listing.rent', listing.slug)">
                            <img class="uk-icon-button uk-button-default icon-button-small uk-text-danger uk-hidden@s" src="/icons/house-keys.svg" width="15" height="15" alt="keys" uk-svg>
                            <img class="uk-margin-small-right uk-visible@s" src="/icons/house-keys.svg" alt="keys" uk-svg>
                            <span class="uk-text-middle uk-text-capitalize uk-visible@s">Označi kao Izdato</span>
                        </button>
                        <Link title="Izmeni detalje oglasa" :href="route('listing.edit', listing.slug)">
                            <img class="uk-icon-button uk-button-default icon-button-small uk-hidden@s uk-text-danger" src="/icons/pencil.svg" width="15" height="15" alt="icon_pencil" uk-svg>
                            <img class="uk-margin-small-right uk-visible@s" src="/icons/pencil.svg" alt="icon_pencil" uk-svg>
                            <span class="uk-text-middle uk-visible@s">Izmeni</span>
                        </Link>
                    </div>
                </div>
                <div class="uk-card-footer uk-hidden@m">
                    <div class="uk-text-meta uk-text-center"><span class="uk-text-bold">#{{ listing.id }}</span>
                        <Link class="uk-margin-small-left uk-text-meta" :href="route('listing.show', listing.slug)">{{ listing.slug }}</Link>
                    </div>
                </div>
            </div>-->
            <div v-else class="uk-text-center">
                <p class="uk-h4 uk-text-bold">Nema rezultata za zadatu pretragu</p>
            </div>
        </div>
        <div class="uk-container uk-margin-small-top" v-if="listings.last_page > 1">
            <div class="uk-card uk-card-default uk-margin uk-margin-large-bottom uk-border-rounded-xl">

                <pagination :dataSet="listings" v-model:page="form.page" class="uk-margin-small uk-margin-small-top"></pagination>

            </div>
        </div>
        <confirmation-modal
            show v-if="confirm.slug && confirm.title"
            @close="clearRent"
            @canceled="clearRent"
            @confirmed="doRent"
        >
            {{ confirm.title }}
        </confirmation-modal>
    </div>
    <base-footer />
</template>

<script setup>
    import {reactive, watch} from "vue";
    import Pagination from "@/Shared/Pagination.vue";
    import BaseFooter from "@/Shared/Footer.vue";
    import ConfirmationModal from "@/Shared/ConfirmationModal.vue";
    import {Inertia} from "@inertiajs/inertia";
    import ListingWideCard from "@/Shared/ListingWideCard.vue";
    import SearchCard from "@/Shared/SearchCard.vue";

    let props = defineProps({
        listings: Object,
        filters: Object,
    })

    let per_page = [5,10,20,50];

    const initialConfirm = {
        slug: null,
        title: null
    };

    let confirm = reactive({ ...initialConfirm});

    let form = reactive({
        q: props.filters.q ? props.filters.q : null,
        page: props.filters.page ? props.filters.page : 1,
        per_page: props.filters.per_page ? props.filters.per_page : 10,
    });

    let confirmRent = (slug) => {
        Object.assign(confirm, {
            slug: slug,
            title: 'Da li ste sigurni da želite da označite nekretninu kao Izdatu?'
        });
    }

    let clearRent = () => {
        Object.assign(confirm, initialConfirm);
    }

    let doRent = () => {
        Inertia.patch(route('listing.rent', confirm.slug));
        clearRent();
    }

    watch(form, _.throttle(
            (newValue, oldValue) => {
                Inertia.get(route('user-listing.index'), newValue, { preserveState: true });
            }, 200)
        ,{deep: true}
    )
</script>
