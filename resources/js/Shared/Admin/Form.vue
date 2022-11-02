<template>
    <div class="uk-section uk-section-small">
        <div class="uk-container uk-margin">
            <div class="uk-grid uk-grid-collapse">
                <h1 class="uk-h2 uk-width-expand">{{ title }}</h1>
                <div class="uk-width-auto">
                    <slot name="right_header">
                        <div class="uk-grid uk-grid-small uk-grid-divider" aria-label="breadcrumbs">
                            <div><Link :href="route('admin.home')">Početna</Link></div>
                            <slot name="breadcrumb" />
                            <div class="uk-disabled" aria-current="page"><a class="uk-text-muted" href="#">{{ title }}</a></div>
                        </div>
                    </slot>
                </div>
            </div>
        </div>
        <div class="uk-container">
            <card class="hr-split uk-border-rounded-xl" :title="card_title">

                <template #header><slot name="card_header" /></template>

                <template #body>
                    <slot />
                </template>
            </card>
        </div>
    </div>
</template>

<script setup>
    import Card from "@/Shared/Card.vue"

    defineProps({
        title: String,
        card_title: String,
    });
</script>
