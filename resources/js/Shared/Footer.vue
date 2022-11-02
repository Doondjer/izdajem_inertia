<template>
    <div class="uk-section uk-section-xsmall uk-section-default">
        <div class="uk-container">
            <div class="uk-grid uk-grid-collapse">
                <div class="uk-width-auto@m uk-width-1-1 uk-text-center">
                    <a v-for="social in $page.props.config.social" :href="social.url" target="_blank" :aria-label="social.name" class="uk-icon-button uk-margin-small-left uk-button-default uk-text-meta" rel="noreferrer">
                        <img :src="`/icons/${social.icon}.svg`" alt="facebook" width="30" height="30" uk-svg>
                    </a>
                </div>

                <div class="uk-width-expand@m uk-width-1-1 uk-text-center uk-flex-right@m uk-grid uk-grid-collapse uk-child-width-auto@m uk-child-width-1-2">
                    <Link :href="route('home')" class="uk-padding-small uk-text-muted">@Izdajem.rs</Link>
                    <Link :href="route('page.show', 'uslovi-koriscenja')" class="uk-padding-small uk-text-muted">Uslovi korišćenja</Link>
                    <Link :href="route('page.show', 'politika-privatnosti')" class="uk-padding-small uk-text-muted">Privatnost</Link>
                    <a  target="_blank" href="/sitemap.xml" class="uk-padding-small uk-text-muted">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

</script>
