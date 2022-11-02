<script setup>
import Navbar from "@/Layouts/Admin/Navigation/Navbar.vue";
import {defineAsyncComponent} from "vue";
const Alert = defineAsyncComponent(() =>  import('@/Shared/Alert.vue'));

defineProps({
    title: String,
    flash: Object
});

</script>

<template>
    <div>
        <Head :title="title" />

        <Navbar :user="$page.props.user" :unread="$page.props.unread" />
        <div class="uk-grid uk-grid-small">
            <div class="uk-width-xmedium uk-visible@m">
                <div class="uk-offcanvas uk-open uk-display-block uk-width-xmedium" id="nav_side_menu">
                    <div class="uk-offcanvas-bar uk-padding-remove uk-width-xmedium" style="background: #1e293b;">

                        <div class="uk-panel" >
                            <ul class="uk-nav uk-nav-default">
                                <Link class="uk-navbar-item uk-logo" :href="route('admin.home')" aria-label="Početna Strana">
                                    <span class="uk-icon uk-text-danger" uk-icon="logo"></span>
                                </Link>
                                <li class="uk-nav-item">
                                    <Link :href="route('home')">
                                        <img src="/icons/home.svg" alt="pocetna" uk-svg />
                                        <span class="uk-text-middle">Početna</span>
                                    </Link>
                                </li>
                                <li class="uk-nav-item">
                                    <Link :href="route('admin.listing.index')">
                                        <img src="/icons/home-edit.svg" alt="oglasi" uk-svg />
                                        <span class="uk-text-middle">Oglasi</span>
                                    </Link>
                                </li>
                                <li class="uk-nav-item">
                                    <Link :href="route('admin.user.index')">
                                        <img src="/icons/account-edit.svg" alt="korisnici" uk-svg />
                                        <span class="uk-text-middle">Korisnici</span>
                                    </Link>
                                </li>
                                <li class="uk-nav-item">
                                    <Link :href="route('admin.thread.index')">
                                        <img src="/icons/comment-edit.svg" alt="konverzacije" uk-svg />
                                        <span class="uk-text-middle">Konverzacije</span>
                                    </Link>
                                </li>
                                <li class="uk-nav-item">
                                    <Link :href="route('admin.maintenance')">
                                        <img src="/icons/security.svg" alt="odrzavanje" uk-svg />
                                        <span class="uk-text-middle">Održavanje</span>
                                    </Link>
                                </li>
                                <li class="uk-nav-item">
                                    <Link :href="route('admin.page.index')">
                                        <img src="/icons/file-text.svg" alt="dodatne_stranice" uk-svg />
                                        <span class="uk-text-middle">Dodatne Stranice</span>
                                    </Link>
                                </li>
                                <li class="uk-nav-item">
                                    <Link :href="route('admin.sitemap.show')">
                                        <img src="/icons/sitemap.svg" alt="sitemap" uk-svg />
                                        <span class="uk-text-middle">Sitemap</span>
                                    </Link>
                                </li>
                                <li class="uk-nav-item">
                                    <Link :href="route('admin.backup.index')">
                                        <img src="/icons/backup.svg" alt="backup" uk-svg />
                                        <span class="uk-text-middle">Backup</span>
                                    </Link>
                                </li>
                                <li class="uk-nav-item">
                                    <Link :href="route('admin.log.index')">
                                        <img src="/icons/archive.svg" alt="logovi" uk-svg />
                                        <span class="uk-text-middle">Logovi</span>
                                    </Link>
                                </li>
                                <li class="uk-nav-item">
                                    <Link :href="route('admin.health')">
                                        <img src="/icons/first-aid.svg" alt="stanje_servera" uk-svg />
                                        <span class="uk-text-middle">Stanje Servera</span>
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-expand">
                <alert v-if="flash.success" :close="false" :message="flash.success"/>
                <alert v-if="flash.error" :close="false" color="warning" :message="flash.error"/>

                <slot />

            </div>
        </div>


    </div>
</template>
