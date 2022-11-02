<template>
    <card class="hr-split uk-border-rounded-xl">
        <template #body>

            <user-form-row :user="user" />

            <div>
                <div>
                    <a href="#contact_user_form" class="uk-button uk-button-danger uk-width">Pošalji poruku</a>
                </div>
                <div class="uk-margin-small-top">
                    <Link :href="route('bookmark.store', l.slug)"
                          as="button"
                          method="POST"
                          class="uk-button uk-button-default uk-width"
                          :class="{'uk-button-danger': l.is_bookmarked}"
                          preserve-scroll
                    >
                        <img :src="`/icons/${l.is_bookmarked ? 'star.svg' : 'star-outline.svg'}`" alt="bookmarked" width="24" height="24" class="uk-margin-small-right" uk-svg />
                        <span class="uk-text-middle">{{ l.is_bookmarked ? 'Otprati Oglas' : 'Zaprati Oglas' }}</span>
                    </Link>
                </div>
            </div>
        </template>
    </card>
</template>

<script setup>
    import Card from "@/Shared/Card.vue";
    import UserFormRow from "@/Shared/UserFormRow.vue";

    defineProps({
        user: Object,
        l: Object,
    })
</script>
