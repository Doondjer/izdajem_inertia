<template>
    <ul class="uk-pagination uk-flex-center" v-if="dataSet.per_page < dataSet.total">
        <li v-for="link in dataSet.links" class="page-item" :class="{ 'uk-active': link.active, 'uk-disabled': ! link.url }">
            <a href="#" @click.prevent="goto(link.url)" tabindex="-1" :aria-disabled="link.url ? 'false' : 'true' " :class="{ 'uk-disabled': ! link.url || link.active }">
                <span v-html="link.label"></span>
            </a>
        </li>
    </ul>
</template>

<script setup>
    import { Inertia } from '@inertiajs/inertia';

    defineProps({
        'dataSet': Object,
        'page': [String, Number]
    });
    let goto = (url) => {
        Inertia.get(url, {} , { preserveState: true });
    }
</script>
