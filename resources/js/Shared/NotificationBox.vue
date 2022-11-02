<template>
    <div @click="$emit('close')" class="uk-navbar-dropdown uk-navbar-dropdown-dropbar uk-open" uk-dropdown="">
        <div class="uk-card uk-card-default uk-card-small hr-split uk-border-rounded-xl uk-navbar-dropdown-nav uk-width-medium">
            <div class="uk-padding-small">
                <h5 class="uk-text-small uk-text-bold uk-margin-remove">Konverzacije</h5><div v-if="loading" class="uk-position-center uk-text-danger" uk-spinner="ratio: 3"></div>
            </div>
            <div class="uk-card-body uk-padding-remove uk-overflow-auto" style="height: 400px; max-height: 500px">
                <p class="uk-flex uk-position-center" v-if="!loading && !Object.keys(threads).length">Nema novih konverzacija!</p>
                <p class="uk-flex uk-position-center" v-if="!loading && !Object.keys(threads).length">Klikni <Link class="uk-text-bold uk-margin-small-left uk-margin-small-right" :href="route('message.index')">OVDE</Link> da pogledaš već pročitane. </p>
                <div v-else v-for="thread in threads" :key="thread.id">
                    <Link :href="route('message.show', thread.id)" class="uk-grid-collapse" uk-grid>
                        <div class="uk-width-auto">
                            <img :src="`${$page.props.config.image_base_route}/32x32/${thread.messages[0].profile_image}`" :alt="thread.messages[0].author" uk-img>
                        </div>
                        <div class="uk-margin-small-left uk-width-expand">
                            <div>
                                <Link v-if="thread.listing_slug" class="uk-text-bold uk-text-small" :href="route('listing.show', thread.listing_slug)">{{ thread.subject }}</Link>
                                <span class="uk-text-bold uk-text-small uk-text-secondary">{{ thread.subject }}</span>
                            </div>
                            <div class="uk-grid uk-grid-small uk-grid-divider uk-text-meta"><span>Od: {{ thread.messages[0].author }}</span><span>{{ thread.messages[0].created_human }}</span></div>
                            <p class="uk-text-muted">{{ thread.messages[0].body_truncated }}</p>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, reactive, ref} from "vue";
    let threads = reactive([]);
    let loading = ref(true);
    let props = defineProps({
        user: Object
    })
    let removeThread = (thread) => {
        let i = threads.findIndex(t => t.id === thread);

        if(i !== -1) {
           threads.splice(i, 1);
        }
    }

    let pushThread = (thread) => {
        let index = threads.findIndex(t => t.id === thread.id);

        if(index !== -1) {
            threads.splice(index, 1);
        }

            threads.splice(0, 0, thread);
    }

    onMounted(() => {
        axios.get(route('message.unread'))
            .then(({data}) => {
                Object.assign(threads, data.threads);
                loading.value = false;
            });
        if (typeof window !== 'undefined') {
            window.Echo.private(`messages.${props.user.id}`).listen('MessageShown', e => {
                removeThread(e.thread);
            });

            window && window.Echo.private(`messages.${props.user.id}`).listen('ThreadsDeleted', e => {
                e.threads.forEach(thread => removeThread(thread));
            });

            window && window.Echo.private(`messages.${props.user.id}`).listen('MessageReceived', e => {
                pushThread(e.thread);
            });
        }

    })



</script>
