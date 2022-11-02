<template>

    <page-form
        title="Kreiraj Stranicu"
        card_title="Kreiraj Novu Stranicu"
        @submited="submit"
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

let submit = (form) => {
    form.post(route('admin.page.store'), { preserveScroll: true })
}

</script>

