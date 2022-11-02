<template>
    <div class="uk-card uk-card-small" :class="{'uk-card-default': border}">
        <slot name="header">
            <div class="uk-card-header" v-if="title">
                <h2 class="uk-card-title" v-text="title"></h2>
            </div>
        </slot>
        <div :class="bodyClass ? bodyClass : 'uk-card-body'">
            <slot name="body"></slot>
        </div>
        <div class="uk-card-footer" :class="{'uk-background-muted uk-grid-collapse uk-grid': $slots.footer_info}" v-if="$slots.footer || $slots.footer_info">
            <slot name="footer">
                <div class="uk-width-auto uk-margin-small-right">
                    <img src="/icons/info.svg" alt="i" uk-svg>
                </div>
                <div class="uk-width-expand uk-text-middle">
                    <slot name="footer_info"></slot>
                </div>
            </slot>
        </div>
    </div>
</template>

<script setup>
    defineProps({
        title: String,
        bodyClass: {
            type: String,
            default: ''
        },
        border: {
            type: Boolean,
            default: true
        }
    });

</script>

<style scoped>

</style>
