<template>
    <ul class="uk-nav uk-navbar-dropdown-nav">
        <li class="uk-nav-item">
            <Link :href="route('bookmark.index')">Nekretnine Koje Pratim</Link>
        </li>
        <li class="uk-nav-item">
            <Link :href="route('user-listing.index')">Moje Nekretnine</Link>
        </li>
        <li class="uk-nav-item">
            <Link :href="route('message.index')">Moje Poruke</Link>
        </li>
        <li class="uk-nav-item">
            <Link :href="route('profile.show')">Moj Profil</Link>
        </li>
        <li class="uk-nav-item">
            <Link :href="route('setting.edit')">Moja Podešavanja</Link>
        </li>
        <li v-if="$page.props.user && $page.props.user.is_admin" class="uk-nav-item">
            <Link class="uk-text-danger uk-text-bold uk-flex-center" :href="route('admin.home')">Admin</Link>
        </li>
        <slot />
        <li class="uk-nav-item" v-if="logout">
            <Link method="POST" as="button" class="uk-button uk-button-link uk-padding-small uk-width-1-1" :href="route('logout')">Odjavite Se</Link>
        </li>
    </ul>
</template>

<script setup>
defineProps({
    logout: {
        type: Boolean,
        default: true
    }
})
</script>

<style scoped>

</style>
