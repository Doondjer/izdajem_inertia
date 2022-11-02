<template>
    <div class="uk-form-controls" :class="$attrs.class">
        <label v-if="label" class="uk-text-small uk-text-bold" :for="id">{{ label }}</label>
        <div class="uk-inline uk-width-1-1" v-if="icon">
            <span class="uk-form-icon uk-icon">
                <img v-if="icon" :src="`/icons/${icon}.svg`" width="21" height="21" uk-svg/>
            </span>
            <select style="padding-left: 40px;" :id="id" ref="select" v-model="selected" v-bind="{ ...$attrs, class: null }" class="uk-select" :class="{ 'uk-form-danger': error, 'uk-form-large': large }" :aria-describedby="aria ? aria : (label ? label.trim().toLowerCase().replace(/\s+/g, '-') : id)">
                <slot />
            </select>
        </div>

        <select v-else :id="id" ref="select" v-model="selected" v-bind="{ ...$attrs, class: null }" class="uk-select" :class="{ 'uk-form-danger': error, 'uk-form-large': large }" :aria-describedby="aria ? aria : (label ? label.trim().toLowerCase().replace(/\s+/g, '-') : id)">
            <slot />
        </select>

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
                return `text-input-${uuid()}`
            },
        },
        icon: String,
        error: String,
        label: String,
        large: {
            type: Boolean,
            default: true,
        },
        aria: String,
        modelValue: [String, Number, Boolean],
        required: Boolean,
        hint: String,
    },
    emits: ['update:modelValue'],
    data() {
        return {
            selected: this.modelValue,
        }
    },
    watch: {
        selected(selected) {
            this.$emit('update:modelValue', selected)
        },
    },
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
