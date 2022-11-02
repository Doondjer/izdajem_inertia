<template>
    <Modal :show="true" @close="$emit('close')">
        <div class="uk-padding">
            <h3 class="uk-h4">Podeli ovaj oglas</h3>
            <ul class="uk-nav">
                <li>
                    <a aria-label="Podeli na Facebook"
                       title="Podeli na Facebook"
                       :href="`https://www.facebook.com/sharer/sharer.php?u=${route('listing.show', l.slug)}`"
                       target="_blank"
                    >
                        <img src="/icons/facebook.svg" class="uk-icon-button uk-button-primary button-facebook" alt="facebook_icon" uk-svg />
                        <span class="uk-margin-small-left uk-width-expand">Facebook</span>
                    </a>
                </li>
                <li class="uk-margin-small-top">
                    <a  aria-label="Podeli na Twitter"
                        title="Podeli na Twitter"
                        :href="'https://twitter.com/intent/tweet?text=' + encodeURI(`${title} ${route('listing.show', l.slug)}`)"
                        target="_blank"
                    >
                        <img src="/icons/twitter.svg" class="uk-icon-button uk-button-primary button-twitter" alt="twitter_icon" uk-svg />
                        <span class="uk-margin-small-left uk-width-expand">Twitter</span>
                    </a>
                </li>
                <li class="uk-margin-small-top">
                    <a  aria-label="Podeli na Pinterest"
                        title="Podeli na Pinterest"
                        :href="'https://pinterest.com/pin/create/button/?' + encodeURI(`url=${route('listing.show', l.slug)}&media=${$page.props.config.image_base_route}/original/${l.image}&description=${title}`)"
                        target="_blank"
                    >
                        <img src="/icons/pinterest.svg" class="uk-icon-button uk-button-danger" alt="pinterest_icon" uk-svg />
                        <span class="uk-margin-small-left uk-width-expand">Pinterest</span>
                    </a>
                </li>
                <li class="uk-margin-small-top">
                    <a  aria-label="Podeli na Email"
                        title="Podeli na Email"
                        :href="'mailto:?' + encodeURI(`subject=${title}&body=${l.street}, ${l.district}, ${l.city} - ${route('listing.show', l.slug)}`)"
                        target="_blank"
                    >
                        <img src="/icons/mail.svg" class="uk-icon-button" alt="kontakt_icon" uk-svg />
                        <span class="uk-margin-small-left uk-width-expand">Email</span>
                    </a>
                </li>
            </ul>
        </div>

    </Modal>
</template>

<script setup>
    import Modal from '@/Shared/Modal.vue';

    let props = defineProps({
        l: Object
    })

    let title = `Izdaje se ${props.l.type_human} na Izdajem.rs Proverite`;
</script>

<style scoped>

</style>
