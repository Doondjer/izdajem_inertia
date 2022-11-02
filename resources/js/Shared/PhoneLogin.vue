<template xmlns="http://www.w3.org/1999/html">
    <modal :show="true" @close="$emit('close')" title="Prijavite se putem Sms poruke">
        <div class="uk-padding" v-if="isSmsSent">
            <div class="uk-margin">
                <text-input
                    v-model="form.code"
                    icon="user"
                    label="Kod koji ste dobili na sms"
                    type="text"
                    required
                    autofocus
                    :error="form.errors.code"
                    placeholder="I - 123456"
                    @keydown.enter="submit"
                />
            </div>
            <div class="uk-margin">
                <button class="uk-button uk-button-danger uk-button-large uk-width-1-1" @click.prevent="login">Prijavite se</button>
            </div>
        </div>
        <div class="uk-padding" v-else>
            <div class="uk-margin">
                <text-input
                    v-model="form.phone"
                    icon="phone"
                    label="Vaš broj mobilnog telefona"
                    type="text"
                    required
                    autofocus
                    :error="form.errors.phone"
                    placeholder="Unesite vaš broj telefona ..."
                />
            </div>

            <div class="uk-margin">
                <button class="uk-button uk-button-danger uk-button-large uk-width-1-1" @click.prevent="submit">Pošalji Sms</button>
            </div>
        </div>

        <template #footer_info>

            {{
                isSmsSent ? 'Unesite kod za verifikaciju koji ste dobili SMS-om, pa kliknite na "Prijavite se"!'
                    : `Klikom na "Pošaljite SMS" dobićete jednokratni verifikacioni kod putem SMS-a na broj mobilnog telefona koji ste gore uneli.
                    Mogu nastati standardi troškovi u skladu sa paketom koji imate kod vašeg mobilnog operatera.`
            }}

        </template>
    </modal>
</template>

<script setup>
    import Modal from "@/Shared/Modal.vue";
    import TextInput from "@/Shared/TextInput.vue";
    import {useForm} from "@inertiajs/inertia-vue3";
    import {ref} from "vue";

    let isSmsSent = ref(false);

    let form = useForm({
        phone: null,
        code: null
    })

    let emits = defineEmits(['close'])

    let submit = ()  => {
        form.post(route('phone.code'), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                isSmsSent.value = true;
            }
        })
    }

    let login = ()  => {
        form.post(route('phone.login'), {
            onSuccess: () => {
                emits('close')
            }
        })
    }
</script>
