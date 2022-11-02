<template>
    <create :store_route="route('admin.listing.store')" />
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AppLayout.vue";
export default {
    layout: AdminLayout
}
</script>

<script setup>
    import Create from "@/Pages/Listing/Create.vue"
</script>

<style scoped>

</style>
