<template>
    <div class="uk-card uk-margin-small uk-card-default uk-card-small uk-border-rounded-xl" v-for="listing in listings" :key="listing.slug">

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

                            <div :class="`uk-hidden@${brakepoint}`">
                                <span><img src="/icons/eye.svg" uk-svg> <span class="uk-text-middle">{{ listing.nb_views }}</span></span>
                                <span><img src="/icons/star-outline.svg" uk-svg> <span class="uk-text-middle">{{ listing.nb_bookmarks }}</span></span>
                                <span><img src="/icons/mail.svg" uk-svg> <span class="uk-text-middle">{{ listing.nb_messages }}</span></span>
                            </div>
                        </div>
                        <div class="uk-grid uk-child-width-1-4 uk-width-expand"  :class="`uk-visible@${brakepoint}`">
                            <div class="uk-text-center">
                                <span class="uk-label uk-border-rounded uk-text-capitalize" :class="{'uk-label-danger': listing.status === 'rented', 'uk-label-success': listing.status === 'published'}">{{ listing.status_human }}</span>
                                <span class="uk-label uk-border-rounded uk-text-capitalize uk-label-warning" v-if="listing.is_deleted">Obrisan</span>
                            </div>
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
                <button @click.prevent="confirmAction(route('listing.rent', listing.slug), 'Da li ste sigurni da želite da označite nekretninu kao Izdatu?')"
                        v-if="listing.status === 'published'"
                        title="Promeni status oglasa u Izdato!"
                        class="uk-button uk-button-link uk-text-danger uk-button-link uk-margin-small-right"
                >
                    <img class="uk-icon-button uk-button-default icon-button-small uk-text-danger uk-hidden@s" src="/icons/house-keys.svg" width="15" height="15" alt="keys" uk-svg>
                    <img class="uk-margin-small-right uk-visible@s" src="/icons/house-keys.svg" alt="keys" uk-svg>
                    <span class="uk-text-middle uk-text-capitalize uk-visible@s">Izdaj</span>
                </button>
                <button @click.prevent="confirmAction(route('listing.draft', listing.slug), 'Da li ste sigurni da želite da parkirate oglas?')"
                      v-if="listing.status === 'published' || listing.status === 'rented'"
                      title="Parkiraj oglas! Oglas će biti vidljiv samo za vas, a možete ga izmeniti ili ponovo objaviti kada god budete želeli!"
                      class="uk-button uk-button-link uk-text-danger uk-button-link uk-margin-small-right"
                >
                    <img class="uk-icon-button uk-button-default icon-button-small uk-text-danger uk-hidden@s" src="/icons/draft.svg" width="15" height="15" alt="draft" uk-svg>
                    <img class="uk-margin-small-right uk-visible@s" src="/icons/draft.svg" alt="draft" uk-svg>
                    <span class="uk-text-middle uk-text-capitalize uk-visible@s">Parkiraj</span>
                </button>
                <Link title="Vrati oglas iz obrisanih" class="uk-icon uk-text-danger uk-margin-small-right" method="DELETE" as="button" v-if="$page.props.user && $page.props.user.is_admin && listing.is_deleted" :href="route('admin.listing.undelete', listing.slug)">
                    <img class="uk-icon-button uk-button-default icon-button-small uk-hidden@s uk-text-danger" src="/icons/undelete.svg" width="15" height="15" alt="undelete" uk-svg>
                    <img class="uk-margin-small-right uk-visible@s" src="/icons/undelete.svg" alt="undelete" uk-svg>
                    <span class="uk-text-middle uk-visible@s">Undelete</span>
                </Link>
                <Link title="Obriši oglas" class="uk-icon uk-text-danger uk-margin-small-right" method="DELETE" as="button" v-if="$page.props.user && $page.props.user.is_admin && ! listing.is_deleted" :href="route('listing.delete', listing.slug)">
                    <img class="uk-icon-button uk-button-default icon-button-small uk-hidden@s uk-text-danger" src="/icons/trash.svg" width="15" height="15" alt="delete" uk-svg>
                    <img class="uk-margin-small-right uk-visible@s" src="/icons/trash.svg" alt="delete" uk-svg>
                    <span class="uk-text-middle uk-visible@s">Obriši</span>
                </Link>
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
    </div>
    <confirmation-modal
        show v-if="confirm.route && confirm.title"
        @close="clearModal"
        @canceled="clearModal"
        @confirmed="doAction"
    >
        {{ confirm.title }}
    </confirmation-modal>
</template>

<script setup>
    import ConfirmationModal from "@/Shared/ConfirmationModal.vue";
    import {reactive} from "vue";
    import {Inertia} from "@inertiajs/inertia";

    defineProps({
        listings: Object,
        brakepoint: {
            type: String,
            default: 'm'
        }
    })

    const initialConfirm = {
        route: null,
        title: null
    };

    let confirm = reactive({ ...initialConfirm});


    let confirmAction = (route, title) => {
        Object.assign(confirm, {
            route: route,
            title: title
        });
    }

    let clearModal = () => {
        Object.assign(confirm, initialConfirm);
    }

    let doAction = () => {
        Inertia.patch(confirm.route);
        clearModal();
    }
</script>

<style scoped>

</style>
