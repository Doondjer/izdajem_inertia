<script setup>
import { computed, onMounted, onUnmounted, watch } from 'vue';

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
});

const emit = defineEmits(['close']);

watch(() => props.show, () => {
    if (props.show) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = null;
    }
});

const close = () => {
    if (props.closeable) {
        emit('close');
    }
};

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = null;
});

const maxWidthClass = computed(() => {
    return {
        'medium': 'uk-width-medium',
        'default': '',
    }[props.maxWidth];
});
</script>

<template>
    <teleport to="body">
        <transition leave-active-class="duration-200">
            <div v-show="show" class="uk-modal uk-open uk-display-block">
                <div class="uk-modal-dialog uk-overflow-hidden uk-border-rounded-xl" :class="maxWidthClass">

                <transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div :class="{'uk-modal-header': $slots.title || title}">
                        <button v-show="show" v-if="closeable" class="uk-modal-close-default" type="button" @click="close" uk-icon="close-large"></button>
                        <slot name="title"><h2 class="uk-modal-title" v-if="title">{{ title }}</h2></slot>
                    </div>
                </transition>

                <transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                <div>
                    <slot v-if="show" />
                    <div class="uk-modal-footer uk-padding-small" :class="{'uk-background-muted uk-grid-collapse uk-grid': $slots.footer_info}" v-if="$slots.footer || $slots.footer_info">
                        <slot name="footer">
                            <div class="uk-width-auto uk-margin-small-right">
                                <img src="/icons/info.svg" alt="i" uk-svg>
                            </div>
                            <div class="uk-width-expand uk-text-middle">
                                <slot name="footer_info"></slot>
                            </div>
                        </slot>
                    </div>
                </div>

                </transition>


                </div>
            </div>
        </transition>
    </teleport>
</template>
