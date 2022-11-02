<template>
    <div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky">
        <nav class="uk-navbar-container uk-navbar-sticky uk-grid" uk-navbar>
            <div class="uk-navbar-left uk-width-expand">
                <Link class="uk-navbar-item uk-logo" :href="route('home')" aria-label="Početna Strana">
                    <span class="uk-icon uk-text-danger" uk-icon="logo"></span>
                </Link>
                <div class="uk-navbar-item uk-width-expand">
                    <div class="uk-search uk-search-navbar uk-width-expand">
                        <a href="#" class="uk-search-icon-flip" uk-search-icon @click.prevent="search" aria-label="Pretraži"></a>
                        <input class="uk-search-input uk-padding-small" type="search" @keyup.enter.prevent="search" v-model="form.q" placeholder="Pretraži...">
                    </div>
                </div>
            </div>
            <div class="uk-navbar-right">

                <ul class="uk-navbar-nav uk-visible@m">
                    <li><Link :href="route('listing.index')">Izdaje se</Link></li>
                    <li><Link :href="route('advertise')">Oglasite Izdavanje</Link></li>

                    <li v-if="user">
                        <a href="#" class="uk-icon" aria-label="poruke"  @click.prevent="show = ! show">
                            <img v-if="n > 0" class="uk-link" src="/icons/bell-ringing.svg" width="30" height="30" alt="poruke" uk-svg />
                            <img v-else class="uk-text-meta uk-link" src="/icons/bell.svg" width="30" height="30" alt="poruke" uk-svg />
                        </a>

                        <notification-box v-if="show" @close="show = false" :user="user"></notification-box>

                    </li>
                </ul>
                <div class="uk-navbar-nav uk-visible@m" v-if=" ! user">
                    <Link :href="route('login')" class="uk-button uk-button-default uk-text-bold"><span itemprop="name" class="uk-text-capitalize">Prijava</span></Link>
                    <Link :href="route('register')" class="uk-button uk-button-danger uk-text-bold uk-margin-small-left"><span itemprop="name" class="uk-text-capitalize">Registracija</span></Link>
                </div>
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
                <ul class="uk-navbar-nav uk-visible@m">
                    <li>
                        <a href="#" class="uk-open">
                            SR
                            <img src="/icons/chevron-down.svg" alt="više" uk-svg>
                        </a>
                    </li>
                </ul>
                <a href="#" class="uk-icon uk-hidden@m uk-icon-button uk-button-default" aria-label="poruke" @click.prevent="show = ! show">
                    <img v-if="n > 0" class="uk-link" src="/icons/bell-ringing.svg" width="30" height="30" alt="poruke" uk-svg />
                    <img v-else class="uk-text-meta uk-link" src="/icons/bell.svg" width="30" height="30" alt="poruke" uk-svg />
                </a>

                <notification-box class="uk-hidden@m" @close="show = false" :user="user" v-if="user && show"></notification-box>
<!--                <a href="#" class="uk-button unread-count uk-icon uk-hidden@m hidden-unread uk-button-default" :class="{ 'uk-text-danger': threads.data.length }" uk-icon="icon: comment; ratio: 1.5" v-if="user">
                    <span class="nb-unread" v-text="threads.data.length"></span>
                </a>

                <notification-box :threads="threads" v-if="user"></notification-box>-->

                <a href="#" class="uk-navbar-toggle uk-hidden@m uk-icon uk-navbar-toggle-icon" uk-toggle="target: #nav_side_menu" aria-label="Meni">
                    <img src="/icons/navbar-nav.svg" alt="N" uk-svg>
                </a>
            </div>
        </nav>

        <side-menu />

    </div>
</template>

<script setup>
    import { useForm } from "@inertiajs/inertia-vue3";
    import UserMenu from "./Menu.vue";
    import SideMenu from "./SideMenu.vue";
    import NotificationBox from "./NotificationBox.vue";
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
