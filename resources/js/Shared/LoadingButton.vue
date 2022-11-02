<template>

  <button type="submit" :disabled="loading" class="uk-button">

    <slot />
    <span role="status" v-if="loading" uk-spinner></span>
  </button>

</template>

<script setup>
    defineProps({
        loading: Boolean
    })
</script>
