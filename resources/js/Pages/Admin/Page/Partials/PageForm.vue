<template>
    <show-form
        :title="title"
        :card_title="card_title"
    >
        <template #breadcrumb>
            <div><Link :href="route('admin.page.index')">Dodatne Stranice</Link></div>
        </template>

        <div class="uk-form-row uk-margin-small">
            <text-input
                v-model="form.title"
                required
                label="Naslov Stranice"
                :error="form.errors.title"
                placeholder="Unesite Naslov Stranice..."
            />
        </div>


        <div class="uk-form-row uk-margin-small">
            <selectbox-input
                label="Veličina Kontejnera Stranice"
                :error="form.errors.size"
                v-model="form.size"
            >
                <option :value="null">Odaberite Veličina Kontejnera Stranice...</option>
                <option value="xsmall">Xsmall</option>
                <option value="small">Small</option>
                <option value="large">Large</option>
                <option value="xlarge">Xlarge</option>
                <option value="expand">Expand</option>
            </selectbox-input>
        </div>

        <div class="uk-form-row uk-margin-small">
            <label class="uk-text-small uk-text-bold">Sadržaj Stranice</label>
            <tip-tap-textarea v-model:content="form.content"
                              :autofocus="false"
                              :error="form.errors.content"
                              placeholder="Unesite Sadržaj Stranice..."
            />
            <div v-if="form.errors.content" class="uk-text-danger uk-text-left">{{ form.errors.content }}</div>
        </div>

        <div class="uk-form-row uk-margin-small">
            <textarea-input
                v-model="form.meta_title"
                label="Meta Title"
                required
                :error="form.errors.meta_title"
                placeholder="Unesite Meta Title Za Ovu Stranicu..."
                cols="30"
                rows="7"
            />
        </div>

        <div class="uk-form-row uk-margin-small">
            <textarea-input
                v-model="form.meta_keywords"
                label="Meta Keywords"
                :error="form.errors.meta_keywords"
                placeholder="Unesite Meta Ključne reči Za Ovu Stranicu..."
                cols="30"
                rows="7"
            />
        </div>

        <div class="uk-form-row uk-margin-small">
            <textarea-input
                v-model="form.meta_description"
                label="Meta Opis"
                :error="form.errors.meta_description"
                placeholder="Unesite Meta Opis Za Ovu Stranicu..."
                cols="30"
                rows="7"
            />
        </div>

        <div class="uk-form-row uk-margin-small">
            <loading-button class="uk-button-large uk-button-danger uk-width-1-1"
                            :class="{ 'uk-disabled': form.processing }"
                            :disabled="form.processing"
                            @click.prevent="submit"
            >
                Pošaljite
            </loading-button>
        </div>
    </show-form>
</template>

<script setup>
import TextareaInput from "@/Shared/TextareaInput.vue";
import LoadingButton from "@/Shared/LoadingButton.vue";
import ShowForm from "@/Shared/Admin/Form.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import TipTapTextarea from "@/Shared/TipTapTextarea.vue";
import SelectboxInput from "@/Shared/SelectboxInput.vue";
import TextInput from "@/Shared/TextInput.vue";

let props = defineProps({
    page: Object,
    title: String,
    card_title: String,
});

let form = useForm({
    slug: props.page && props.page.slug || null,
    title: props.page && props.page.title || null,
    meta_title: props.page && props.page.meta_title || null,
    size: props.page && props.page.size || null,
    classes: props.page && props.page.classes || null,
    meta_description: props.page && props.page.meta_description || null,
    meta_keywords: props.page && props.page.meta_keywords || null,
    content: props.page && props.page.content || null,
})

let emits = defineEmits(['submited'])

let submit = () => {
    emits('submited', form);
}

</script>

