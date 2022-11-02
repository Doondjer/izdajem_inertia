<template>
    <div class="uk-width-medium">
        <card class="l-card uk-border-rounded-xl"
            bodyClass="uk-card-body uk-padding-remove-bottom"
        >
            <template #header>
                <h3 class="uk-card-badge uk-label uk-label-danger" v-text="listing.type_human"></h3>

                <div class="uk-card-media-top" style="min-height: 170px">
                    <Link :href="route('listing.show', listing.slug)" class="uk-cover-container">
                        <picture>
                            <source media="(max-width: 300px)" :srcset="`${$page.props.config.image_base_route}/300/${listing.image_webp} 300w`" type="image/webp">
                            <source media="(max-width: 370px)" :srcset="`${$page.props.config.image_base_route}/370/${listing.image_webp} 370w`" type="image/webp">
                            <source media="(max-width: 500px)" :srcset="`${$page.props.config.image_base_route}/500/${listing.image_webp} 500w`" type="image/webp">
                            <source media="(max-width: 300px)" :srcset="`${$page.props.config.image_base_route}/300/${listing.image} 300w`" type="image/jpeg">
                            <source media="(max-width: 370px)" :srcset="`${$page.props.config.image_base_route}/370/${listing.image} 370w`" type="image/jpeg">
                            <source media="(max-width: 500px)" :srcset="`${$page.props.config.image_base_route}/500/${listing.image} 500w`" type="image/jpeg">
                            <source class="uk-width" :srcset="`${$page.props.config.image_base_route}/370/${listing.image_webp}`" type="image/webp" v-if="listing.image_webp">
                            <source class="uk-width" :srcset="`${$page.props.config.image_base_route}/370/${listing.image}`" type="image/jpeg">
                            <img :src="`${$page.props.config.image_base_route}/370/${listing.image}`" :alt="`real_estate_image_${listing.slug}`" class="uk-width" width="370" height="172">
                        </picture>
                    </Link>
                    <Link :href="route('listing.show', listing.slug)" class="ribbon-wrapper ribbon-xl" v-if="listing.status === 'rented'">
                        <div class="ribbon ribbon-warning">Izdato</div>
                    </Link>
                </div>
            </template>

            <template #body>
                <div class="uk-grid uk-grid-collapse">
                    <div class="uk-width-expand">
                        <Link :href="route('listing.show', listing.slug)">
                            <h3 class="uk-h4 uk-bold uk-margin-remove" v-text="listing.street + (listing.street_nb ? ' ' + listing.street_nb : '')"></h3>
                        </Link>
                    </div>
                    <div class="uk-width-auto" v-if=" ! listing.is_owner && listing.status === 'published'">
                        <Link method="POST" class="uk-text-danger uk-icon" as="button" aria-label="bookmark" preserve-scroll :href="route('bookmark.store', listing.slug)"> <img :src="listing.is_bookmarked ? '/icons/star.svg' : '/icons/star-outline.svg'" width="28" height="28" alt="bookmarked_icon" uk-svg></Link>
                    </div>
                </div>

                    <div class="uk-text-capitalize uk-text-small">
                        <Link class="uk-text-danger darker" :href="route('listing.index', { district: listing.district })" v-text="listing.district"></Link> /
                        <Link class="uk-text-danger darker" :href="route('listing.index', { county: listing.county })" v-text="listing.county"></Link>
                    </div>
                    <div class="uk-margin-small">
                        <h4 class="uk-h3 uk-margin-remove">
                            <span class="uk-text-danger" v-text="listing.price_for_human"  v-if="listing.price_for_human"></span>
                            <span class="uk-text-small uk-text-muted" v-text="`(${listing.deposit_for_human} Depozit)`"  v-if="listing.deposit_for_human"></span>
                        </h4>
                    </div>

            </template>

            <template #footer>
                <div class="uk-grid uk-grid-small uk-grid-divider uk-flex-center" uk-grid>
                    <div :title="`Struktura: ${listing.nb_room_human}`">
                        <img src="/icons/floor-plan.svg" class="uk-icon uk-text-danger uk-margin-small-right" width="16" height="16" alt="nb_room_icon" uk-svg>
                        <span class="uk-text-middle" v-text="listing.nb_room"></span>
                    </div>
                    <div :title="`Površina: ${listing.size} m²`">
                        <img src="/icons/kvadratura.svg" class="uk-icon uk-text-danger uk-margin-small-right" width="16" height="16" alt="nb_room_icon" uk-svg>
                        <span class="uk-text-middle" v-text="listing.size + '  m²'"></span>
                    </div>
                    <div :title="`Nameštenost ${listing.furnish_type_human}`">
                        <img src="/icons/namestenost.svg" class="uk-icon uk-text-danger uk-margin-small-right" width="16" height="16" alt="nb_room_icon" uk-svg>
                        <span class="uk-text-middle" v-text="listing.furnish_type_human"></span>
                    </div>
                </div>
            </template>
        </card>
    </div>
</template>

<script setup>
    import Card from "./Card.vue";

    defineProps({
        listing: Object,
    })
</script>
