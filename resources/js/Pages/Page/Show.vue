<template>

    <Head>
        <title>{{ page.meta_title}}</title>
        <meta head-key="description"  name="description" v-if="page.meta_description" :content="page.meta_description">
        <meta head-key="keywords"  name="description" v-if="page.meta_keywords" :content="page.meta_keywords">
    </Head>

    <div class="uk-section uk-margin-auto-vertical" uk-height-viewport="expand: true">
        <div class="uk-container" :class="[page.size ? `uk-container-${page.size}` : '', page.classes]">
            <card :title="page.title">

                <template #body>
                    <div v-html="page.content"></div>
                </template>

            </card>
        </div>
    </div>
    <base-footer />
</template>

<script setup>
    import Card from "@/Shared/Card.vue";
    import BaseFooter from "@/Shared/Footer.vue";

    defineProps({
        page: Object
    })
</script>

<style scoped>

</style>
