<template>
    <show-form
        title="Konverzacija"
        :card_title="`Konverzacija - ${thread.data.subject}`"
    >
        <template #breadcrumb>
            <div><Link :href="route('admin.thread.index')">Konverzacije</Link></div>
        </template>
        <div class="uk-form-row">


            <message-article v-for="(message, index) in thread.data.messages" :message=message :key="index" />

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
import ShowForm from "@/Shared/Admin/Form.vue";
import MessageArticle from "@/Shared/MessageArticle.vue";

let props = defineProps({
    thread: Object,
});

</script>

