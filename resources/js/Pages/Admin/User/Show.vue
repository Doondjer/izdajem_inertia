<template>
    <div class="uk-container">
        <notice class="uk-margin-small-top" :message="`Kreiran: ${member.created_at}`"/>
    </div>


    <div class="uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-grid-small uk-grid" uk-grid>
                <div class="uk-width-medium">
                    <h2 class="uk-h5 uk-text-bold">Profil</h2>
                    <card class="uk-border-rounded-xl">
                        <template #header>
                            <div class="uk-card-header uk-text-center">
                                <img class="uk-border-circle" width="75" height="75" :data-src="`${$page.props.config.image_base_route}/75x75/${member.profile_image}`" uk-img>
                                <h3 class="uk-card-title uk-margin-remove">{{ member.name }}</h3>
                                <div v-if="member.email" class="uk-text-muted" :title="member.email_verified_at ? `Email adresa verifikovana ${member.email_verified_at}` : 'Email adresa nije verifikovana'">
                                    <span class="uk-text-middle">{{ member.email }}</span>
                                    <img :class="member.email_verified_at ? 'uk-text-success' : 'uk-text-danger'" class="uk-margin-small-left" :src="`/icons/${member.email_verified_at ? 'check-circle' : 'cancel-outline'}.svg`" width="27" height="27" uk-svg>
                                </div>
                                <div v-if="member.phone" class="uk-text-muted" :title="member.phone_verified_at ? `Telefon verifikovan ${member.phone_verified_at}` : 'Telefon nije Verifikovan'">
                                    <span class="uk-text-middle">{{ member.phone }}</span>
                                    <img :class="member.phone_verified_at ? 'uk-text-success' : 'uk-text-danger'" class="uk-margin-small-left" :src="`/icons/${member.phone_verified_at ? 'check-circle' : 'cancel-outline'}.svg`" width="27" height="27" uk-svg>
                                </div>
                                <p class="uk-text-muted">
                                    <span class="uk-label uk-button uk-disabled" :class="{'uk-label-danger': member.is_admin}">{{ member.is_admin ? 'Administrator' : 'Korisnik' }}</span>
                                </p>
                            </div>
                        </template>
                        <template #body>
                            <ul class="uk-list uk-list-divider">
                                <li class="uk-position-relative">
                                    <b>Poruka</b> <a class="uk-position-center-right uk-label uk-button uk-disabled" :class="{'uk-label-danger': member.nb_threads}">{{ member.nb_threads }}</a>
                                </li>
                                <li class="uk-position-relative">
                                    <Link :href="route('admin.listing.index',{user: member.id})"><b>Oglasa</b> <span class="uk-position-center-right uk-label uk-button" :class="{'uk-label-danger': member.nb_listings}">{{  member.nb_listings }}</span></Link>
                                </li>
                                <li class="uk-position-relative">
                                    <b>Bookmarks</b> <a class="uk-position-center-right uk-label uk-button uk-disabled" :class="{'uk-label-danger': member.nb_bookmarks}">{{ member.nb_bookmarks }}</a>
                                </li>
                            </ul>
                            <div class="uk-card-footer">
                                <div class="uk-button-group uk-width-1-1 uk-child-width-1-2">
                                    <Link :href="route('admin.user.edit', member.id)" class="uk-button uk-button-default">Izmeni</Link>
                                    <Link title="Obriši" as="button" method="DELETE" :href="route('admin.user.delete', member.id)" class="uk-button uk-button-danger">
                                        <img src="/icons/trash.svg" alt="trash" uk-svg>
                                        Obriši
                                    </Link>
                                </div>

                            </div>
                        </template>
                    </card>
                </div>

                <div class="uk-width-expand">
                    <edit-user-settings :route_path="route('admin.setting.update', member.id)" :settings="settings" :values="values" />
                </div>

            </div>
        </div>
    </div>
    <div class="uk-container">
        <notice color="danger" :message="`Poslednja izmena: ${member.updated_at}`"/>
    </div>
</template>

<script>
    import AdminLayout from "@/Layouts/Admin/AppLayout.vue";
    export default {
        layout: AdminLayout
    }
</script>

<script setup>
    import Card from "@/Shared/Card.vue";
    import Notice from "@/Shared/Notice.vue";
    import EditUserSettings from "@/Shared/EditUserSettings.vue";

    defineProps({
        member: Object,
        threads: Object,
        listings: Object,
        settings: Object,
        values: Object,
    })
</script>
