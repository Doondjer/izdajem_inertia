<template>
    <div class="uk-form-controls" :class="$attrs.class">
        <label v-if="label" class="uk-text-small uk-text-bold" :for="id">{{ label }}:</label>
        <textarea :id="id" ref="input" v-bind="{ ...$attrs, class: null }" class="uk-textarea" :class="{ 'uk-form-danger': error }" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" :aria-describedby="aria ? aria : (label ? label.trim().toLowerCase().replace(/\s+/g, '-') : id)" :placeholder="placeholder" />

        <div v-if="error" class="uk-text-danger uk-text-left" v-text="error"></div>
        <div v-if="hint" class="uk-text-muted uk-text-left" v-text="hint"></div>
    </div>
</template>

<script>
import { v4 as uuid } from 'uuid'

export default {
    inheritAttrs: false,
    props: {
        id: {
            type: String,
            default() {
                return `textarea-input-${uuid()}`
            },
        },
        error: String,
        label: String,
        aria: String,
        modelValue: String,
        required: Boolean,
        hint: String,
        placeholder: String,
    },
    emits: ['update:modelValue'],
    methods: {
        focus() {
            this.$refs.input.focus()
        },
        select() {
            this.$refs.input.select()
        },
    },
}
</script>
