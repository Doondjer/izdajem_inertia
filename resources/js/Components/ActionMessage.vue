<script setup>
defineProps({
    on: Boolean,
});
</script>

<template>
    <div>
        <transition leave-active-class="transition ease-in duration-1000" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-show="on" class="uk-alert-warning uk-border-rounded uk-alert" uk-alert="">
                <a class="uk-alert-close uk-icon uk-close" uk-close=""></a>
                <slot />
            </div>
        </transition>
    </div>
</template>
