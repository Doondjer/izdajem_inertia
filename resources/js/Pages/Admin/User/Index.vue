<template>
    <index-page
        title="Korisnici"
        :trashed_filter="true"
        v-model:q="form.q"
        v-model:per_page="form.per_page"
        v-model:trashed="form.trashed"
        v-model:page="form.page"
        :dataSet="users"
    >
        <template #thead>
            <tr>
                <th><input class="uk-checkbox" type="checkbox" aria-label="Select all users"></th>
                <th>ID <!-- Download SVG icon from http://tabler-icons.io/i/chevron-up -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm text-dark icon-thick" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><polyline points="6 15 12 9 18 15"></polyline></svg>
                </th>
                <th>Slika</th>
                <th class="uk-table-expand">Korisnik</th>
                <th>Verifikovan</th>
                <th>Roles</th>
                <th>Izmenjen</th>
                <th>Akcija</th>
                <th></th>
            </tr>
        </template>
        <template #tbody>
            <tr v-for="(user, index) in users.data" :key="index" :class="{'uk-text-danger': user.is_trashed}">
            <td><input class="uk-checkbox" type="checkbox" aria-label="Select User"></td>
            <td><span class="uk-text-muted">#{{ user.id }}</span></td>
            <td>
                <img class="uk-link uk-border-circle" :src="`${$page.props.config.image_base_route}/40x40/${user.profile_image}`" width="40" height="40" :alt="user.name" uk-img />
            </td>
            <td class="uk-table-link">
                <Link :href="route('admin.user.show', user.id)">
                    <dl class="uk-description-list-horizontal">
                        <dt class="uk-text-nowrap">
                            {{ user.name}}
                        </dt>
                        <dd class="uk-text-muted">{{ user.email }}</dd>
                    </dl>
                </Link>
            </td>
            <td>
                <span v-if="user.is_verified" class="uk-text-success">
                    <img src="/icons/check-circle.svg" width="27" height="27" uk-svg>
                </span>
                <span v-else class="uk-text-danger">
                    <img src="/icons/cancel-outline.svg" width="27" height="27" uk-svg>
                </span>
            </td>
            <td>
                <span class="uk-label uk-border-rounded" :class="{'uk-label-danger': user.is_admin}">{{ user.is_admin ? 'Administrator' : 'Korisnik' }}</span>
            </td>
            <td>
                {{ user.updated_at }}
            </td>
            <td class="uk-text-nowrap uk-text-right">
                <Link title="Pogledaj" :href="route('admin.user.show', user.id)" class="uk-icon uk-button-default uk-icon-button">
                    <img src="/icons/saved.svg" alt="pogledaj" uk-svg>
                </Link>
                    <span v-if="user.is_trashed" class="uk-icon-button uk-button-large uk-button-danger uk-disabled uk-margin-small-left">
                        Obrisan
                    </span>
                    <Link v-else title="Obriši" as="button" method="DELETE" :href="route('admin.user.delete', user.id)" class="uk-margin-small-left uk-icon uk-button-danger uk-icon-button">
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
    users: Object,
    filters: Object,
})

let form = useForm({
    q: props.filters.q || null,
    page: props.filters.page || 1,
    per_page: props.filters.per_page || 10,
    trashed: props.filters.trashed || '',
})
watch(form, _.throttle(
    (newValue, oldValue) => {
        Inertia.get(route('admin.user.index'), form.data(), { preserveScroll: true, preserveState: true });
    }, 200),
    {deep: true}
)
</script>
