<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import LoadingButton from "@/Shared/LoadingButton.vue";
import TextInput from "@/Shared/TextInput.vue";
import ActionMessage from '@/Components/ActionMessage.vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }

            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <div class="uk-card uk-card-small">
        <div class="uk-card-header">
            <h2 class="uk-card-title">Izmeni Lozinku</h2>
        </div>
        <div class="uk-card-body">

            <p>Zbog vaše sigurnosti koristite dugačku lozinku koju je teško pogoditi.</p>

            <div v-if="$page.props.jetstream.canUpdateProfileInformation">

                <div class="uk-margin">
                    <text-input
                        v-model="form.current_password"
                        icon="lock"
                        label="Trenutna Lozinka"
                        type="password"
                        required
                        :error="form.errors.current_password"
                        iconPosition="left"
                        autocomplete="current-password"
                        placeholder="Lozinka ..."
                        ref="currentPasswordInput"
                    />
                </div>

                <div class="uk-margin">
                    <text-input
                        v-model="form.password"
                        icon="lock-plus"
                        label="Nova Lozinka"
                        type="password"
                        required
                        :error="form.errors.password"
                        iconPosition="left"
                        autocomplete="new-password"
                        placeholder="Lozinka ..."
                        ref="passwordInput"
                    />
                </div>

                <div class="uk-margin">
                    <text-input
                        v-model="form.password_confirmation"
                        icon="lock-check"
                        label="Potvrdi novu Lozinku"
                        type="password"
                        required
                        :error="form.errors.password_confirmation"
                        iconPosition="left"
                        autocomplete="new-password"
                        placeholder="Potvrdi Lozinku ..."
                    />
                </div>


                <ActionMessage :on="form.recentlySuccessful">
                    Sačuvano.
                </ActionMessage>

                <loading-button @click.prevent="updatePassword" class="uk-button-large uk-button-danger uk-width-1-1"
                                :class="{ 'uk-disabled': form.processing }"
                                :disabled="form.processing"
                >
                    Sačuvaj
                </loading-button>
            </div>
        </div>
    </div>
<!--    <JetFormSection @submitted="updatePassword">

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="current_password" value="Current Password" />
                <JetInput
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="current-password"
                />
                <JetInputError :message="form.errors.current_password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="password" value="New Password" />
                <JetInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />
                <JetInputError :message="form.errors.password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="password_confirmation" value="Confirm Password" />
                <JetInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />
                <JetInputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>
        </template>

    </JetFormSection>-->
</template>
