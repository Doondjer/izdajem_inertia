<template>
    <show-form
        title="Sitemap"
        card_title="Trenutna lista linkova"
    >
        <template #right_header>
            <Link :href="route('admin.sitemap.update')" class="uk-button uk-button-danger">
                <img src="/icons/plus.svg" alt="new" uk-svg><span class="uk-text-middle">Update Sitemap</span>
            </Link>
        </template>
        <div>
            <table class="uk-table">
                <thead>
                <tr>
                    <th>URL</th>
                    <th>Priority</th>
                    <th>Update freq</th>
                    <th>Updated at</th>
                </tr>
                </thead>
                <tbody v-if="Object.keys(sitemap).length">
                    <tr v-for="(rows, index) in sitemap.url" :key="index">
                        <td class="text-muted"><a :href="rows['loc']" class="text-reset" target="_blank">{{ rows['loc'] }}</a></td>
                        <td>{{ rows['priority'] * 100 }}%</td>
                        <td class="text-muted">
                            {{ rows['changefreq'] }}
                        </td>
                        <td class="text-muted">
                            {{ rows['lastmod'] }}
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <td colspan="4" class="uk-text-center uk-h3">Nema pronađenih stavki!</td>
                </tbody>
            </table>
        </div>
    </show-form>
</template>

<script>
    import AdminLayout from "@/Layouts/Admin/AppLayout.vue";
    export default {
        layout: AdminLayout
    }
</script>
<script setup>
    import ShowForm from "@/Shared/Admin/Form.vue";
    defineProps({
        sitemap: Object,
    })

</script>
