<template>
    <div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky">
        <nav class="uk-navbar-container uk-navbar-sticky uk-grid" uk-navbar>
            <div class="uk-navbar-left uk-width-medium@m uk-width-auto">
                <Link class="uk-navbar-item uk-logo" :href="route('home')" aria-label="Početna Strana">
                    <span class="uk-icon uk-text-danger" uk-icon="logo"></span>
                </Link>
            </div>
            <div class="uk-navbar-item uk-flex-left">
                <Link class="uk-button uk-button-default uk-text-bold" :href="route('admin.mail.create')"><img src="/icons/plus.svg" alt="više" uk-svg><span class="uk-text-middle">Mail</span></Link>
            </div>
            <div class="uk-navbar-right">


                <ul class="uk-navbar-nav uk-visible@m">
                    <li v-if="user">
                        <a href="#" class="uk-icon" aria-label="poruke"  @click.prevent="show = ! show">
                            <img v-if="n > 0" class="uk-link" src="/icons/bell-ringing.svg" width="30" height="30" alt="poruke" uk-svg />
                            <img v-else class="uk-text-meta uk-link" src="/icons/bell.svg" width="30" height="30" alt="poruke" uk-svg />
                        </a>

                        <notification-box v-if="show" @close="show = false" :user="user"></notification-box>

                    </li>
                </ul>
                <ul class="uk-navbar-nav uk-visible@m" v-if="user">
                    <li>
                        <Link :href="route('dashboard')" class="uk-icon"><img class="uk-link uk-border-circle" :src="`${$page.props.config.image_base_route}/40x40/${user.profile_image}`" width="40" height="40" :alt="user.fullname" uk-svg /></Link>

                        <div class="uk-navbar-dropdown uk-navbar-dropdown-dropbar">
                            <div class="uk-card uk-card-default uk-navbar-dropdown-nav">
                                <user-menu class="" />
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="uk-navbar-nav uk-visible@m">
                    <div class="uk-text-center uk-margin-right">
                        <a href="#" class="uk-open uk-text-muted">
                            <div class="uk-text-bold">{{ user.fullname }}</div>
                            <div>{{ user.is_admin ? 'Administrator' : 'Korisnik'}}</div>
                        </a>
                    </div>
                </div>
                <a href="#" class="uk-icon uk-hidden@m uk-icon-button uk-button-default" aria-label="poruke" @click.prevent="show = ! show">
                    <img v-if="n > 0" class="uk-link" src="/icons/bell-ringing.svg" width="30" height="30" alt="poruke" uk-svg />
                    <img v-else class="uk-text-meta uk-link" src="/icons/bell.svg" width="30" height="30" alt="poruke" uk-svg />
                </a>

                <notification-box class="uk-hidden@m" @close="show = false" :user="user" v-if="user && show"></notification-box>

                <a uk-navbar-toggle-icon="" href="#" class="uk-navbar-toggle uk-hidden@m uk-icon uk-navbar-toggle-icon" uk-toggle="target: #nav_side_menu" aria-label="Meni"></a>
            </div>
        </nav>

        <side-menu />

    </div>
</template>

<script setup>
    import { useForm } from "@inertiajs/inertia-vue3";
    import UserMenu from "@/Shared/Menu.vue";
    import SideMenu from "@/Shared/SideMenu.vue";
    import NotificationBox from "@/Shared/NotificationBox.vue";
    import {ref} from "vue";


    let props = defineProps({
        user: Object,
        unread: Number
    })




    let form = useForm({
        q: '',
    });

    let show = ref(false);
    let n = ref(props.unread);

    let search = () => {
        form.get(route('listing.index'),{
            onFinish: () => form.reset()
        });
    }

    if (typeof window !== 'undefined' && props.user) {
         window.Echo.private(`messages.${props.user.id}`).listen('NbMessages', e => {
            n.value = e.nbMessages;
        });
    }


</script>
