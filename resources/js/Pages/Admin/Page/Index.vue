<template>
    <index-page
        title="Dodatne Stranice"
        v-model:q="form.q"
        v-model:per_page="form.per_page"
        v-model:trashed="form.trashed"
        v-model:page="form.page"
        :dataSet="pages"
    >
        <template #right_header>
            <Link :href="route('admin.page.create')" class="uk-button uk-button-danger">
                <img src="/icons/plus.svg" alt="new" uk-svg><span class="uk-text-middle">Kreiraj dodatnu stranicu</span>
            </Link>
        </template>

        <template #thead>
            <tr>
                <th><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all Pages"></th>
                <th>ID <!-- Download SVG icon from http://tabler-icons.io/i/chevron-up -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm text-dark icon-thick" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><polyline points="6 15 12 9 18 15"></polyline></svg>
                </th>
                <th>Naslov</th>
                <th>Slug</th>
                <th>Akcija</th>
                <th></th>
            </tr>
        </template>
        <template #tbody>
            <tr v-for="(page, index) in pages.data" :key="index">
                <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select page"></td>
                <td><span class="text-muted">{{ page.id }}</span></td>
                <td class="td-truncate">
                    <div class="text-truncate">{{ $page.title }}</div>
                </td>
                <td>{{ page.slug }}</td>
                <td class="uk-text-right">
                    <Link title="Pogledaj" :href="route('page.show', page.slug)" class="uk-icon uk-button-default uk-icon-button">
                        <img src="/icons/saved.svg" alt="pogledaj" uk-svg>
                    </Link>
                    <Link title="Izmeni" :href="route('admin.page.edit', page.slug)" class="uk-margin-small-left uk-icon uk-button-default uk-icon-button">
                        <img src="/icons/pencil.svg" alt="edit" uk-svg>
                    </Link>
                    <Link title="Obriši" as="button" method="DELETE" :href="route('admin.page.delete', page.slug)" class="uk-margin-small-left uk-icon uk-button-danger uk-icon-button">
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
import ShowForm from "@/Shared/Admin/Form.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import {watch} from "vue";
import {Inertia} from "@inertiajs/inertia";

let props = defineProps({
    pages: Object,
    filters: Object,
})

let form = useForm({
    q: props.filters.q || null,
    per_page: props.filters.per_page || 10,
    page: props.filters.page || 1,
})
watch(form, _.throttle(
    (newValue, oldValue) => {
        Inertia.get(route('admin.page.index'), form.data(), { preserveScroll: true, preserveState: true });
    }, 200),
    {deep: true}
)
</script>
