<script setup>

import DeleteUserForm from '@/Pages/Profile/Partials/DeleteUserForm.vue';
import LogoutOtherBrowserSessionsForm from '@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue';
import TwoFactorAuthenticationForm from '@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue';
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue';
import BaseFooter from "@/Shared/Footer.vue";
import {useForm} from "@inertiajs/inertia-vue3";

let props = defineProps({
    member: Object,
});
</script>

<script>
import AdminLayout from "@/Layouts/Admin/AppLayout.vue";
export default {
    layout: AdminLayout
}
</script>

<template>

    <div class="uk-section-small uk-section-default">
        <div class="uk-container uk-container-xsmall">

            <UpdateProfileInformationForm
                :user="$page.props.member"
                :update_route="route('admin.user.update',props.member.id)"
                :image_delete_route="route('admin.user.image.delete', props.member.id)"
            />

        </div>
    </div>

    <hr class="uk-hr uk-margin-remove" />

    <base-footer />
</template>
