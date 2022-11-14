<template>

    <Head>
        <title>{{ title }}</title>

        <meta head-key="description"  name="description" :content="l.short_description">

        <meta head-key="og:description" property="og:description" :content="l.short_description" />

        <meta head-key="twitter:title" name="twitter:title" :content="title" />

        <meta head-key="twitter:description" name="twitter:description" :content="l.short_description" />

        <meta head-key="twitter:image:alt" name="twitter:image:alt" content="Slika objekta koji se izdaje" />

        <meta head-key="twitter:image" name="twitter:image" :content="`${$page.props.config.image_base_route}/640x459/${l.image}`" />

        <meta head-key="twitter:creator" property="twitter:creator" :content="`@${l.user ? l.user.name : 'guest'}`" />

        <meta head-key="og:type" property="og:type" content="og:product" />

        <meta head-key="og:title" property="og:title" :content="title" />

        <meta head-key="og:image" property="og:image" :content="`${$page.props.config.image_base_route}/1024x768/${l.image}`" />

        <meta head-key="og:image:alt" property="og:image:alt" content="Slika objekta koji se izdaje" />

        <meta head-key="og:video" property="og:video" v-if="l.video_url" :content="l.video_url" />
    </Head>

    <div>
        <div v-if="l.status !== 'published'" class="uk-alert-warning uk-text-center uk-margin-remove uk-alert" uk-alert>
            <a href="#" class="uk-alert-close" aria-label="close" rel="nofollow" uk-close></a>
            <p class="uk-text-danger uk-text-bold" v-if="l.status === 'rented'">Ova nekretnina je izdata.</p>
            <p class="uk-text-danger uk-text-bold" v-else-if="l.status === 'draft'">Ovaj oglas je parkiran.</p>
            <p class="uk-text-danger uk-text-bold" v-else-if="l.status === 'created'">Ovaj oglas je nedovršen.</p>
            <p class="uk-text-danger uk-text-bold" v-else>Status ovog oglasa je nepoznat!</p>
        </div>
        <div class="uk-section-default">
            <div class="uk-container-expand">

                <breadcrumb :l="l" class="uk-grid-collapse uk-grid" uk-grid />

            </div>
        </div>
        <div class="uk-card uk-card-default uk-card-small uk-grid-collapse uk-grid uk-grid-match" uk-grid>
            <div class="uk-card-media-left uk-cover-container uk-width-2-3@m">
                <image-container :l="l" />
            </div>
            <div class="uk-width-1-3@m">
                <right-info :l="l" :user="user"/>
            </div>

            <div class="uk-card-footer uk-width-expand uk-hidden@m">
                <button class="uk-button uk-button-danger-outline uk-button-large" @click.prevent="openMap = true">Pogledaj na mapi</button>
            </div>
        </div>
        <div typeof="schema:Product" class="uk-section-default uk-margin-top">
            <div property="schema:name" :content="title"></div>
            <div property="schema:sku" :content="l.slug"></div>
            <div rel="schema:image" :resource="`${$page.props.config.image_base_route}/1024x768/${l.image}`"></div>
            <div rel="schema:brand">
                <div typeof="schema:Brand">
                    <div property="schema:name" content="izdajem.rs"></div>
                </div>
            </div>

            <div rel="schema:aggregateRating">
                <div typeof="schema:AggregateRating">
                    <div property="schema:reviewCount" content="1"></div>
                    <div property="schema:ratingValue" content="5"></div>
                </div>
            </div>

            <div rel="schema:offers">
                <div typeof="schema:Offer">
                    <div property="schema:price" :content="l.price"></div>
                    <div property="schema:availability" :content="l.is_published ? 'https://schema.org/InStock' : 'https://schema.org/SoldOut'"></div>
                    <div property="schema:priceCurrency" content="EUR"></div>
                    <div property="schema:priceValidUntil" datatype="xsd:date" v-if="l.expires_at" :content="l.expires_at"></div>
                    <div rel="schema:url" :resource="$page.props.ziggy.location"></div>
                </div>
            </div>

            <div class="uk-container uk-padding-remove-horizontal">
            <div class="uk-grid-small uk-grid" id="details_grid" uk-grid>
                <div class="uk-width-expand">
                    <div id="description" class="uk-card uk-card-small hr-split">
                        <div class="uk-card-body">

                            <description :l="l" />

                            <basic-info :l="l" />

                            <conditions :l="l" v-if=" l.status !== 'rented'" />

                            <security-amenity :l="l" :items="l.amenities" title="Opremljenost nekretnine" v-if="l.amenities.length" />

                            <security-amenity :l="l" :items="l.securities" v-if="l.securities.length" />


                            <div v-if="l.youtube_id">
                                <h2 class="uk-h5 uk-text-bold">Video snimak nekretnine</h2>
                                <div class="uk-overflow-hidden uk-position-z-index uk-border-rounded-xl uk-width-max-content">
                                    <iframe :src="`https://www.youtube-nocookie.com/embed/${l.youtube_id}?showinfo=0&amp;rel=0&amp;modestbranding=1&amp;playsinline=1`" width="800" height="600" allowfullscreen uk-responsive uk-video="automute: true"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-width-xmedium uk-visible@m uk-margin-top">
                    <div class="uk-position-z-index" uk-sticky="end: #details_grid; offset: 80">

                        <contact-user-card v-if="l.user && l.status !== 'rented'" :user="l.user" :l="l" />

                        <a href="#" @click.prevent="openMap = true" class="uk-inline uk-card uk-card-default uk-margin-small uk-border-rounded-xl">
                            <picture>
                                <source :srcset="`${config.image_base_route}/300/view_on_map.webp`" type="image/webp">
                                <source :srcset="`${config.image_base_route}/300/view_on_map.jpg`" type="image/jpeg">
                                <img :data-src="`${config.image_base_route}/300/view_on_map.jpg`" alt="slika mape" class="uk-border-rounded-xl" width="300" height="170" uk-img>
                            </picture>
                            <div class="uk-position-cover uk-flex uk-flex-center uk-flex-middle">
                                <button class="uk-button uk-button-danger-outline">Pogledaj na mapi</button>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="uk-section-small" v-if="l.status !== 'rented'" id="contact_user_form">
            <div class="uk-container uk-container-small uk-padding-remove-horizontal">

                <contact-user-form class="uk-width" v-if="l.user" :user="l.user" :l="listing.data" />

                <p class="uk-grid uk-grid-small uk-margin">
                    <span class="uk-width-expand">Id Nekretnine: {{ l.slug }}</span>
                    <span class="uk-width-auto" v-if="l.nb_views">Br Pregleda: {{ l.nb_views }}</span>
                </p>
            </div>
        </div>

        <div class="uk-section uk-section-small uk-section-default uk-text-center">
            <div class="uk-container uk-container-xsmall uk-width-xlarge">
                <div class="uk-h3 uk-text-bold">{{ listings.data.length ? 'Još' : 'Nema više' }} nekretnina za izdavanje u opštini {{ l.district }}, grad {{ l.city }} </div>
                <p>Ove nekretnine za izdavanje se biraju na osnovu tipa i udaljenosti od opštine {{ l.district }}, grad {{ l.city }} gde je {{ l.type === '2' ? 'oglašena' : 'oglašen' }} {{ l.type_human }} za izdavanje</p>
                <Link :href="route('landlord.show', listing.data.user.id)" v-if="l.user && l.user.show_profile" class="uk-button uk-button-default uk-button-large uk-margin-medium">Pogledaj profil stanodavca</Link>
            </div>
            <div class="uk-flex-center uk-position-relative uk-margin-medium uk-grid uk-grid-small" uk-grid="" v-if="listings.data.length">
                <listing-card class="uk-border-rounded-xl" :listing="listing" v-for="listing in listings.data" :key="listing.slug"/>
            </div>
        </div>

        <hr class="uk-hr uk-margin-remove" />

        <base-footer />

        <location-map :l="l"  v-if="openMap" @close_map="openMap = false"/>
    </div>

</template>

<script setup>
    import RightInfo from "@/Shared/RightInfoListingShow.vue";
    import ImageContainer from "@/Shared/ImageListingShow.vue";
    import Description from "@/Shared/DescriptionListingShow.vue";
    import BasicInfo from "@/Shared/BasicInfoListingShow.vue";
    import Conditions from "@/Shared/ConditionsListingShow.vue";
    import Breadcrumb from "@/Shared/BreadcrumbListingShow.vue";
    import ContactUserCard from "@/Shared/ContactUserCard.vue";
    import ContactUserForm from "@/Shared/ContactUserForm.vue";
    import BaseFooter from "@/Shared/Footer.vue";
    const ListingCard = defineAsyncComponent(() =>  import('@/Shared/ListingCard.vue'));
    const SecurityAmenity = defineAsyncComponent(() =>  import('@/Shared/SecurityAmenity.vue'));
    const LocationMap = defineAsyncComponent(() =>  import('@/Shared/LocationMap.vue'));

    import {computed, defineAsyncComponent, ref} from "vue";

    let openMap = ref(false);

    let props = defineProps({
        listing: Object,
        listings: Object,
        user: Object,
        config: Object,
    })

    let l = computed(() => {
        return props.listing.data;
    })
    let title = computed(() => {
        return `${props.listing.data.type_human} za izdavanje ${props.listing.data.street}, ${props.listing.data.city}, ${props.listing.data.district}`;
    })


</script>

<style scoped>
    .cover-text {
        color: #fff;
    }
    .cover-text:hover {
        color: #cb2027;
    }
</style>
