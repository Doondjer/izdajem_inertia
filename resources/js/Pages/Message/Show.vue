<template>

    <Head :title="`Konverzacija #${t.id}`" />

    <div class="uk-section uk-section-small" uk-height-viewport="expand: true">
        <div class="uk-container">
            <div class="uk-grid uk-grid-collapse">
                <h1 class="uk-h2 uk-width-expand">Konverzacija #{{ t.id }}</h1>
            </div>
        </div>
        <div class="uk-container uk-margin uk-padding-remove-horizontal">
            <card class="uk-border-rounded-xl">
                <template #body>

                    <div class="uk-form-row uk-double-border uk-form-row-modified">
                        <h2 class="uk-text-center">{{ t.subject }}</h2>
                    </div>

                    <div class="uk-form-row">
                        <message-article v-for="(message, index) in t.messages" :message=message :key="index" />
                    </div>

                    <div class="uk-form-row uk-margin">
                        <textarea-input
                            v-model="form.message"
                            required
                            :error="form.errors.message"
                            placeholder="Unesite tekst poruke ..."
                            cols="30"
                            rows="7"
                        />
                    </div>

                    <div class="uk-form-row uk-margin-small">
                        <loading-button class="uk-button-large uk-button-danger uk-width-1-1"
                                        :class="{ 'uk-disabled': form.processing }"
                                        :disabled="form.processing"
                                        @click.prevent="submit"
                        >
                            Pošaljite
                        </loading-button>
                    </div>
                </template>
            </card>
        </div>
    </div>
    <base-footer />
</template>

<script setup>

    import {useForm} from "@inertiajs/inertia-vue3";
    import Card from "@/Shared/Card.vue";
    import TextareaInput from "@/Shared/TextareaInput.vue";
    import LoadingButton from "@/Shared/LoadingButton.vue";
    import MessageArticle from "@/Shared/MessageArticle.vue";
    import BaseFooter from "@/Shared/Footer.vue";
    import {computed, onMounted } from "vue";
    import {Inertia} from "@inertiajs/inertia";

    let props = defineProps({
        thread: Object,
        user: Object,
    });

    let form = useForm({
        message: null,
    })

    let t = computed(() => {
        return props.thread.data;
    })

    let submit = () => {
        form.patch(route('message.update', props.thread.data.id), {
            onSuccess: () => form.reset(),
            preserveScroll: true
        });
    }

    let reloadT = () => {
            Inertia.reload({only: ['thread']})
    }

    onMounted(() => {
        if(props.user) {
            window.Echo.private(`messages.${props.user.id}`).listen('MessageReceived', reloadT);
            window.Echo.private(`messages.${props.user.id}`).listen('ThreadsDeleted', e => {
                if(e.threads.includes(props.thread.data.id)) {
                    Inertia.visit(route('message.index'));
                }
            });
        }
    })

</script>

