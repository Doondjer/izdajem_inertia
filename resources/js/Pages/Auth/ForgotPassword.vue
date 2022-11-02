<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import LoadingButton from "@/Shared/LoadingButton.vue";
import Card from "@/Shared/Card.vue";
import TextInput from "@/Shared/TextInput.vue";

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'), {
        onSuccess: () => {
            form.reset()
        }
    });
};
</script>

<template>
    <Head title="Zaboravljena lozinka" />

    <div class="uk-position-center">
        <card
            title="Zaboravljena lozinka"
            class="uk-width-large"
        >
            <template #body>
                <form @submit.prevent="submit">

                    <div class="uk-margin">
                        <text-input
                            v-model="form.email"
                            icon="mail"
                            label="Email"
                            type="email"
                            required
                            autofocus
                            :error="form.errors.email"
                            iconPosition="left"
                            autocomplete="email"
                            placeholder="Email ..."
                        />
                        <p class="uk-alert uk-alert-success uk-text-center uk-border-rounded-xl" v-if="status">{{ status }}</p>
                    </div>
                    <loading-button class="uk-button-large uk-button-danger uk-width-1-1"
                                    :class="{ 'uk-disabled': form.processing }"
                                    :disabled="form.processing"
                    >
                        Pošalji link za reset lozinke
                    </loading-button>
                </form>
            </template>
            <template #footer_info>
                Zaboravili ste lozinku? Bez Brige. Samo unesite vašu email adresu i mi ćemo vam poslati link da odaberete novu.
            </template>
        </card>
    </div>
</template>
