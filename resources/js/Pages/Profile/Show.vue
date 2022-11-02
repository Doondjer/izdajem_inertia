<script setup>

import DeleteUserForm from '@/Pages/Profile/Partials/DeleteUserForm.vue';
import LogoutOtherBrowserSessionsForm from '@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue';
import TwoFactorAuthenticationForm from '@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue';
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue';
import BaseFooter from "@/Shared/Footer.vue";
import {useForm} from "@inertiajs/inertia-vue3";

let props = defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
    user: Object,
    is_sms: Boolean
});

let form = useForm({
    _method: 'PUT',
    name: props.user.fullname,
    email: props.user.email,
    photo: null,
})
</script>

<template>

    <Head title="Podešavanje profila" />

    <div class="uk-section-small uk-section-default">
        <div class="uk-container uk-container-xsmall">

            <UpdateProfileInformationForm :user="$page.props.user" :is_sms="props.is_sms" />

            <hr class="uk-hr">

            <UpdatePasswordForm v-if="$page.props.jetstream.canUpdatePassword" />

            <hr class="uk-hr">

<!--            <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
                <TwoFactorAuthenticationForm
                    :requires-confirmation="confirmsTwoFactorAuthentication"
                    class="mt-10 sm:mt-0"
                />

                <JetSectionBorder />
            </div>

            <hr class="uk-hr">-->

            <LogoutOtherBrowserSessionsForm :sessions="sessions" />

            <hr class="uk-hr">

            <DeleteUserForm />

        </div>
    </div>

    <hr class="uk-hr uk-margin-remove" />

    <base-footer />
</template>
