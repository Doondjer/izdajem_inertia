<template>
    <div uk-lightbox  class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slideshow="ratio: true; animation: push">
        <ul class="uk-slideshow-items" uk-height-viewport="offset-top: true; min-height: 300; offset-bottom: 10">
            <li :class="{'uk-active uk-transition-active': i === 0 && ! loaded }" v-for="(image, i) in l.images" :key="image.filename">
                <div class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                    <picture>
                        <source media="(max-width: 350px)" :srcset="`${$page.props.config.image_base_route}/200/${image.webp_filename} 200w`" type="image/webp" v-if="image.webp_filename">
                        <source media="(max-width: 500px)" :srcset="`${$page.props.config.image_base_route}/350/${image.webp_filename} 350w`" type="image/webp" v-if="image.webp_filename">
                        <source :srcset="`${$page.props.config.image_base_route}/original/${image.webp_filename}`" type="image/webp" v-if="image.webp_filename">
                        <source :srcset="`${$page.props.config.image_base_route}/original/${image.filename}`" type="image/jpeg">
                        <img :src="`${$page.props.config.image_base_route}/original/${image.filename}`" :alt="`Slika ${i+1} objekta za izdavanje`" uk-cover>
                    </picture>
                </div>

                <a title="Pogledaj galeriju"
                   :href="`${$page.props.config.image_base_route}/original/${image.filename}`"
                   class="uk-border-rounded uk-overlay-primary uk-position-bottom-right uk-position-small uk-overlay-default uk-text-center uk-padding-small"
                   :data-caption="`<span class='uk-align-right uk-margin-remove-bottom uk-margin-right uk-text-large'>
                                        <a title='Slika u punoj veličini' href='${$page.props.config.image_base_route}/original/${image.filename}' class='uk-icon uk-margin-right' target='_blank'>
                                            <img src='/icons/zoom-map.svg' width='42' height='42' alt='zoom' uk-svg>
                                        </a>
                                        <span class='uk-text-middle'>${i+1} / ${l.images.length}</span>
                                    </span>`"
                >
                    <img src="/icons/zoom-map.svg" alt="zoom_map_icon" width="30" height="30" uk-svg />
                    <div>{{ i + 1}} / {{ l.images.length }} Slika</div>
                </a>
            </li>
            <li  v-if="l.video_url">
                <div class="uk-position-cover">
                    <iframe class="uk-height-viewport" :src="`https://www.youtube-nocookie.com/embed/${l.youtube_id}?showinfo=0&amp;rel=0&amp;modestbranding=1&amp;playsinline=1`" width="100%" allowfullscreen uk-responsive uk-video="automute: true"></iframe>
                    <a aria-label="Video"
                       :href="l.video_url"
                       data-caption="Video snimak nekretnine"
                       data-attrs="width: 1280; height: 720;"
                    ></a>
                </div>
            </li>
        </ul>
        <button class="uk-position-center-left uk-position-small uk-hidden-hover uk-slidenav-large" aria-label="previous" href="#" uk-slidenav-previous uk-slideshow-item="previous"></button>
        <button class="uk-position-center-right uk-position-small uk-hidden-hover uk-slidenav-large" aria-label="next" href="#" uk-slidenav-next uk-slideshow-item="next"></button>

    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";

    defineProps({
        l: Object,
    });

    let loaded = ref(false);

    onMounted(() => {
        loaded.value = true;
    })
</script>
