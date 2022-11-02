<template>
    <div class="spy uk-container">
        <card
            class="hr-split uk-position-relative uk-border-rounded-xl"
            title="Pošaljite nam poruku"

        >
            <template #body>
                    <div class="uk-padding-small" v-if="!$page.props.user">
                        <text-input
                            v-model="form.email"
                            class="uk-width-1-2@s "
                            icon="mail"
                            label="Email"
                            type="email"
                            required
                            :error="form.errors.email"
                            autocomplete="email"
                            placeholder="Unesite vašu email adresu ..."
                            :showLabel="true"
                            iconPosition="left"
                        />
                    </div>

                    <div class="uk-padding-small">
                        <text-input
                            v-model="form.subject"
                            icon="pencil"
                            label="Naslov"
                            required
                            :error="form.errors.subject"
                            placeholder="Unesite naslov poruke ..."
                            :showLabel="true"
                            iconPosition="left"
                        />
                    </div>

                    <div class="uk-padding-small">
                        <textarea-input
                            v-model="form.message"
                            label="Tekst poruke"
                            required
                            :error="form.errors.message"
                            placeholder="Unesite tekst poruke ..."
                            :showLabel="true"
                            cols="30"
                            rows="7"
                        />
                    </div>

                    <div class="uk-padding-small">
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
</template>

<script setup>
    import { useForm } from "@inertiajs/inertia-vue3";
    import Card from "@/Shared/Card.vue";
    import TextInput from "@/Shared/TextInput.vue";
    import TextareaInput from "@/Shared/TextareaInput.vue";
    import LoadingButton from "@/Shared/LoadingButton.vue";

    const form = useForm({
        subject: null,
        message: null,
        email: null,
    })
    const submit = () => {
        form.post(route('home.contact'), {
            onFinish: () => {
                form.subject = null;
                form.message = null;
                form.email = null;
            },
            preserveScroll: true
        });
    };
</script>

<style scoped>

</style>
