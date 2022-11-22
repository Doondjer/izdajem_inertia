<template>
    <div id="nav_side_menu" uk-offcanvas="overlay: true" class="uk-hidden@m">
        <div class="uk-offcanvas-bar uk-padding-remove">

            <div uk-toggle="target: #nav_side_menu">
                <div class="uk-button-group flat-button uk-width-expand" v-if="!$page.props.user">
                    <Link :href="route('register')" class="uk-button uk-button-danger uk-width-1-2 uk-text-bold"><span itemprop="name" class="uk-text-capitalize">Registracija</span></Link>
                    <Link :href="route('login')" class="uk-button uk-button-default uk-width-1-2 uk-text-bold"><span itemprop="name" class="uk-text-capitalize">Prijava</span></Link>
                </div>
                <div class="uk-button-group flat-button uk-width-expand" v-else>
                    <Link as="button" method="POST" :href="route('logout')" class="uk-button uk-button-danger uk-width-1-1 uk-text-bold"><span itemprop="name" class="uk-text-capitalize">Odjavite Se</span></Link>
                </div>
            </div>

            <div class="uk-panel" uk-toggle="target: #nav_side_menu">
                <ul class="uk-nav uk-nav-default">
                    <li class="uk-nav-item">
                        <Link class="uk-navbar-item uk-logo" :href="route('home')">
                            Naslovna Strana
                        </Link>
                    </li>
                    <li class="uk-nav-item"><Link :href="route('listing.index')">Pretražite Nekretnine</Link></li>
                    <li class="uk-nav-item"><Link :href="route('advertise')">Oglasite Izdavanje Nekretnine</Link></li>
                </ul>

                <user-menu class="uk-nav-default" v-if="$page.props.user" :logout="false" />

            </div>

            <div class="uk-button-group flat-button uk-width-expand uk-position-bottom">
                <button class="uk-button uk-button-danger uk-width-1-1">SR</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import UserMenu from "./Menu.vue";

</script>

<style scoped>

</style>
