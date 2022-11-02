<template>
    <article v-if="message"
             class="uk-comment uk-border-rounded uk-margin"
             :class="{'uk-comment-primary': message.is_sender_auth }"
    >
        <header class="uk-comment-header">
            <div class="uk-grid-medium uk-flex-middle" uk-grid>
                <div class="uk-width-auto">
                    <img class="uk-comment-avatar uk-border-circle" :src="`${$page.props.config.image_base_route}/75x75/${message.profile_image}`" width="75" height="75" alt="user">
                </div>
                <div class="uk-width-expand">
                    <h4 class="uk-comment-title uk-margin-remove"><a class="uk-link-reset" href="#">{{ message.author }}</a></h4>
                    <p class="uk-comment-meta uk-margin-remove-top"><a class="uk-link-reset" @click.prevent="" href="#" v-text="message.created_human"></a></p>
                </div>
            </div>
        </header>
        <div class="uk-comment-body">
            <p>{{ message.body }}</p>
        </div>
    </article>
</template>

<script setup>
    defineProps({
        message: Object,
    })
</script>
