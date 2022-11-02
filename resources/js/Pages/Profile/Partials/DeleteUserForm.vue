<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import DialogModal from '@/Shared/DialogModal.vue';
import LoadingButton from "@/Shared/LoadingButton.vue";
import TextInput from "@/Shared/TextInput.vue";


const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    setTimeout(() => passwordInput.value.focus(), 250);
};

const deleteUser = () => {
    form.delete(route('current-user.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <div class="uk-card uk-card-small">
        <div class="uk-card-header">
            <h2 class="uk-card-title">Trajno obriši nalog</h2>
        </div>
        <div class="uk-card-body">

            <p>Jednom kada vaš nalog bude obrisan svi vaši oglasi i podaci biće nepovratno izgubljeni. Pre brisanja naloga sačuvajte podatke i informacije koje želite da sačuvate.</p>

            <button class="uk-button uk-button-danger" @click="confirmUserDeletion">
                Obriši nalog
            </button>
        </div>
    </div>

    <dialog-modal :show="confirmingUserDeletion" v-if="confirmingUserDeletion" @close="closeModal">
        <template #title>
            Obriši nalog
        </template>

        <template #content>
            <p class="uk-text-bold">Da li ste sigurni da želite da obrišete vaš nalog?</p>
            <div class="uk-alert uk-alert-warning uk-border-rounded">
                <div class="uk-grid uk-grid-small">
                    <div class="uk-width-auto"><img src="/icons/info.svg" alt="info" uk-svg></div>
                    <div class="uk-width-expand">Jednom kada vaš nalog bude obrisan svi vaši oglasi i podaci biće nepovratno izgubljeni.</div>
                </div>
            </div>
            <p>Molimo vas da unesete vašu lozinku, kako bi potvrdili da želite da trajno obrišete vaš nalog.</p>
            <div class="uk-margin">
                <text-input
                    v-model="form.password"
                    icon="lock"
                    type="password"
                    required
                    :error="form.errors.password"
                    iconPosition="left"
                    autocomplete="current-password"
                    placeholder="Lozinka ..."
                    ref="passwordInput"
                    @keyup.enter="deleteUser"
                />
            </div>
        </template>

        <template #footer>
            <div class="uk-text-right">
                <button class="uk-button uk-button-default uk-button-large " type="button" @click="closeModal">
                    Prekini
                </button>
                <loading-button @click.prevent="deleteUser" class="uk-button-large uk-button-danger uk-margin-small-left"
                                :class="{ 'uk-disabled': form.processing }"
                                :disabled="form.processing"
                >
                    Obriši nalog
                </loading-button>
            </div>

        </template>
    </dialog-modal>
</template>
