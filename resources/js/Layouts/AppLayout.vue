<script setup>
import Navbar from "@/Shared/Navbar.vue";
import {defineAsyncComponent} from "vue";
const Alert = defineAsyncComponent(() =>  import('@/Shared/Alert.vue'));

defineProps({
    title: String,
    flash: Object
});

/*const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    Inertia.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};*/

</script>

<template>
    <div>
        <Head :title="title">

            <meta head-key="description"  name="description" :content="$page.props.config.meta_description">

            <meta head-key="keywords"  name="keywords" :content="$page.props.config.meta_keywords">

            <meta head-key="og:title" property="og:title" :content="title" />

            <meta head-key="og:description" property="og:description" :content="$page.props.config.meta_description" />

            <meta head-key="og:image" property="og:image" :content="`${$page.props.config.image_base_route}/original/main-large.jpg`" />

            <meta head-key="og:image:alt" property="og:image:alt" content="Glavna slika" />

            <meta head-key="og:type" property="og:type" content="website" />

            <meta head-key="og:url" property="og:url" :content="$page.props.ziggy.location" />

            <meta head-key="twitter:card" name="twitter:card" content="summary_large_image" />
        </Head>

        <Navbar :user="$page.props.user" :unread="$page.props.unread" />
        <alert v-if="flash.success" :message="flash.success"/>
        <alert v-if="flash.error" color="warning" :message="flash.error"/>

        <slot />
    </div>
</template>
