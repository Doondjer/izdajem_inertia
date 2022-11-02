<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import LoadingButton from "@/Shared/LoadingButton.vue";
import Card from "@/Shared/Card.vue";
import TextInput from "@/Shared/TextInput.vue";
import Checkbox from "@/Shared/Checkbox.vue";
const PhoneLogin = defineAsyncComponent(() =>  import('@/Shared/PhoneLogin.vue'));
import {defineAsyncComponent, ref} from "vue";
const Alert = defineAsyncComponent(() =>  import('@/Shared/Alert.vue'));

defineProps({
    canResetPassword: Boolean,
    status: String,
});

let show = ref(false);

const form = useForm({
    email: '',
    password: '',
    remember: true,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <alert v-if="status" :message="status"/>

    <div class="uk-position-center">
        <card
            title="Prijavite se na Izdajem.rs"
            class="uk-width-large"
        >
            <template #body>
                <div>
<!--                    <a class="uk-button uk-button-default uk-button-large uk-width-1-1 uk-margin-small-top" href="/social/facebook">
                        <img src="/icons/facebook.svg" class="uk-icon-button" width="21" height="21" alt="facebook" uk-svg><span class="uk-text-middle uk-margin-small-left">Prijava putem Facebook-a</span>
                    </a>-->
                    <a class="uk-button uk-button-default uk-button-large uk-width-1-1 uk-margin-small-top" href="/social/google">
                        <img src="/icons/google.svg" class="uk-icon-button" width="21" height="21" alt="google" uk-svg><span class="uk-text-middle uk-margin-small-left">Prijava putem Googla</span>
                    </a>
                    <button @click.prevent="show = true" class="uk-button uk-button-default uk-button-large uk-width-1-1 uk-margin-small-top">
                        <img src="/icons/mobile.svg" width="21" height="21" alt="mobile" uk-svg><span class="uk-text-middle uk-margin-small-left">Prijava putem Sms-a</span>
                    </button>
                </div>

                <hr class="uk-divider-icon" />

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
                            autocomplete="current-password"
                            placeholder="Lozinka ..."
                        />
                    </div>
                    <div class="uk-margin uk-grid">

                        <checkbox v-model:checked="form.remember" class="uk-width-expand" name="remember">Zapamti me</checkbox>

                        <Link v-if="canResetPassword" :href="route('password.request')" class="uk-width-auto">
                            Zaboravljena lozinka?
                        </Link>
                    </div>
                    <loading-button class="uk-button-large uk-button-danger uk-width-1-1"
                                    :class="{ 'uk-disabled': form.processing }"
                                    :disabled="form.processing"
                    >
                        Log in
                    </loading-button>
                </form>
            </template>

            <template #footer>
                <div class="uk-align-center">
                    Niste Registrovani? <Link class=" uk-text-bold" :href="route('register')">Kreirajte nalog</Link>
                </div>
            </template>

        </card>
    </div>

        <phone-login v-if="show" @close="show = false" />
</template>

