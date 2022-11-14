<script setup>

import DialogModal from '@/Shared/DialogModal.vue';
import LoadingButton from "@/Shared/LoadingButton.vue";
import Checkbox from "@/Shared/Checkbox.vue";
import {ref} from "vue";
import {useForm} from "@inertiajs/inertia-vue3";

let update = ref(null);

const closeModal = () => {
    update.value = null;
};

let props = defineProps({
    settings: Object,
    values: Object,
    route_path: String
});
let form = useForm({
    email_notify_message_sent: !! props.values.email_notify_message_sent,
    email_notify_message_received: !! props.values.email_notify_message_received,
    email_notify_listing_created: !! props.values.email_notify_listing_created,
    sms_notify_message_received: !! props.values.sms_notify_message_received,
    show_profile: !! props.values.show_profile,
});

let submit = (name)  => {
    form
        .transform((data) => ({
            [name]: !!data[name],
        })).patch(props.route_path,{
            preserveScroll: true,
        onSuccess: () => {
                update.value = null;
        }
    })
}

</script>

<template>
    <div>
        <div class="uk-margin-small" v-for="(data, title) in settings">
            <h2 class="uk-h5 uk-text-bold">{{ title }}</h2>
            <div class="uk-card uk-card-default uk-border-rounded-xl hr-split">
                <div class="uk-card-body uk-padding-remove">
                    <div class="uk-grid uk-grid-collapse uk-link" v-for="setting in data" style="padding: 20px" @click="update = setting">
                        <div class="uk-width-expand uk-text-muted">
                            <div class="uk-text-bold uk-text-capitalize">{{ setting.value ? setting.title : `${setting.title} - ${setting.on}` }}</div>
                            <div class="uk-text-capitalize">{{ setting.value ? `On: ${setting.on}` : 'Off'}}</div>
                        </div>
                        <div class="uk-width-auto">
                            <a href="#" >
                                <img src="/icons/chevron-right.svg" class="uk-icon-button uk-button-default" alt="više" uk-svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <dialog-modal :show="!!update" v-if="!!update" @close="closeModal" max-width="medium">
            <template #title>
                {{ update.title }}
            </template>

            <template #content>
                <p>{{ update.description }}</p>

                <p>
                    <checkbox v-model:checked="form[update.name]" :name="update.name" :disabled="update.disabled" class="uk-text-capitalize">{{ update.on }}</checkbox>
                </p>
                <p class="uk-text-danger" v-if="update.notice">{{ update.notice }}</p>
            </template>

            <template #footer>
                <loading-button @click.prevent="submit(update.name)" class="uk-button-large uk-button-danger uk-width-1-1"
                                :class="{ 'uk-disabled': update.disabled }"
                                :disabled="update.disabled"
                >
                    Sačuvaj
                </loading-button>

            </template>
        </dialog-modal>
    </div>


</template>
