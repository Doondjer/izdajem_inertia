<template>
    <index-page
        title="Konverzacije"
        :trashed_filter="true"
        v-model:q="form.q"
        v-model:per_page="form.per_page"
        v-model:trashed="form.trashed"
        v-model:page="form.page"
        :dataSet="threads"
    >
        <template #thead>
            <tr>
                <th></th>
                <th class="uk-table-shrink"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all users"></th>
                <th class="uk-table-shrink">ID <!-- Download SVG icon from http://tabler-icons.io/i/chevron-up -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm text-dark icon-thick" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><polyline points="6 15 12 9 18 15"></polyline></svg>
                </th>
                <th class="uk-table-shrink">Učesnici</th>
                <th class="uk-table-expand">Konverzacije</th>
                <th class="uk-table-shrink">Vreme</th>
                <th class="uk-table-shrink">Akcija</th>
                <th></th>
            </tr>
        </template>
        <template #tbody>
            <tr v-for="(thread, index) in threads.data" :key="index" :class="{'uk-text-danger': thread.is_trashed}">
                <td></td>
                <td><input class="uk-checkbox" type="checkbox" aria-label="Select Message"></td>
                <td><span class="uk-text-muted">#{{ thread.id }}</span></td>

                <td data-label="Korisnici">
                    <div v-if="thread.messages.length">
                        <Link v-for="(participant, i) in thread.participants" :key="i" :href="route('admin.user.show', participant.user_id)" class="" :title="`#${participant.user_id} - ${participant.name}`">
                            <img class="uk-link uk-border-circle" :src="`${$page.props.config.image_base_route}/40x40/${participant.profile_image}`" width="40" height="40" :alt="participant.name" uk-img />
                        </Link>
                    </div>
                </td>
                <td class="uk-table-link uk-text-truncate">
                    <Link :href="route('message.show', thread.id)">
                        <dl class="uk-description-list-horizontal">
                            <dt class="uk-text-truncate">
                                #<span class="uk-text-muted">{{ thread.listing_id }}</span>: <span v-text="thread.subject"></span>
                            </dt>
                            <dd v-if="thread.messages.length" class="uk-text-muted uk-text-truncate">{{ thread.messages[0].data.body_truncated }}</dd>
                        </dl>
                    </Link>
                </td>
                <td class="uk-text-nowrap">
                    {{ thread.updated_at }}
                </td>
                <td class="uk-text-nowrap uk-text-right">
                    <Link title="Pogledaj" :href="route('admin.thread.show', thread.id)" class="uk-icon uk-button-default uk-icon-button">
                        <img src="/icons/saved.svg" alt="pogledaj" uk-svg>
                    </Link>
                    <Link v-if="thread.is_trashed" title="Vrati iz obrisanih" as="button" method="DELETE" :href="route('admin.thread.undelete', thread.id)" class="uk-margin-small-left uk-icon uk-button-danger uk-icon-button">
                        <img src="/icons/undelete.svg" alt="undelete" uk-svg>
                    </Link>
                    <Link v-else title="Obriši" as="button" method="DELETE" :href="route('admin.thread.delete', thread.id)" class="uk-margin-small-left uk-icon uk-button-danger uk-icon-button">
                        <img src="/icons/trash.svg" alt="trash" uk-svg>
                    </Link>
                </td>
                <td></td>
            </tr>
        </template>
    </index-page>
</template>

<script>
    import AdminLayout from "@/Layouts/Admin/AppLayout.vue";
    export default {
        layout: AdminLayout
    }
</script>

<script setup>

import IndexPage from "@/Shared/Admin/IndexPage.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import {watch} from "vue";
import {Inertia} from "@inertiajs/inertia";

let props = defineProps({
    threads: Object,
    filters: Object,
})

let form = useForm({
    q: props.filters.q || null,
    per_page: props.filters.per_page || 10,
    page: props.filters.page || 1,
    trashed: props.filters.trashed || '',
})
watch(form, _.throttle(
    (newValue, oldValue) => {
        Inertia.get(route('admin.thread.index'), form.data(), { preserveScroll: true, preserveState: true });
    }, 200),
    {deep: true}
)
</script>
