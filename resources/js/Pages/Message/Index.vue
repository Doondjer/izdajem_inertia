<template>

    <Head title="Lista konverzacija" />

    <div class="uk-section uk-section-small" uk-height-viewport="expand: true">
        <div class="uk-container">
            <div class="uk-grid uk-grid-collapse">
                <h1 class="uk-h2 uk-width-expand">Konverzacije</h1>
            </div>
        </div>
        <div class="uk-container uk-margin uk-padding-remove-horizontal">
            <card class="uk-border-rounded-xl">
                <template #body>
                    <div class="uk-overflow-auto uk-padding-remove-horizontal">
                        <table class="uk-table uk-table-hover uk-table-middle uk-table-divider">
                            <thead>
                                <tr>
                                    <th class="uk-table-shrink" colspan="2" :class="{'uk-disabled': ! deleteList.length}" @click.prevent="deleteMessages">
                                        <div class="uk-icon uk-text-meta uk-link" :class="{'uk-text-danger': deleteList.length}">
                                            <img src="/icons/trash.svg" width="30" height="30" uk-svg>
                                        </div>
                                    </th>
                                    <th class="uk-table-expand">Konverzacije</th>
                                    <th class="uk-table-shrink uk-text-nowrap uk-visible@s">Vreme</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="thread in threads.data" :key="thread.id" v-if="Object.keys(threads.data).length">
                                    <td class="uk-table-shrink"><input class="uk-checkbox" type="checkbox" :value="thread.id" v-model="deleteList"></td>
                                    <td class="uk-table-shrink">
                                        <span v-for="participant in thread.participants">
                                            <img class="uk-preserve-width uk-border-circle profile-image" width="40" height="40" :data-src="`${$page.props.config.image_base_route}/40x40/${participant.profile_image}`" uk-img :title="participant.name" v-if="! participant.is_current_user">
                                        </span>
                                    </td>
                                    <td class="uk-table-link uk-text-truncate">
                                        <Link :href="route('message.show', thread.id)" :class="{ 'uk-text-muted': thread.participants.find(p => p.is_current_user === true).is_read }">
                                            <dl class="uk-description-list-horizontal">
                                                <dt class="uk-text-truncate" :class="thread.participants.find(p => p.is_current_user === true).is_read ? 'uk-text-normal' : 'uk-text-bold'">
                                                    #<span class="uk-text-muted" v-text="thread.id"></span>: <span v-text="thread.subject"></span>
                                                </dt>
                                                <dd class="uk-text-muted uk-text-truncate" v-text="thread.messages[0].body"></dd>
                                            </dl>
                                        </Link>
                                    </td>
                                    <td class="uk-table-link uk-table-shrink uk-text-nowrap uk-visible@s">
                                        <a class="uk-link-reset" href="#" v-text="thread.messages[0].created_human"></a>
                                    </td>
                                </tr>
                                <tr class="uk-text-center uk-text-bold" v-else>
                                    <td colspan="4">Nema pronadjenih poruka</td></tr>
                            </tbody>
                        </table>
                    </div>
                </template>
            </card>
        </div>
        <div class="uk-container uk-margin-small-top" v-if="threads.meta.last_page > 1">
            <div class="uk-card uk-card-default uk-margin uk-margin-large-bottom uk-border-rounded-xl">

                <pagination :dataSet="threads.meta" v-model:page="form.page" class="uk-margin-small uk-margin-small-top"></pagination>

            </div>
        </div>
    </div>
    <base-footer />
</template>

<script setup>

    import {useForm} from "@inertiajs/inertia-vue3";
    import {onMounted, onUnmounted, reactive, ref} from "vue";
    import Card from "@/Shared/Card.vue";
    import Pagination from "@/Shared/Pagination.vue";
    import BaseFooter from "@/Shared/Footer.vue";
    import {Inertia} from "@inertiajs/inertia";

    let props = defineProps({
        threads: Object,
        user: Object,
    })

    let form = useForm({
        page: 1,
        per_page: 10,
    })

    let deleteList = ref([]);

    let loading = ref(false);

    let deleteMessages = () => {
        Inertia.delete(route('message.delete'), {
            data: {
                id: deleteList.value
            },
            preserveScroll: true,
            onStart: () => loading.value = true,
            onFinish: () => deleteList.value = [],
        })
    }


    let reloadT = () => {
        if (!loading.value){
            Inertia.reload({only: ['threads']})
            loading.value = false;
        }
    }

    onMounted(() => {
        if(props.user) {
            window.Echo.private(`messages.${props.user.id}`).listen('MessageReceived', e => {
                let i = this.threads.data.findIndex(t => t.id === e.thread.id);
                this.threads.data.splice(i, 1);

                this.threads.data.splice(0, 0, e.thread);
            });
            window.Echo.private(`messages.${props.user.id}`).listen('MessageShown', e => {
                let i = props.threads.data.findIndex((t) => t.id === e.thread);
                if(i !== -1) {
                    let j = props.threads.data[i].participants.findIndex(p => p.is_current_user === true);
                    if(j !== -1) {
                        props.threads.data[i].participants[j].is_read = true;
                    }
                }
            });
            window.Echo.private(`messages.${props.user.id}`).listen('ThreadsDeleted', reloadT);
        }
    })
</script>


