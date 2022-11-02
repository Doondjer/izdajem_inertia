<template>

    <page-form
        title="Izmeni Stranicu"
        :card_title="`Dodatna Stranica - ${page.title}`"
        @submited="submit"
        :page="page"
    />

</template>

<script>

    import AdminLayout from "@/Layouts/Admin/AppLayout.vue";
    export default {
        layout: AdminLayout
    }

</script>

<script setup>
import PageForm from "./Partials/PageForm.vue";

let props = defineProps({
    page: Object,
});

let submit = (form) => {
    form.patch(route('admin.page.update', props.page.slug), { preserveScroll: true })
}

</script>

