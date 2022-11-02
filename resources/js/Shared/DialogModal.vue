<script setup>
import Modal from './Modal.vue';

const emit = defineEmits(['close']);

defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: 'default',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const close = () => {
    emit('close');
};
</script>

<template>
    <Modal
        :show="show"
        :max-width="maxWidth"
        :closeable="closeable"
        @close="close"
    >
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">
                <slot name="title" />
            </h2>
        </div>

        <div class="uk-modal-body">
            <slot name="content" />
        </div>

        <div class="uk-modal-footer">
            <slot name="footer" />
        </div>
    </Modal>
</template>
