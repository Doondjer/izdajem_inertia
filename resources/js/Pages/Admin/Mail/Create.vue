<template>

    <show-form
        title="Kreiraj Mail"
        card_title="Kreiraj Novi Mail"
    >

        <div class="uk-form-row uk-margin-small">
            <text-input
                v-model="form.email"
                type="email"
                required
                label="To"
                :error="form.errors.email"
                placeholder="Unesite Email Primaoca..."
                hint="Email adresa na koji želite da pošaljete email."
            />
        </div>
        <div class="uk-form-row uk-margin-small">
            <text-input
                v-model="form.subject"
                required
                label="Subject"
                :error="form.errors.subject"
                placeholder="Unesite Predmet Poruke..."
                hint="Unesite ukratko o čemu se radi u email poruci."
            />
        </div>
        <div class="uk-form-row uk-margin-small">
            <textarea-input
                v-model="form.body"
                label="Poruka"
                :error="form.errors.body"
                placeholder="Unesite Tekst Poruke..."
                hint="Unesite tekst poruke koju želite da pošaljete."
                cols="30"
                rows="7"
            />
        </div>

        <div class="uk-form-row uk-margin-small">
            <loading-button class="uk-button-large uk-button-danger uk-width-1-1"
                            :class="{ 'uk-disabled': form.processing }"
                            :disabled="form.processing"
                            @click.prevent="submit"
            >
                Pošaljite
            </loading-button>
        </div>
    </show-form>

</template>

<script>

    import AdminLayout from "@/Layouts/Admin/AppLayout.vue";
    export default {
        layout: AdminLayout
    }

</script>

<script setup>
    import TextareaInput from "@/Shared/TextareaInput.vue";
    import LoadingButton from "@/Shared/LoadingButton.vue";
    import ShowForm from "@/Shared/Admin/Form.vue";
    import TextInput from "@/Shared/TextInput.vue";
    import {useForm} from "@inertiajs/inertia-vue3";

    let form = useForm({
        email: null,
        subject: null,
        body: null,
    })

    let submit = () => {
        form.post(route('admin.mail.send'),{
            onSuccess: () => {
                form.reset();
            },
            preserveScroll: true
        })
    }
</script>

