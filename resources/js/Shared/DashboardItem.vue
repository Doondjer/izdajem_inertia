<template>
    <Link :href="link" class="uk-card uk-card-default uk-border-rounded-xl uk-grid-collapse uk-card-small uk-grid" style="text-decoration: unset" uk-grid>
        <div class="uk-card-media-left uk-border-rounded-xl uk-flex uk-width-auto">
            <slot name="left" />
        </div>
        <div class="uk-width-expand">
            <div class="uk-card-body">
                <h3 class="uk-card-title">{{ title }}</h3>
                <slot />
            </div>
        </div>
    </Link>
</template>

<script setup>
    defineProps({
        title: String,
        link: String
    })
</script>
