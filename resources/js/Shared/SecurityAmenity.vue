<template>
    <div>
        <h2 class="uk-h5 uk-text-bold" v-if="title">{{ title }}</h2>

        <div class="uk-grid uk-child-width-1-2 uk-child-width-1-3@m">
            <div class="uk-margin-small-bottom uk-text-weight-500" v-for="item in items" :key="item.id">
                <img class="uk-text-danger" :src="`/icons/${item.icon}.svg`" :alt="`${item.name}_icon`" uk-svg>
                <span class="uk-margin-small-left">{{ item.name }}</span>
            </div>
        </div>
    </div>
</template>

<script setup>
    defineProps({
        title: String,
        l: Object,
        items: Object,
    })
</script>
