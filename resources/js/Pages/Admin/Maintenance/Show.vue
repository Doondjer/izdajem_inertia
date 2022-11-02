<template>
    <show-form
        title="Održavanje Aplikacije"
        :card_title="is_maintenance ? 'Izađite Iz Moda Održavanja' : 'Postavite Aplikaciju U Mod Održavanja'"
    >
        <div v-if="is_maintenance">
            <notice v-if="maintenance" color="warning">
                Aplikacija se nalazi u modu odrzavanja kod: {{ maintenance.secret }}
            </notice>
            <Link :href="route('admin.maintenance.up')" class="uk-button uk-button-large uk-button-danger uk-width-1-1">Izadji</Link>
        </div>
        <div v-if="! is_maintenance">
            <text-input
                v-model="form.secret"
                icon="security"
                label="Tajni Kod"
                :error="form.errors.secret"
                placeholder="Unesite Tajni Kod..."
                hint="Unesite tajni kod sa kojim je moguće pristupiti aplikaciji iako je u modu održavanja ili ostavite prazno da ga sistem generiše."
            />
        </div>
        <div v-if="! is_maintenance">
            <button @click="submit" class="uk-button uk-button-danger uk-button-large uk-width-1-1">Pošalji</button>
        </div>
    </show-form>
</template>

<script>

    import AdminLayout from "@/Layouts/Admin/AppLayout.vue";
    export default {
        layout: AdminLayout
    }

</script>

<script setup>
import TextInput from "@/Shared/TextInput.vue";
import {defineAsyncComponent} from "vue";
const Notice = defineAsyncComponent(() =>  import('@/Shared/Notice.vue'));
import ShowForm from "@/Shared/Admin/Form.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";

defineProps({
    maintenance: Object,
    is_maintenance: Boolean,
});

let form = useForm({
    secret: '',
})

let submit = () => {
      axios.post(route('admin.maintenance.down'),{
          secret: form.secret,
          withCredentials: true
      }).then(({data}) => {
          document.cookie = data.name + "=" + data.value + ";" + data.expire + ";path=/";
          form.reset().clearErrors();
          Inertia.reload();
      }).catch(e => {
          try {
              form.setError({secret: e.response.data.errors.secret[0]});
          } catch (e) {
              console.error(e);
          }
      });
}

</script>
