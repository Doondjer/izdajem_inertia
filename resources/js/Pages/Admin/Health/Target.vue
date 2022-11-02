<template>
    <div class="uk-card uk-card-default uk-border-rounded">
        <div class="uk-grid uk-grid-collapse uk-card-header uk-padding-small uk-padding-remove-vertical" uk-grid>
            <div class="uk-width-expand uk-flex uk-flex-middle">{{ resource.name }}</div>
            <div class="uk-width-auto">
                <button @click="showResult()" class="uk-icon uk-icon-button" :class="`uk-text-${colorClass}`">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="27" height="27" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448s448-200.6 448-448S759.4 64 512 64zm0 708c-22.1 0-40-17.9-40-40s17.9-40 40-40s40 17.9 40 40s-17.9 40-40 40zm62.9-219.5a48.3 48.3 0 0 0-30.9 44.8V620c0 4.4-3.6 8-8 8h-48c-4.4 0-8-3.6-8-8v-21.5c0-23.1 6.7-45.9 19.9-64.9c12.9-18.6 30.9-32.8 52.1-40.9c34-13.1 56-41.6 56-72.7c0-44.1-43.1-80-96-80s-96 35.9-96 80v7.6c0 4.4-3.6 8-8 8h-48c-4.4 0-8-3.6-8-8V420c0-39.3 17.2-76 48.4-103.3C430.4 290.4 470 276 512 276s81.6 14.5 111.6 40.7C654.8 344 672 380.7 672 420c0 57.8-38.1 109.8-97.1 132.5z" fill="currentColor"/></svg>
                </button>
                <span @click="$emit('check-resource')" :class="colorClass">
                    <span class="uk-icon uk-icon-button" :class="`uk-text-${colorClass}`" v-if="!resource.loading && target.result && target.result.healthy">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="27" height="27" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M699 353h-46.9c-10.2 0-19.9 4.9-25.9 13.3L469 584.3l-71.2-98.8c-6-8.3-15.6-13.3-25.9-13.3H325c-6.5 0-10.3 7.4-6.5 12.7l124.6 172.8a31.8 31.8 0 0 0 51.7 0l210.6-292c3.9-5.3.1-12.7-6.4-12.7z" fill="currentColor"/><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448s448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372s372 166.6 372 372s-166.6 372-372 372z" fill="currentColor"/></svg>
                    </span>

                    <span class="uk-icon uk-icon-button" :class="`uk-text-${colorClass}`" v-if="!resource.loading && target.result && !target.result.healthy">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="27" height="27" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10s10-4.47 10-10S17.53 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8s8 3.59 8 8s-3.59 8-8 8zm3.59-13L12 10.59L8.41 7L7 8.41L10.59 12L7 15.59L8.41 17L12 13.41L15.59 17L17 15.59L13.41 12L17 8.41z" fill="currentColor"/></svg>
                    </span>

                    <span class="uk-icon uk-icon-button" :class="`uk-text-${colorClass}`" uk-spinner v-if="!target.result || resource.loading"></span>
                </span>
            </div>
        </div>
        <div class="">
            <target-chart
                :height="config.database.graphs.height"
                :name="resource.name"
                :chart-data="chartData"
                :labels="graphLabels"
                :data="graphData"
                :backgrounds="graphBackgrounds"
                v-on:bar-clicked="barClicked"
            >
            </target-chart>
        </div>
        <modal :show="true" :closeable="false" v-if="Object.keys(message).length">
            <div class="uk-card-body uk-text-center">
                <h3 class="uk-h2">{{ message.name }}</h3>
                <p>{{ message.content }}</p>

            </div>

            <template #footer>
                <div class="uk-text-center">
                    <button class="uk-button uk-button-danger" @click="message={}">Ok</button>
                </div>
            </template>
        </modal>
    </div>


</template>
<script setup>
    import TargetChart from "./Chart.vue";
    import Modal from "@/Shared/Modal.vue"
</script>
<script>

//

export default {
    props: ['resource', 'target', 'config'],
    data() {
        return {
            message: {},
        }
    },
    computed: {
        colorClass() {
            return !this.target.result
                ? 'neutral'
                : this.target.result.healthy
                    ? 'success'
                    : 'danger'
        },

        colorClassBackground() {
            return this.colorClass + '-background'
        },

        graphLabels() {
            let labels = []

            _.forEach(this.target.checks, function(check) {
                labels.push(
                    check.value_human
                        ? check.value_human
                        : check.target_display,
                )
            })

            return labels
        },

        graphData() {
            let data = []

            _.forEach(this.target.checks, function(check) {
                data.push(check.value ? check.value : check.runtime)
            })

            return data
        },

        graphBackgrounds() {
            let colors = []

            _.forEach(this.target.checks, function(check) {
                colors.push(check.healthy ? '#8cca82' : '#FF7C74')
            })

            return colors
        },

        chartData() {
            if (!this.graphsAreEnabled()) {
                return this.emptyGraphData()
            }

            return this.generateGraphData()
        },
    },

    methods: {
        barClicked(activeElement) {
            const check = this.target.checks[activeElement[0]._index]

            this.showResultAlert(
                check.resource_name,
                check.error_message,
                check.healthy,
            )
        },

        generateGraphData() {
            return {
                labels: this.graphLabels,
                datasets: [
                    {
                        backgroundColor: this.graphBackgrounds,
                        data: this.graphData,
                    },
                ],
            }
        },

        graphsAreEnabled() {
            return (
                this.config.database.enabled &&
                (this.config.database.graphs.enabled ||
                    this.config.database.graphs.enabled !==
                    this.resource.graphEnabled)
            )
        },

        emptyGraphData() {
            return {
                labels: [],
                datasets: [
                    {
                        backgroundColor: [],
                        data: [],
                    },
                ],
            }
        },

        showResult() {
            this.showResultAlert(
                this.resource.name,
                this.target.result.errorMessage,
                this.target.result.healthy,
            )
        },

        showResultAlert(name, message, healthy) {
            message = !healthy ? message : this.config.alert.success.message

            const type = !healthy
                ? this.config.alert.error.type
                : this.config.alert.success.type

            Object.assign(this.message,{
                name: name,
                content: message,
                type: type
            })
        },
    },
}
</script>
