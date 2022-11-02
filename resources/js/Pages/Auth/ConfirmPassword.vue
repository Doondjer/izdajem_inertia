<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import LoadingButton from "@/Shared/LoadingButton.vue";
import Card from "@/Shared/Card.vue";
import TextInput from "@/Shared/TextInput.vue";

const form = useForm({
    password: '',
});

const passwordInput = ref(null);

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => {
            form.reset();

            passwordInput.value.focus();
        },
    });
};
</script>

<template>
    <Head title="Sigurna Zona" />

    <div class="uk-position-center">
        <card
            title="Sigurna Zona na Izdajem.rs"
            class="uk-width-large"
        >
            <template #body>
                <form @submit.prevent="submit">

                    <div class="uk-margin">
                        <text-input
                            ref="passwordInput"
                            v-model="form.password"
                            icon="lock"
                            label="Lozinka"
                            type="password"
                            required
                            :error="form.errors.password"
                            iconPosition="left"
                            autocomplete="current-password"
                            placeholder="Lozinka ..."
                            autofocus
                        />
                    </div>
                    <loading-button class="uk-button-large uk-button-danger uk-width-1-1"
                                    :class="{ 'uk-disabled': form.processing }"
                                    :disabled="form.processing"
                    >
                        Potvrdite Lozinku
                    </loading-button>
                </form>
            </template>

            <template #footer_info>
               Ovo je sigurnosna zona na Izdajem.rs. Potvrdite vašu lozinku pre nego što nastavite.
            </template>
        </card>
    </div>
</template>
