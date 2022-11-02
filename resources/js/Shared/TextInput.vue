<template>
    <div class="uk-form-controls" :class="$attrs.class">
        <label :for="id" class="uk-text-small uk-text-bold" v-if="label">{{ label }}</label>
        <span v-if="help" class="uk-margin-small-left" :title="help">
            <img src="/icons/help.svg" width="21" height="21" uk-svg/>
        </span>
        <div class="uk-inline uk-width-1-1">
            <span class="uk-form-icon uk-icon" v-if="icon">
                <img :src="`/icons/${icon}.svg`" width="21" height="21" uk-svg/>
            </span>
            <span class="uk-form-icon uk-icon uk-form-icon-flip" v-if="icon_right">
                <img class="uk-form-icon-flip" :src="`/icons/${icon_right}.svg`" width="21" height="21" uk-svg/>
            </span>
            <input :id="id" ref="input" v-bind="{ ...$attrs, class: null }" :required="required" class="uk-input" :class="{'uk-form-danger': error, 'uk-form-large': large}" :type="type" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" :aria-describedby="aria ? aria : (label ? label.trim().toLowerCase().replace(/\s+/g, '-') : id)" :placeholder="placeholder" />
        </div>
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
    type: {
      type: String,
      default: 'text',
    },
    large: {
      type: Boolean,
      default: true,
    },
    icon: String,
    icon_right: String,
    iconPosition: {
        type: String,
        default: 'right'
    },
    error: String,
    label: String,
    aria: String,
    help: String,
    modelValue: [String, Number, Boolean],
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
      setSelectionRange(start, end) {
          this.$refs.input.setSelectionRange(start, end)
      },
  },
}
</script>
