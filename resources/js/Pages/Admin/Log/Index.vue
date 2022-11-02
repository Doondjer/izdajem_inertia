<template>
    <show-form
        class="log-viewer"
        title="Logovi"
        card_title="Trenutna lista logova"
    >
        <table class="uk-table uk-table-striped">
            <thead>
            <tr>
                <th v-for="(name, field) in headers" :key="field" scope="col" :class="field === 'date' ? 'uk-text-left' : 'uk-text-center'">
                    <span v-if="field === 'date'" class="uk-label uk-border-rounded">{{ name }}</span>
                    <span v-else class="uk-label uk-border-rounded" :class="`uk-label-${field}`">{{ name }}</span>
                </th>
                <th scope="col" class="uk-text-right">Akcije</th>
            </tr>
            </thead>
            <tbody v-if="Object.keys(rows).length">
                <tr v-for="(row, index) in rows.data" :key="index">
                    <td v-for="(value,field) in row" :key="field" class="{{ field === 'date' ? 'uk-text-left' : 'uk-text-center' }}">
                        <span v-if="field === 'date'" class="uk-label uk-border-rounded uk-button-danger-outline uk-button uk-disabled">{{ value }}</span>
                        <span v-else-if="value == 0" class="uk-label uk-border-pill">{{ value }}</span>
                        <Link v-else :href="route('admin.log.filter', {date: index, level: field})">
                            <span class="uk-label uk-border-pill uk-button-default" :class="`uk-label-${field}`">{{ value }}</span>
                        </Link>
                    </td>
                    <td class="uk-text-right">
                        <Link title="Pretraži" :href="route('admin.log.show', index)" class="uk-icon uk-button-default uk-icon-button">
                            <img src="/icons/saved.svg" alt="pretrazi" uk-svg>
                        </Link>
                        <a :href="route('admin.log.download', {date: index})" class="uk-margin-small-left uk-icon uk-button-default uk-icon-button">
                            <img src="/icons/download.svg" alt="download" uk-svg>
                        </a>
                        <Link as="button" method="DELETE" :href="route('admin.log.delete', {date: index})" class="uk-margin-small-left uk-icon uk-button-danger uk-icon-button">
                            <img src="/icons/trash.svg" alt="trash" uk-svg>
                        </Link>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="11" class="uk-text-center uk-h3">List logova je prazna!</td>
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
    headers: Object,
    rows: Object,
})

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
</style>
