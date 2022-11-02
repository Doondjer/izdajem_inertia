<script setup>

import EditUserSettings from "@/Shared/EditUserSettings.vue";
import BaseFooter from "@/Shared/Footer.vue";

let props = defineProps({
    settings: Object,
    values: Object,
});
</script>

<template>

    <Head title="Podešavanje aplikacije" />

    <div class="uk-section-small uk-section-default" uk-height-viewport="expand: true">
        <div class="uk-container uk-container-xsmall">
            <edit-user-settings :route_path="route('setting.update')" :settings="settings" :values="values" />
        </div>
    </div>
    <hr class="uk-hr uk-margin-remove">
    <base-footer />

</template>
