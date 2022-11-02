<template>
    <show-form
        title="Backup"
        card_title="Trenutna lista backup-a"
    >
        <template #right_header>
            <div class="uk-button-group">

            <Link :href="route('admin.backup.create', {type: 'db'})" class="uk-button uk-button-default">
                <img src="/icons/backup.svg" alt="new" uk-svg><span class="uk-text-middle">Database</span>
            </Link>
            <Link :href="route('admin.backup.create', {type: 'db'})" class="uk-button uk-button-danger-outline">
                <img src="/icons/backup.svg" alt="new" uk-svg><span class="uk-text-middle">Files</span>
            </Link>
            <Link :href="route('admin.backup.create', {type: 'full'})" class="uk-button uk-button-danger">
                <img src="/icons/backup.svg" alt="new" uk-svg><span class="uk-text-middle">Full</span>
            </Link>
            <Link :href="route('admin.backup.check')" class="uk-button uk-button-primary">
                <img src="/icons/security.svg" alt="new" uk-svg><span class="uk-text-middle">Proveri</span>
            </Link>
            </div>
        </template>

            <table class="uk-table uk-table-striped">
                <thead>
                <tr>
                    <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all categories"></th>
                    <th class="w-1">ID <!-- Download SVG icon from http://tabler-icons.io/i/chevron-up -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm text-dark icon-thick" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><polyline points="6 15 12 9 18 15"></polyline></svg>
                    </th>
                    <th>FileName</th>
                    <th>Disk</th>
                    <th>Izmenjen</th>
                    <th>Veličina</th>
                    <th>Akcija</th>
                </tr>
                </thead>
                <tbody v-if="Object.keys(backup).length">
                    <tr v-for="(b,i) in backup" :key="i">
                        <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select permission"></td>
                        <td><span class="text-muted">{{ b.id }}</span></td>
                        <td class="td-truncate">
                           <div class="text-truncate">{{ b.filename }}</div>
                        </td>
                        <td><span class="uk-label uk-border-rounded" :class="{'uk-label-danger': b.diskName === 'google'}" >{{ b.diskName }}</span></td>
                        <td>{{ b.updatedAt }}</td>
                        <td>{{ b.size }}</td>
                        <td>
                            <div class="btn-list flex-nowrap">
                               <a :href="b.downloadPath" class="uk-icon uk-button-default uk-icon-button uk-margin-small-right" title="Download">
                                   <img src="/icons/download.svg" alt="download" uk-svg>
                               </a>
                               <Link as="button" class="uk-icon uk-button-danger uk-icon-button" title="Obriši" :href="b.deletePath" preserve-scroll method="DELETE">
                                   <img src="/icons/trash.svg" alt="obrisi" uk-svg>
                               </Link>
                           </div>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="4" class="text-center h3">Nema pronađenih stavki!</td>
                    </tr>
                </tbody>
            </table>
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
    backup: Object,
})

</script>
