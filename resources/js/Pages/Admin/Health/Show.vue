<template>
    <div class="uk-section uk-section-small">
        <div class="uk-container uk-margin">
            <div class="uk-grid uk-grid-collapse">
                <h1 class="uk-h2 uk-margin uk-width-expand uk-text-center uk-text-left@l">{{ health.title }}</h1>
                <div class="uk-width-auto@l uk-width-1-1 uk-text-center">
                    <div class="uk-button-group uk-margin-bottom">
                        <button @click="filterType = 'all'" :class="'uk-button uk-button-small'+selectedFilterButtonClass('all')">
                            Svi ({{ allCount }})
                        </button>

                        <button @click="filterType = 'failing'" :class="'uk-button uk-button-small'+selectedFilterButtonClass('failing')">
                            failing ({{ failingCount }})
                        </button>

                        <button @click="filterType = 'healthy'" :class="'uk-button uk-button-small'+selectedFilterButtonClass('healthy')">
                            healthy ({{ healthyCount }})
                        </button>

                        <button @click="refreshAll()" class="uk-button uk-button-small uk-button-primary" :class="{'uk-overlay-default uk-text-muted': isLoading}">
                            <span v-if="isLoading" class="uk-text-danger uk-position-absolute" role="status" uk-spinner></span>
                            Osveži Sve
                        </button>
                    </div>
                </div>
            </div>
            <div class="uk-margin-small-bottom">

                <text-input
                    v-model="filterString"
                    icon="filter"
                    type="text"
                    placeholder="Filter ..."
                />
            </div>
        </div>
        <div class="uk-container uk-container-xlarge">
            <div class="uk-grid-uk-grid-small" uk-grid>
                <template v-for="resource in resources">
                <div class="uk-width-1-4@xl uk-width-1-3@l uk-width-1-2@m" v-for="target in filter(resource.targets)">
                    <resource-target
                        class="uk-border-rounded-xl"

                        :key="target.id"
                        :target="target"
                        :resource="resource"
                        :config="health"
                        v-on:check-resource="checkResource(resource)"
                        v-on:show-result="showResult(resource, target)"
                    >
                    </resource-target>

                </div>
                </template>
            </div>
        </div>
    </div>
</template>
<script setup>
    import ResourceTarget from "./Target.vue";
    import TextInput from "@/Shared/TextInput.vue";
</script>
<script>
import AdminLayout from "@/Layouts/Admin/AppLayout.vue";


export default {
    layout: AdminLayout,
    props: ['health','initial_resources'],

    data() {
        return {
            filterType: 'all',
            filterString: '',
            resources: {},
        }
    },

    methods: {
        refreshAll() {
            _.map(this.resources, this.checkResource)
        },

        applyFilter: function(targets) {
            if (!this.filterString) {
                return targets
            }

            const $this = this

            return _.filter(targets, target => {
                return (
                    RegExp($this.filterString, 'i').test(target.name) ||
                    RegExp($this.filterString, 'i').test(target.resource.name)
                )
            })
        },

        filter(targets) {
            let $this = this

            return this.applyFilter(
                _.filter(targets, function(target) {
                    return (
                        !target.result ||
                        $this.filterType == 'all' ||
                        ($this.filterType == 'healthy' &&
                            target.result.healthy) ||
                        ($this.filterType == 'failing' &&
                            !target.result.healthy)
                    )
                }),
            )
        },

        checkResource(resource) {
            if (!resource || resource.loading) {
                return
            }

            resource.loading = true;

            axios
                .get(route('pragmarx.health.resources.get', {slug: resource.slug}) + '?flush=1')
                .then(function(response) {
                    resource.targets = response.data.targets

                    resource.loading = false
                })
        },

        selectedFilterButtonClass(button) {
            if (this.filterType == button) {
                return ' uk-button-danger'
            }

            return ' uk-button-danger-outline'
        },

        getAllTargets(type) {
            let targets = []

            const $this = this

            _.each(this.resources, function(resource) {
                _.each($this.applyFilter(resource.targets), function(target) {
                    if (
                        type == 'all' ||
                        (type == 'failing' &&
                            target.result &&
                            !target.result.healthy) ||
                        (type == 'healthy' &&
                            target.result &&
                            target.result.healthy)
                    ) {
                        targets.push(target)
                    }
                })
            })

            return targets
        },
    },


    mounted() {
        Object.assign(this.resources, this.initial_resources);
        this.refreshAll()
    },
    computed: {
        allCount() {
            return this.getAllTargets('all').length
        },

        failingCount() {
            return this.getAllTargets('failing').length
        },

        healthyCount() {
            return this.getAllTargets('healthy').length
        },

        isLoading() {
            return _.reduce(
                this.resources,
                function(current, resource) {
                    return current || resource.loading
                },
                false,
            )
        },
    },

}
</script>

<style>
.btn-result {
    margin: 0 4px 0 0 !important;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(359deg);
    }
}
.spin-svg {
    animation: spin 2s linear infinite;
}
</style>
