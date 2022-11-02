<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import LoadingButton from "@/Shared/LoadingButton.vue";
import Card from "@/Shared/Card.vue";
import TextInput from "@/Shared/TextInput.vue";

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Resetovanje lozinke" />

    <div class="uk-position-center">
        <card
            title="Resetovanje lozinke za Izdajem.rs"
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
                    </div>

                    <div class="uk-margin">
                        <text-input
                            v-model="form.password"
                            icon="lock"
                            label="Lozinka"
                            type="password"
                            required
                            :error="form.errors.password"
                            iconPosition="left"
                            autocomplete="new-password"
                            placeholder="Lozinka ..."
                        />
                    </div>

                    <div class="uk-margin">
                        <text-input
                            v-model="form.password_confirmation"
                            icon="lock-check"
                            label="Potvrdi Lozinku"
                            type="password"
                            required
                            :error="form.errors.password_confirmation"
                            iconPosition="left"
                            autocomplete="new-password"
                            placeholder="Potvrdi Lozinku ..."
                        />
                    </div>

                    <loading-button class="uk-button-large uk-button-danger uk-width-1-1"
                                    :class="{ 'uk-disabled': form.processing }"
                                    :disabled="form.processing"
                    >
                        Resetuj Lozinku
                    </loading-button>
                </form>
            </template>
        </card>
    </div>
</template>
