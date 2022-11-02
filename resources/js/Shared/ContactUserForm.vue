<template>

    <card class="uk-border-rounded-xl hr-split">
        <template #header>
            <div class="uk-card-header">
                <h3 class="uk-h4">{{ `Kontaktiraj korisnika ${user.fullname}` }}</h3>
            </div>

        </template>
        <template #body>

            <user-form-row :user="user" />

            <div v-if="$page.props.user">
                <h3 class="uk-h5 uk-text-bold">Poruka je u vezi?</h3>

                <div class="uk-grid uk-child-width-1-1 uk-child-width-1-2@s">
                    <checkbox :checked="form.subject === 'U vezi datuma raspoloživosti'" @click.prevent="form.subject= 'U vezi datuma raspoloživosti'" name="subject">Datuma raspoloživosti</checkbox>
                    <checkbox :checked="form.subject === 'U vezi dužine zakupa'" @click.prevent="form.subject= 'U vezi dužine zakupa'" name="subject">Dužine zakupa</checkbox>
                    <checkbox :checked="form.subject === 'U vezi posete & razgledanja'" @click.prevent="form.subject= 'U vezi posete & razgledanja'" name="subject">Posete & razgledanja</checkbox>
                    <checkbox :checked="form.subject === 'U vezi prijave za iznajmljivanje'" @click.prevent="form.subject= 'U vezi prijave za iznajmljivanje'" name="subject">Prijave za iznajmljivanje</checkbox>
                </div>
                <div class="uk-text-danger uk-text-left" v-if="form.errors.subject">{{ form.errors.subject }}</div>
            </div>
            <div v-if="l" class="uk-grid uk-grid-small" uk-grid>
                <div class="uk-width-auto">
                    <img class="uk-border-rounded-xl" :src="`${$page.props.config.image_base_route}/small/${l.image}`" :alt="l.slug" uk-img>
                </div>
                <div class="uk-width-expand">
                    <p class="uk-h4 uk-margin-remove">{{ l.street }} {{ l.street_nb }}</p>
                    <div class="uk-text-danger">{{ l.price_for_human }}</div>
                </div>
            </div>

            <div v-if="$page.props.user">
                <div>
                    <textarea-input
                        class="uk-margin-small-top"
                        v-model="form.message"
                        label="Tekst poruke"
                        required
                        :error="form.errors.message"
                        placeholder="Unesite tekst poruke ..."
                        :showLabel="true"
                        cols="30"
                        rows="7"
                    />
                </div>
            </div>
            <div>
                <notice color="success" :auto_close="true" :message="$page.props.flash.success" v-if="$page.props.flash.success" />

                <loading-button class="uk-button-large uk-button-danger uk-width-1-1"
                                :class="{ 'uk-disabled': form.processing }"
                                :disabled="form.processing"
                                :loading="form.processing"
                                @click.prevent="submit"
                >
                    {{ $page.props.user ? 'Pošalji' : 'Dalje'}}
                </loading-button>
            </div>
        </template>
    </card>
</template>

<script setup>
    import Card from "@/Shared/Card.vue";
    import Checkbox from "@/Shared/Checkbox.vue";
    import Notice from "@/Shared/Notice.vue";
    import TextareaInput from "@/Shared/TextareaInput.vue";
    import LoadingButton from "@/Shared/LoadingButton.vue";
    import UserFormRow from "@/Shared/UserFormRow.vue";

    import {useForm} from "@inertiajs/inertia-vue3";

    let props = defineProps({
        user: Object,
        l: Object,
    })
    const form = useForm({
        subject: null,
        message: null,
        recipient: props.user.id
    })

    let submit = () => {

        form.transform(data => ({
            ...data,
            subject: form.subject && props.l ? `${form.subject} za ${props.l.street} ${props.l.price_for_human}` : form.subject
        })).post(props.l ? route('message.store', props.l.slug) :  route('message.store'),{
            preserveScroll: true,
            onSuccess: () => {
                form.reset()
            }
        });
    };

</script>

<style scoped>

</style>
