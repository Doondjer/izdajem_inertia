<template>

    <Head>
        <title>Izdavanje stanova Beograd, Novi Sad, Srbija</title>
        <meta head-key="og:title" property="og:title" content="Izdavanje stanova Beograd, Novi Sad, Srbija" />
        <meta head-key="description"  name="description" content="Izdajem.rs je oglasnik za izdavanje nekretnina u Srbiji. Oglasite izdavanje vašeg stana, kuće, poslovnog prostora ili pronađite prave stanare za vašu nekretninu.">
    </Head>

    <div uk-scrollspy="target: > .spy; cls: uk-animation-fade; delay: 300">
        <div class="uk-cover-container" uk-height-viewport='offset-top: true; min-height: 300;' style="min-height: 300px">
            <picture>
                <source :srcset="`${$page.props.config.image_base_route}/original/${data.main_image_webp}`" type="image/webp">
                <source :srcset="`${$page.props.config.image_base_route}/original/${data.main_image}`" type="image/jpeg">
                <img class="uk-width" :src="`${$page.props.config.image_base_route}/original/${data.main_image}`" alt="Izdajem.rs velika ponuda stanova soba i kuća za izdavanje" uk-cover>
            </picture>

            <video class="uk-width" src="/videos/street_angle.mp4" autoplay loop muted playsinline uk-cover></video>

            <div class="uk-position-center uk-text-center uk-light">
                <h1 class="uk-text-center">{{ data.home_title }}</h1>
                <p class="uk-text-warning uk-h3">{{ data.home_subtitle }}</p>
                <div class="uk-align-center uk-grid">
                    <Link class="uk-button uk-button-default uk-margin-small uk-margin-small-top uk-width-medium uk-button-large uk-padding-remove invert uk-text-bold" :href="route('listing.index')"><h2 class="uk-text-bold uk-preserve-color">Nekretnine za Izdavanje</h2></Link>
                    <Link :href="route('listing.create')" class="uk-button uk-button-danger uk-margin-small uk-width-medium uk-button-large uk-text-bold"><h2 class="uk-text-bold">Oglasite Nekretninu</h2></Link>
                </div>
            </div>
        </div>
        <div class="uk-section-small">
            <div class="uk-container uk-container-xlarge spy">
                <div class="uk-card uk-card-default uk-border-rounded-xl uk-grid-collapse uk-child-width-1-2@s uk-grid">
                    <div class="uk-flex-last@s uk-border-rounded-xl uk-card-media-right uk-cover-container">
                        <picture>
                            <source media="(max-width: 350px)" :srcset="`${$page.props.config.image_base_route}/350/${data.card_media_right_webp} 350w`" type="image/webp">
                            <source media="(max-width: 500px)" :srcset="`${$page.props.config.image_base_route}/500/${data.card_media_right_webp} 500w`" type="image/webp">
                            <source media="(max-width: 800px)" :srcset="`${$page.props.config.image_base_route}/800/${data.card_media_right_webp} 800w`" type="image/webp">
                            <source media="(min-width: 800px)" :srcset="`${$page.props.config.image_base_route}/original/${data.card_media_right_webp}`" type="image/webp">
                            <source media="(max-width: 350px)" :srcset="`${$page.props.config.image_base_route}/350/${data.card_media_right_jpg} 350w`" type="image/jpeg">
                            <source media="(max-width: 500px)" :srcset="`${$page.props.config.image_base_route}/500/${data.card_media_right_jpg} 500w`" type="image/jpeg">
                            <source media="(max-width: 800px)" :srcset="`${$page.props.config.image_base_route}/800/${data.card_media_right_jpg} 800w`" type="image/jpeg">
                            <source media="(min-width: 800px)" :srcset="`${$page.props.config.image_base_route}/original/${data.card_media_right_jpg}`" type="image/jpeg">
                            <img :src="`${$page.props.config.image_base_route}/original/${data.card_media_right_jpg}`" alt="Pronađi stan za izdavanje" uk-cover>
                        </picture>
                        <canvas width="600" height="400"></canvas>
                    </div>
                    <div class="uk-first-column">
                        <div class="uk-card-body">
                            <h3 class="uk-card-title">{{ data.card_media_right_title }}</h3>
                            <p>{{ data.card_media_right_content }}</p>
                            <p>
                                <Link class="uk-button uk-button-default uk-width-medium@s uk-width-1-1 uk-button-large uk-text-bold" :href="route('listing.index')">Nekretnine za Izdavanje</Link>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="uk-card uk-card-default uk-border-rounded-xl uk-grid-collapse uk-child-width-1-2@s uk-margin uk-grid spy">
                    <div class="uk-card-media-left uk-border-rounded-xl uk-cover-container uk-first-column">
                        <picture>
                            <source media="(max-width: 350px)" :srcset="`${$page.props.config.image_base_route}/350/${data.card_media_left_webp} 350w`" type="image/webp">
                            <source media="(max-width: 500px)" :srcset="`${$page.props.config.image_base_route}/500/${data.card_media_left_webp} 500w`" type="image/webp">
                            <source media="(max-width: 800px)" :srcset="`${$page.props.config.image_base_route}/800/${data.card_media_left_webp} 800w`" type="image/webp">
                            <source media="(min-width: 800px)" :srcset="`${$page.props.config.image_base_route}/original/${data.card_media_left_webp}`" type="image/webp">
                            <source media="(max-width: 350px)" :srcset="`${$page.props.config.image_base_route}/350/${data.card_media_left_jpg} 350w`" type="image/jpeg">
                            <source media="(max-width: 500px)" :srcset="`${$page.props.config.image_base_route}/500/${data.card_media_left_jpg} 500w`" type="image/jpeg">
                            <source media="(max-width: 800px)" :srcset="`${$page.props.config.image_base_route}/800/${data.card_media_left_jpg} 800w`" type="image/jpeg">
                            <source media="(min-width: 800px)" :srcset="`${$page.props.config.image_base_route}/original/${data.card_media_left_jpg}`" type="image/jpeg">
                            <source :srcset="`${$page.props.config.image_base_route}/original/${data.card_media_left_jpg}`" type="image/jpeg">
                            <img :src="`${$page.props.config.image_base_route}/original/${data.card_media_left_jpg}`" alt="Pronađite sledeće stanare" uk-cover>
                        </picture>
                        <canvas width="600" height="400"></canvas>
                    </div>
                    <div>
                        <div class="uk-card-body">
                            <h3 class="uk-card-title">{{ data.card_media_left_title }}</h3>
                            <p>{{ data.card_media_left_content }}</p>
                            <p>
                                <Link :href="route('listing.create')" class="uk-button uk-button-danger-outline uk-button-default uk-width-medium@s uk-width-1-1 uk-button-large uk-text-bold">Oglasite Izdavanje</Link>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="uk-section-small uk-section-default">
            <div class="uk-container uk-container-xlarge spy">
                <h2 class="uk-h2 uk-text-large">{{ data.slider_tile }}</h2>

                <div class="uk-flex-center uk-position-relative uk-grid" uk-grid="masonry: true">
                    <listing-card :listing="listing" v-for="listing in listings.data" :key="listing.slug"/>
                </div>

            </div>
        </div>

        <send-us-message class="uk-margin"/>

        <home-footer :message="data.footer_info_text"/>
        <base-footer />
    </div>


</template>

<script setup>

import HomeFooter from "@/Shared/HomeFooter.vue";
import BaseFooter from "@/Shared/Footer.vue";
import SendUsMessage from "@/Shared/SendUsMessage.vue";
import ListingCard from "@/Shared/ListingCard.vue";

defineProps({
    data: Object,
    listings: Object
})
</script>
