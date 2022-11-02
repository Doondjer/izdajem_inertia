<template>
    <edit
        :percent="5/6*100"
        :l="listing.data"
        step="slike"
        title="Dodaj fotografije"
        :proceed="!!myFiles.length && ! form.processing"
        :loading="form.processing"
        :nextText="form.isDirty ? 'Sačuvaj & nastavi' : 'Nastavi'"
        :prevLink="route('listing.edit', {listing: listing.data.slug, step: 'opis'})"
        @next="submit"
    >

        <h3 class="uk-h4">Galerija fotografija</h3>
        <div>Fotografije vaše nekretnine će se prikazivati po redosledu kojim su i ovde prikazane. Možete ih prevući u polje ispod ili kliknuti na polje u formi da vam se prikaže prozor za odabir</div>
        <p class="uk-text-meta">Maximum 20 slika & 5MB veličine - PNG, JPG, JPEG</p>

        <file-pond
            name="image"
            class="filepond"
            ref="pond"
            label-idle='<div class="dz-message"><img src="/icons/upload.svg" class="uk-margin-small-right" width="30" height="30" uk-svg><span class="uk-text-middle">Postavite slike prevlačenjem ili </span> <div class="uk-form-custom"><span class="uk-link">klikom ovde</span></div></div>'
            @init="filepondInitialized"
            accepted-file-types="image/jpg, image/jpeg, image/png"
            @processfile="handleProcessedFile"
            max-file-size="5MB"
            max-files="20"
            v-bind:allow-multiple="true"
            v-bind:files="myFiles"
            :imagePreviewMaxHeight="128"
            :imagePreviewMinHeight="128"
            :filePosterMaxHeight="128"
            :imagePreviewMaxWidth="200"
            :filePosterMaxWidth="200"
            dropValidation="true"
            :beforeRemoveFile="deleteImage"
            :required="true"
            credits="false"
        />
        <div class="uk-text-danger uk-text-left" v-if="form.errors.images">{{ form.errors.images}}</div>
        <text-input
            class="uk-margin"
            v-model="form.video_url"
            icon="youtube"
            label="Video tura(opciono)"
            type="text"
            :error="form.errors.video_url"
            iconPosition="left"
            placeholder="Youtube link..."
            hint="Ovaj video će se pojaviti na vašem oglasu u galeriji slika. Link ka videu mora biti sa Youtube."
        />
    </edit>
</template>

<script setup>
    import Edit from "@/Pages/Listing/Edit.vue";
    import vueFilePond, { setOptions } from 'vue-filepond';
    import { defineProps, reactive} from "vue";

    // Import plugins
    import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js';
    import FilePondPluginImagePreview from 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js';
    import FilePondPluginFilePoster from 'filepond-plugin-file-poster';
    // Import styles
    import 'filepond/dist/filepond.min.css';
    import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
    import 'filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css';
    import {useForm} from "@inertiajs/inertia-vue3";
    import TextInput from "@/Shared/TextInput.vue";

    let serverMessage = {};
    // Create FilePond component
    const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview,FilePondPluginFilePoster);

    let props = defineProps({
        listing: Object,
    })

    let form = useForm({
        video_url: props.listing.data.video_url || null,
        images: null
    })

    let submit = () => {
        form.patch(route('listing.update', {listing: props.listing.data.slug, step: 'slike'}), {
            preserveScroll: true
        });
    }

    let myFiles = reactive([]);
    let updateFiles = (file) => {
        myFiles.push({
            source: `${file}`,
            options:{
                type:'local',
                metadata: {
                    poster: `/images/200/${file}`
                },
            },
        })
    }
    props.listing.data.images.map(function(image, key) {
        updateFiles(image.filename);
    });

    setOptions({
        server: {
            process: {
                url: `/upload/${props.listing.data.slug}`,
                onerror: (response) => {
                    try {
                        serverMessage = JSON.parse(response);
                    } catch (error) {
                        console.error(response);
                        serverMessage = {error: 'Oouups, došlo je do neke greške'}
                    }

                },
                onload: (response) => {
                    try {
                        let r = JSON.parse(response);

                        return r.serverId;
                    } catch (e){
                        return null;
                    }

                },
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf_token"]').content
                }
            },
        },
        labelFileProcessingError: () => {
            return serverMessage.error;
        }
    });

    let filepondInitialized = () => {

    };
    let handleProcessedFile = (error, file) => {
        if (error) {
            return;
        }

        // add the filename to our images array
        updateFiles(file.serverId);
    };
    let deleteImage = (image) => {

        if(!image.serverId) {
            return true;
        }

        return axios.delete(`/upload/${props.listing.data.slug}`,{data: {'image': image.serverId }})
            .then(({data}) => {
                const i = myFiles.findIndex(object => {
                    return object.source === image.serverId;
                });
                myFiles.splice(i,1);
                return data.deleted;
            })
            .catch(e => {
              //  console.error(e);
                return false;
            });
    }
</script>

<style>
    .filepond--item {
        width: 194px!important;
    }
</style>
