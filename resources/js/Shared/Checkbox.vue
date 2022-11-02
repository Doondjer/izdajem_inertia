<script setup>
import { computed } from 'vue';
import { v4 as uuid } from 'uuid'

const emit = defineEmits(['update:checked']);

const props = defineProps({
    id: {
        type: String,
        default() {
            return `checkbox-input-${uuid()}`
        },
    },
    checked: {
        type: [Array, Boolean],
        default: false,
    },
    value: {
        type: String,
        default: null,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    name: String
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});
</script>


<template>
    <label :class="{'uk-disabled': disabled}" :for="id">
        <input class="uk-checkbox uk-margin-small-right"
               type="checkbox"
               v-model="proxyChecked"
               :value="value"
               :id="id"
               :name="name"
               :disabled="disabled"
        >
            <slot />
    </label>
</template>
