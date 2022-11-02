<template>
    <div v-show="o" class="uk-alert uk-border-rounded-xl" :class="color ? `uk-alert-${color}` : ''">
        <div class="uk-grid uk-grid-small">
            <div class="uk-width-auto">
                <img :src="`/icons/${icon}.svg`" :alt="icon" uk-svg>
            </div>
            <div class="uk-width-expand">
                <slot>{{ message }}</slot>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
    let o = ref(true);
    let props = defineProps({
        message: String,
        icon: {
          type: String,
          default: 'info'
        },
        color: {
            type: String,
            default: 'warning'
        },
        close_interval: {
            type: Number,
            default: 3000
        },
        auto_close: Boolean
    })
    onMounted(() => {
        if (props.auto_close) {
            setTimeout(() => {
                o.value = false;
            }, props.close_interval);
        }

    })
</script>
