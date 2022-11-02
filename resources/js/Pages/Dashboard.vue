<script setup>
    import DashboardItem from "@/Shared/DashboardItem.vue";
    import BaseFooter from "@/Shared/Footer.vue";

    defineProps({
        user: Object,
    })
</script>

<template>
    <Head title="Moj" />

    <div class="uk-section uk-section-small" uk-height-viewport="expand: true">
        <div class="uk-container">
            <div class="uk-grid uk-grid-collapse">
                <div class="uk-width-expand">
                    <h1 class="uk-h2 uk-margin-remove-bottom">Pozdrav, {{ user.fullname }}</h1>
                    <div class="uk-text-muted">{{ user.email||user.phone }}</div>
                </div>

                <div class="uk-width-auto">
                    <Link as="button" method="POST" :href="route('logout')" class="uk-button uk-button-danger">Odjavite Se</Link>
                </div>
            </div>
            <div class="uk-grid uk-grid-small uk-margin uk-flex-center" uk-grid>
                <div class="uk-width-large">
                    <dashboard-item title="Sačuvane nekretnine" :link="route('bookmark.index')">
                        <template #left>
                            <img src="/icons/saved.svg" class="uk-text-danger" alt="sačuvani" width="80" height="80" uk-svg>
                        </template>
                        <p>Pogledajte izmene na nekretninama koje ste odabrali da pratite.</p>
                    </dashboard-item>
                </div>
                <div class="uk-width-large">
                    <dashboard-item title="Moje konverzacije" :link="route('message.index')">
                        <template #left>
                            <img src="/icons/edit-notifications.svg" class="uk-text-danger" alt="nekretnine" width="80" height="80" uk-svg>
                        </template>
                        <p>Pogledajte ili odgovorite na poruke koje su vam drugi korisnici poslali.</p>
                    </dashboard-item>
                </div>
                <div class="uk-width-large">
                    <dashboard-item title="Moja podešavanja" :link="route('setting.edit')">
                        <template #left>
                            <img src="/icons/network-settings.svg" class="uk-text-danger" alt="podesavanja" width="80" height="80" uk-svg>
                        </template>
                        <p>Podesite primanje obaveštenja prema vašim potrebama.</p>
                    </dashboard-item>
                </div>
                <div class="uk-width-large">
                    <dashboard-item title="Moj profil" :link="route('profile.show')">
                        <template #left>
                            <img src="/icons/profile-settings.svg" class="uk-text-danger" alt="profil" width="80" height="80" uk-svg>
                        </template>
                        <p>Podesite detalje vašeg naloga ime, lozinku, email, broj telefona ili obrišite vaš nalog.</p>
                    </dashboard-item>
                </div>
                <div class="uk-width-large">
                    <dashboard-item title="Moje nekretnine" :link="route('user-listing.index')">
                        <template #left>
                            <img src="/icons/home-edit.svg" class="uk-text-danger" alt="nekretnine" width="80" height="80" uk-svg>
                        </template>
                        <p>Kreirajte ili izmenite vaš oglas za izdavanje nekretnine.</p>
                    </dashboard-item>
                </div>

            </div>
        </div>
    </div>
    <base-footer />
</template>
