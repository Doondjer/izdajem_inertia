<template>
    <show-form
        class="log-viewer"
        title="Log fajl"

    >
        <template #breadcrumb>
            <div><Link :href="route('admin.log.index')">Logovi</Link></div>
        </template>

        <template #card_header>
            <div class="uk-card-header">
                <div class="uk-grid-uk-grid-small uk-margin" uk-grid>
                    <div class="uk-width-expand uk-text-bold">
                        Putanja: {{ log.path }}
                    </div>
                    <div class="uk-width-auto">
                        <a :href="route('admin.log.download', log.date)" class="uk-button uk-button-small uk-button-success">
                            <img src="/icons/download.svg" alt="download" uk-svg>
                            <span class="uk-text-middle">Download</span>
                        </a>
                        <Link as="button" :href="route('admin.log.delete', log.date)" method="DELETE" class="uk-button uk-button-small uk-button-danger">
                            <img src="/icons/trash.svg" alt="delete" uk-svg>
                            <span class="uk-text-middle">Delete</span>
                        </Link>
                    </div>
                </div>
                <input type="text" v-model="form.query" name="search" class="uk-input uk-margin-small-bottom" placeholder="Pretrazi...">
                <div class="uk-grid uk-grid-small uk-text-meta" uk-grid>
                    <div>
                        <span class="">Prikazano</span>
                        <span class="uk-margin-small-left uk-text-bold"> {{ entries.from }}</span>
                    </div>
                    <div>
                        <span class="">do</span>
                        <span class="uk-margin-small-left uk-text-bold"> {{ entries.to }}</span>
                    </div>
                    <div>
                        <span class="">od Ukupno</span>
                        <span class="uk-margin-small-left uk-text-bold"> {{ entries.total }}</span>
                    </div>
                </div>
            </div>
        </template>

        <table class="uk-table uk-table-striped">
            <thead>
            <tr>
                <th>Env</th>
                <th style="width: 120px;">Level</th>
                <th style="width: 65px;">Time</th>
                <th>Header</th>
                <th class="text-right">Actions</th>
            </tr>
            </thead>
            <tbody v-if="Object.keys(entries).length">
                    <tr v-for="(entry, key) in entries.data" :key="key">
                        <td colspan="5">
                            <div class="uk-grid uk-grid-small uk-grid-row-small" uk-grid>
                                <div class="uk-width-auto"><span v-if="entry.env" class="uk-label uk-border-rounded uk-label-env">{{ entry.env }}</span></div>
                                <div class="uk-width-auto"><span class="uk-label uk-border-rounded" :class="`uk-label-${entry.level}`">{{ entry.level }}</span></div>
                                <div class="uk-width-auto"><span class="uk-label uk-button-danger-outline uk-button uk-disabled">{{ entry.datetime }}</span></div>
                                <div class="uk-width-expand">{{ entry.header }}</div>
                                <div>
                                    <a v-if="entry.stack" @click.prevent="show.stack !== null && show.stack === key ? show.stack = null : show.stack = key" class="uk-button uk-label uk-button-danger-outline" role="button" data-toggle="collapse"
                                       :href="`#log-stack-${key}`" aria-expanded="false" :aria-controls="`#log-stack-${key}`">
                                        <img :src="`/icons/chevron-${show.stack === key ? 'up' : 'down'}.svg`" alt="on" uk-svg>
                                        <span class="uk-text-middle"> Stack</span>
                                    </a>
                                    <a v-if="entry.context" @click.prevent="show.context !== null && show.context === key ? show.context = null : show.context = key" class="uk-button uk-label uk-button-danger-outline" role="button" data-toggle="collapse"
                                       :href="`#log-context-${key}`" aria-expanded="false" :aria-controls="`#log-context-${key}`">
                                        <img :src="`/icons/chevron-${show.context === key ? 'up' : 'down'}.svg`" alt="on" uk-svg>
                                        <span class="uk-text-middle"> Context</span>
                                    </a>
                                </div>
                            </div>
                            <div v-if="entry.stack && show.stack === key" class="stack-content text-warning collapse" :id="`#log-stack-${key}`">
                                {{ entry.stack }}
                            </div>

                            <div v-if="entry.context && show.context === key" class="stack-content text-warning collapse" :id="`#log-context-${key}`">
                                <pre>{{ entry.context }}</pre>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                <tr>
                    <td colspan="5" class="uk-text-center uk-h3">List logova je prazna!</td>
                </tr>
            </tbody>
            <div v-if="entries.last_page > 1">
                <pagination :dataSet="entries" v-model:page="form.page" class=""></pagination>
            </div>
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
import {reactive, watch} from "vue";
import {useForm} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";
import Pagination from "@/Shared/Pagination.vue";

let props = defineProps({
    level: String,
    log: Object,
    query: String,
    levels: Object,
    entries: Object,
});

let show = reactive({
    stack: null,
    context: null,
})

let form = useForm({
    query: props.query || null,
    page: 1,
})

watch(form, _.throttle(
        (newValue, oldValue) => {
            Inertia.get(route('admin.log.search', { date: props.log.date, level: props.level}), form.data(), { preserveState: true });
        }, 200)
    ,{deep: true}
);


</script>

<style scoped>
.uk-label-all,
.uk-label-emergency,
.uk-label-alert,
.uk-label-critical,
.uk-label-error,
.uk-label-notice,
.uk-label-info
{
    color: #FFF;
    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
}
.log-viewer .uk-label.uk-label-all,
.log-viewer .card.level-all {
    background-color: #8A8A8A;
}

.log-viewer .uk-label.uk-label-emergency,
.log-viewer .card.level-emergency {
    background-color: #B71C1C;
}

.log-viewer .uk-label.uk-label-alert,
.log-viewer .card.level-alert  {
    background-color: #D32F2F;
}

.log-viewer .uk-label.uk-label-critical,
.log-viewer .card.level-critical {
    background-color: #F44336;
}

.log-viewer .uk-label.uk-label-error,
.log-viewer .card.level-error {
    background-color: #FF5722;
}

.log-viewer .uk-label.uk-label-warning,
.log-viewer .card.level-warning {
    background-color: #FF9100;
}

.log-viewer .uk-label.uk-label-notice,
.log-viewer .card.level-notice {
    background-color: #4CAF50;
}

.log-viewer .uk-label.uk-label-info,
.log-viewer .card.level-info {
    background-color: #1976D2;
}

.log-viewer .uk-label.uk-label-debug,
.log-viewer .card.level-debug {
    background-color: #90CAF9;
}

.log-viewer .uk-label.empty,
.log-viewer .card.card-empty {
    background-color: #D1D1D1;
}

.log-viewer .uk-label.uk-label-env {
    background-color: #6A1B9A;
}

/*
 * Log Entry
 */

.log-viewer .stack-content {
    color: #AE0E0E;
    font-family: consolas, Menlo, Courier, monospace;
    white-space: pre-line;
    font-size: .8rem;
}

#entries {
    overflow-wrap: anywhere;
}
</style>
