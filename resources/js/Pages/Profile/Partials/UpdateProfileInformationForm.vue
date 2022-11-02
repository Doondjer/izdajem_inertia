<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Link, useForm } from '@inertiajs/inertia-vue3';

import LoadingButton from "@/Shared/LoadingButton.vue";
import TextInput from "@/Shared/TextInput.vue";
import Notice from "@/Shared/Notice.vue";
import ActionMessage from '@/Components/ActionMessage.vue';

const props = defineProps({
    user: Object,
    update_route: {
        type: String,
        default: route('user-profile-information.update')
    },
    image_delete_route: {
        type: String,
        default: route('current-user-photo.destroy')
    },
    is_sms: Boolean
});

const form = useForm({
    _method: 'PUT',
    name: props.user.fullname,
    email: props.user.email,
    phone: props.user.phone,
    photo: null,
});

const verify = useForm({
    code: null,
    phone: props.user.phone
})

const verifyPhone = () => {
    verify.post(route('phone.verify'), {
        onSuccess: () => {
            window.scrollTo(0,0);
            verify.code = null;
        },
        preserveScroll: true
    })
}

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }

    form.post(props.update_route, {
        errorBag: 'updateProfileInformation',
        preserveScroll: true,
        onSuccess: () => {
            clearPhotoFileInput();
            clearPreview()
        },
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (! photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const deletePhoto = () => {
    Inertia.delete(props.image_delete_route, {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            clearPhotoFileInput();
        },
    });
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};
const clearPreview = () => {
    photoPreview.value = null;
};
</script>

<template>
    <div class="uk-card uk-card-small">
        <div class="uk-card-header">
            <h1 class="uk-card-title">Vaš Profil</h1>
        </div>
        <div class="uk-card-body">
            <p> Izmenite informacije profila ili vašu email adresu. </p>
            <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                <!-- Profile Photo -->
                <div v-if="$page.props.jetstream.managesProfilePhotos" class="uk-margin">
                    <!-- Profile Photo File Input -->
                    <input
                        ref="photoInput"
                        type="file"
                        class="uk-hidden"
                        @change="updatePhotoPreview"
                    >
                    <label for="photo" class="uk-text-small uk-text-bold">Slika za vaš profil</label>
                    <a v-show="! photoPreview && ! user.is_photo" href="#" @click.prevent="selectNewPhoto">
                        <div class="uk-placeholder uk-text-center uk-width-small uk-border-rounded-xl">
                            <span class="uk-text-middle uk-text-muted">Odaberite vašu novu fotografiju klikom </span>
                            <div class="uk-form-custom">
                                <span class="uk-link">OVDE</span>
                            </div>
                        </div>
                    </a>
                    <!-- Current Profile Photo -->
                    <div v-if="user.is_photo" class="uk-width-small uk-border-rounded-xl">
                        <div class="uk-inline">
                            <img :src="`${$page.props.config.image_base_route}/200/${user.profile_image}`" :alt="user.name" class="uk-border-rounded-xl">
                            <div class="uk-position-top-right">
                                <Link as="button" class="uk-button-link uk-button"  @click.prevent="deletePhoto">
                                    <img src="/icons/trash.svg" alt="Obriši" class="uk-icon-button uk-link uk-button-default" uk-svg>
                                </Link>
                            </div>
                        </div>
                    </div><!---->
                    <!-- New Profile Photo Preview -->
                    <div v-if="photoPreview" class="uk-width-small uk-border-rounded-xl">
                        <div class="uk-inline">
                             <span
                                 class="uk-border-rounded-xl uk-display-block uk-width-small uk-background-cover" style="min-height: 200px;"
                                 :style="'background-image: url(\'' + photoPreview + '\');'"
                             />
                            <div class="uk-position-top-right">
                                <Link as="button" class="uk-button-link uk-button"  @click.prevent="clearPreview">
                                    <img src="/icons/close-large.svg" alt="Obriši" class="uk-icon-button uk-link uk-button-default" uk-svg>
                                </Link>
                            </div>
                        </div>
                    </div>
                    <div class="uk-text-danger uk-text-left" v-if="form.errors.photo">{{ form.errors.photo }}</div>
                </div>

                <div class="uk-margin">
                    <text-input
                        v-model="form.name"
                        icon="account-edit"
                        label="Ime i Prezime"
                        required
                        :error="form.errors.name"
                        autocomplete="name"
                        placeholder="Ime i Prezime ..."
                    />
                </div>
                <div class="uk-margin">
                    <text-input
                        v-model="form.phone"
                        icon="phone"
                        label="Br Telefona"
                        :error="form.errors.phone"
                        autocomplete="phone"
                        placeholder="Br Mobilnog telefona ..."
                    />
                    <div class="uk-margin" v-if="is_sms">

                        <label for="code_input" class="uk-text-small uk-text-bold uk-width-1-1 uk-display-block">Sms kod za verifikaciju</label>
                        <div class="uk-form-custom uk-margin-small-right">
                            <text-input
                                id="code_input"
                                class="uk-form-width-medium"
                                v-model="verify.code"
                                icon="phone"
                                placeholder="Kod iz sms-a ..."
                            />
                        </div>
                        <button @click.prevent="verifyPhone" class="uk-button uk-button-danger uk-button-large">Verifikuj</button>
                        <div class="uk-text-danger uk-text-left" v-if="verify.errors.code">{{ verify.errors.code }}</div>
                    </div>

                    <div class="uk-margin" v-if=" ! user.is_phone_verified">
                        <notice v-if="! is_sms">
                            Vaš broj telefona nije verifikovan!
                            <Link method="POST" as="button" :href="route('phone.code',{phone: form.phone})" preserve-scroll class="uk-button uk-button-small uk-position-center-right uk-margin-small-right uk-button-danger-outline">Pošalji sms za verifikaciju</Link>
                        </notice>
                        <notice v-else>
                            Da verifikujete vaš broj telefon unesite kod koji ste dobili na Sms i pošaljite.
                        </notice>
                    </div>

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
                <div v-if="$page.props.jetstream.hasEmailVerification && user.email_verified_at === null">
                    <notice v-show="! verificationLinkSent">
                        Vaša email adresa nije verifikovana.
                        <Link
                            v-if="user.email"
                            :href="route('verification.send')"
                            method="post"
                            as="button"
                            class="uk-button uk-button-small uk-position-center-right uk-margin-small-right uk-button-danger-outline"
                            @click.prevent="sendEmailVerification"
                        >
                            Pošalji link za verifikaciju.
                        </Link>
                    </notice>
                    <notice color="success" :auto_close="true" message="Novi link za verifikaciju je poslat na vašu email adresu." v-if="verificationLinkSent" />
                </div>

                <ActionMessage :on="form.recentlySuccessful">
                    Sačuvano.
                </ActionMessage>

                <loading-button @click.prevent="updateProfileInformation" class="uk-button-large uk-button-danger uk-width-1-1"
                                :class="{ 'uk-disabled': form.processing }"
                                :disabled="form.processing"
                >
                    Sačuvaj
                </loading-button>
            </div>
        </div>
    </div>
</template>
