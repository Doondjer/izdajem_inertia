<template>

    <div class="uk-text-center uk-margin-remove uk-alert" :class="`uk-alert-${color}`" uk-alert>
        <a v-if="close" href="#" class="uk-alert-close" aria-label="close" rel="nofollow" uk-close></a>
        <p class="uk-text-bold">{{ message }}</p>
    </div>
</template>
<script setup>
    defineProps({
        message: String,
        color: {
            type: String,
            default: 'success'
        },
        close: {
            type: Boolean,
            default: true
        }
    })
</script>
