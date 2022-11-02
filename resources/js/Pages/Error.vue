<template>
    <div class="uk-section" uk-height-viewport="expand: true; min-height: 370">
        <div class="uk-position-center">
            <div class="uk-container uk-container-small">
                <div class="uk-card">
                    <div class="uk-card-body uk-text-center">
                        <div class="uk-text-center" v-if="image">
                            <img :src="image" alt="logo" height="192">
                        </div>
                        <H1 class="uk-text-center">{{ title }}</H1>
                        <p>{{ description }}</p>
                        <div>
                            <Link href="/" class="uk-button uk-button-danger uk-button-large">Nazad na početnu</Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import empty from "@/Layouts/EmptyLayout.vue";

export default {
    layout: empty,
    props: {
        status: Number,
    },
    computed: {
        title() {
            return {
                503: 'Privremeno nedostupno zbog održavanja',
                500: '500: Server Error',
                404: '404: Page Not Found',
                403: '403: Forbidden',
            }[this.status]
        },
        description() {
            return {
                503: 'Servis je trenutno nedostupan zbog održavanja. Izvinjavamo se zbog neprijatnosti, a vraćamo se uskoro!',
                500: 'Server nije u mogućnosti da ispuni zahtev zbog unutrašnje greške servera.\n' +
                    'Pokušajte ponovo kasnije ili se obratite administratoru.',
                404: 'Server nije mogao pronaći traženi resurs. URL adresa nije dobra ili resurs ne postoji.',
                403: 'Pristup je zabranjen! Ukoliko ipak mislite da treba da budete ovde obratite se administratoru.',
            }[this.status]
        },
        image() {
            return {
                503: '/android-chrome-192x192.png',
                500: '/images/500.jpg',
                404: '',
                403: '',
            }[this.status]
        },
    },
}
</script>

<style scoped>

</style>
