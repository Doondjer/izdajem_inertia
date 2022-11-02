<script setup>
import Modal from "@/Shared/Modal.vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    title: {
        type: String,
        default: '',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    cancel: {
        type: String,
        default: "Prekini",
    },
    confirm: {
        type: String,
        default: "Nastavi",
    },
});

const emit = defineEmits(['close','confirmed','canceled']);

</script>

<template>
    <modal
        :closeable="props.closeable"
        @close="emit('close')"
        :show="props.show"
        :maxWidth="props.maxWidth"
        :title="props.title"
    >

        <div class="uk-modal-body">
            <slot />
        </div>

        <template #footer>
            <div class="uk-text-right">
                <button class="uk-button uk-button-default uk-margin-small-right" @click.prevent="emit('canceled')">{{ cancel }}</button>
                <button class="uk-button uk-button-danger" @click.prevent="emit('confirmed')">{{ confirm }}</button>
            </div>
        </template>
    </modal>
</template>
