<template>
    <div class="uk-padding-small">
        <label v-if="label" class="uk-text-small uk-text-bold">{{ label }}:</label>
        <text-input
            :placeholder="placeholderStart"
            :icon="iconStart"
            v-model="start"
            @keyup.enter="$emit('update:start', $event.target.value)"
            @blur="$emit('update:start', $event.target.value)"
            inputClass="uk-input"
        ></text-input>

        <text-input
            class="uk-margin-small-top"
            :placeholder="placeholderEnd"
            :icon="iconEnd"
            v-model="end"
            @keyup.enter="$emit('update:end', $event.target.value)"
            @blur="$emit('update:end', $event.target.value)"
            inputClass="uk-input"
        ></text-input>
    </div>
</template>

<script setup>
    import TextInput from "@/Shared/TextInput.vue";

    defineProps({
        start: [String, Number],
        end: [String, Number],
        placeholderStart: {
            type: String,
            default: 'Od...',
        },
        placeholderEnd: {
            type: String,
            default: 'Do...',
        },
        iconStart: String,
        iconEnd: String,
        label: String,
    })
</script>

<style scoped>

</style>
