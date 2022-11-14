<template>
    <div class="uk-grid-collapse uk-flex-middle uk-padding-remove-vertical uk-grid" uk-grid>
        <Link v-if="user.show_profile" :href="route('landlord.show', user.id)" class="uk-width-auto">
            <img class="uk-border-circle" width="60" height="60" :data-src="`${$page.props.config.image_base_route}/75x75/${user.profile_image}`" uk-img>
        </Link>
        <span v-else class="uk-width-auto">
            <img class="uk-border-circle" width="60" height="60" :data-src="`${$page.props.config.image_base_route}/75x75/${user.profile_image}`" uk-img>
        </span>
        <div class="uk-width-expand">
            <div class="uk-position-relative">
                <Link v-if="user.show_profile" :href="route('landlord.show', user.id)" class="uk-text-bold">{{ user.fullname }}</Link>
                <span v-else class="uk-text-bold">{{ user.fullname }}</span>
                <a v-if="user.phone" :href="`tel:${user.phone}`" class="uk-icon-button uk-button-default uk-hidden@s uk-position-right">
                    <img src="/icons/phone.svg" alt="phone" uk-svg>
                </a>
            </div>

            <p class="uk-text-meta uk-margin-remove-top uk-visible@s" v-if="user.phone">
                <a href="#" :title="phone === user.phone ? '' : 'Klikni za broj telefona'" @click.prevent="phone = user.phone" class="uk-label uk-border-rounded">{{ phone }}</a>
            </p>
        </div>
    </div>
</template>

<script setup>
    import {defineProps, ref} from "vue";

    let props = defineProps({
            user: Object
        })

    let phone = ref(props.user.phone ? `${props.user.phone.substring(0,4)}...` : null);
</script>

<style scoped>

</style>
