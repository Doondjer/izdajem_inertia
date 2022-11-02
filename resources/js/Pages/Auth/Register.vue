<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import LoadingButton from "@/Shared/LoadingButton.vue";
import Card from "@/Shared/Card.vue";
import TextInput from "@/Shared/TextInput.vue";
import Checkbox from "@/Shared/Checkbox.vue";

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Registracija" />
    <div class="uk-position-center">
        <card
            title="Registracija na Izdajem.rs"
            class="uk-width-large uk-text"
        >
            <template #body>
                <form @submit.prevent="submit">
                    <div class="uk-margin">
                        <text-input
                            v-model="form.name"
                            icon="user"
                            label="Ime i Prezime"
                            type="text"
                            required
                            autofocus
                            :error="form.errors.name"
                            autocomplete="name"
                            placeholder="Ime i Prezime ..."
                        />
                    </div>

                    <div class="uk-margin">
                        <text-input
                            v-model="form.email"
                            icon="mail"
                            label="Email"
                            type="email"
                            required
                            :error="form.errors.email"
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
                            autocomplete="new-password"
                            placeholder="Lozinka ..."
                        />
                    </div>

                    <div class="uk-margin">
                        <text-input
                            v-model="form.password_confirmation"
                            icon="lock"
                            label="Potvrdi Lozinku"
                            type="password"
                            required
                            :error="form.errors.password_confirmation"
                            autocomplete="new-password"
                            placeholder="Potvrdi Lozinku ..."
                        />
                    </div>

                    <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="uk-margin">
                        <checkbox v-model:checked="form.terms" name="terms">Slažem se sa uslovima korišćenja.</checkbox>
                    </div>

                    <loading-button class="uk-button-large uk-button-danger uk-width-1-1"
                                    :class="{ 'uk-disabled': form.processing }"
                                    :disabled="form.processing"
                    >
                        Registruj se
                    </loading-button>
                </form>
            </template>

            <template #footer>
                <div class="uk-align-center">
                    Već ste registrovani? <Link class="uk-text-bold" :href="route('login')">Prijavite se</Link>
                </div>
            </template>

        </card>
    </div>
</template>
