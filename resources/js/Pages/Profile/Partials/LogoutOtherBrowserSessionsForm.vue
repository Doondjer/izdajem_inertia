<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import DialogModal from '@/Shared/DialogModal.vue';
import LoadingButton from "@/Shared/LoadingButton.vue";
import TextInput from "@/Shared/TextInput.vue";

defineProps({
    sessions: Array,
});

const confirmingLogout = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmLogout = () => {
    confirmingLogout.value = true;

    setTimeout(() => passwordInput.value.focus(), 250);
};

const logoutOtherBrowserSessions = () => {
    form.delete(route('other-browser-sessions.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingLogout.value = false;

    form.reset();
};
</script>

<template>
    <div class="uk-card uk-card-small">
        <div class="uk-card-header">
            <h2 class="uk-card-title">Izlogujte se sa ostalih uređaja</h2>
        </div>
        <div class="uk-card-body">

            <p>Izgubili ste uređaj ili ste koristili tuđi računar? Zaštitite vaš nalog tako što ćete da se izlogujete sa svih drugih uređaja.</p>
            <!-- Other Browser Sessions -->
            <div v-if="sessions.length > 0" class="uk-margin">
                <table class="uk-table uk-table-striped">
                    <thead>
                    <tr>
                        <th>Tip</th>
                        <th>Agent</th>
                        <th>Ip Address</th>
                        <th>Aktivnost</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(session, i) in sessions" :key="i">
                        <td><img :src="`/icons/${session.agent.is_desktop ? 'laptop' : 'mobile'}.svg`" :alt="session.agent.is_desktop ? 'computer' : 'mobile'" uk-svg></td>
                        <td>{{ session.agent.platform ? session.agent.platform : 'Unknown' }} - {{ session.agent.browser ? session.agent.browser : 'Unknown' }}</td>
                        <td>{{ session.ip_address }}</td>
                        <td v-if="session.is_current_device">Ovaj uredja</td>
                        <td v-else>Poslednja Aktivnost {{ session.last_active }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <button class="uk-button uk-button-default" @click="confirmLogout">
                Izloguj ostale uređaje
            </button>

            <ActionMessage :on="form.recentlySuccessful">
                Izvršeno.
            </ActionMessage>
        </div>
    </div>

    <dialog-modal :show="confirmingLogout" v-if="confirmingLogout" @close="closeModal">
        <template #title>
            Izloguj druge uređaje
        </template>

        <template #content>
            <p>Molimo vas da unesete vašu lozinku, kako bi potvrdili da želite da izlogujete sve ostale uređaje osim ovog.</p>

            <div class="uk-margin">
                <text-input
                    v-model="form.password"
                    icon="lock"
                    type="password"
                    required
                    :error="form.errors.password"
                    iconPosition="left"
                    autocomplete="current-password"
                    placeholder="Lozinka ..."
                    ref="passwordInput"
                    @keyup.enter="logoutOtherBrowserSessions"
                />
            </div>
        </template>

        <template #footer>
            <div class="uk-text-right">
                <button class="uk-button uk-button-default uk-button-large " type="button" @click="closeModal">
                    Prekini
                </button>
                <loading-button @click.prevent="logoutOtherBrowserSessions" class="uk-button-large uk-button-danger uk-margin-small-left"
                                :class="{ 'uk-disabled': form.processing }"
                                :disabled="form.processing"
                >
                    Izloguj ostale uređaje
                </loading-button>
            </div>

        </template>
    </dialog-modal>
</template>
