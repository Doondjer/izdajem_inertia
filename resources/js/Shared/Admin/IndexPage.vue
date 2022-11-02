<template>
    <show-form
        :title="title"
    >
        <template #right_header>
            <slot name="right_header" />
        </template>

        <template #card_header>
            <div class="uk-card-header uk-grid uk-grid-small" uk-grid>
                    <div class="uk-width-auto">
                        Prikaži
                        <div class="mx-2 d-inline-block">
                            <input type="text" class="uk-input" name="per_page" size="3" aria-label="Items per page" :value="per_page" @input="$emit('update:per_page', $event.target.value)">
                        </div>
                    </div>
                    <div class="uk-width-xmedium" v-if="trashed_filter">
                        Obrisano:
                             <select class="uk-select" name="trashed" :value="trashed" @change="$emit('update:trashed', $event.target.value)">
                                 <option value="">Bez Obrisanih Stavki</option>
                                 <option value="with">Sa Obrisanim Stavkama</option>
                                 <option value="only">Samo Obrisane Stavke</option>
                             </select>
                    </div>
                    <div class="uk-width-expand">
                        Pretraži:
                        <div class="ms-2 d-inline-block input-icon">
                            <input type="text" class="uk-input" name="q" aria-label="Search items" :value="q" @input="$emit('update:q', $event.target.value)">
                        </div>
                    </div>
            </div>
        </template>

        <table class="uk-table uk-table-striped">
            <thead>
                <slot name="thead"/>
            </thead>
            <tbody>
            <slot name="tbody">
                <tr>
                    <td colspan="100%">
                        <div class="uk-text-bold uk-text-center">Nema pronadjenih stavki!</div>
                    </td>
                </tr>
            </slot>
            </tbody>
        </table>
        <div class="uk-padding-remove-top" v-if="dataSet.last_page > 1">
            <pagination :dataSet="dataSet" v-model:page="page" class="uk-flex-right"></pagination>
        </div>
    </show-form>
</template>

<script setup>
    import ShowForm from "@/Shared/Admin/Form.vue";
    import Pagination from "@/Shared/Pagination.vue";

    defineProps({
        title: String,
        trashed_filter: {
            type: Boolean,
            default: false
        },
        q: {
            type: String,
            default: null
        },
        dataSet: {
            type: Object,
            default: {}
        },
        page: {
            type: [String, Number],
            default: 1
        },
        per_page: {
            type: [String, Number],
            default: 10
        },
        trashed: {
            type: String,
            default: ''
        },
    })
    defineEmits([
        'update:page',
        'update:per_page',
        'update:q',
        'update:trashed',
    ]);
</script>
