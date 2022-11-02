import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import htmlPurge from 'vite-plugin-purgecss'
import { fileURLToPath } from 'url';
import { basename } from 'path';

export default defineConfig({
    /*resolve:{
        alias:[
            {
                find: '../../images',
                replacement: '',
                customResolver(updatedId, importer, resolveOptions) {
                    // don't replace if importer is not our my-uikit.less
                    //console.log(basename(importer));
                    /!*if (basename(importer) !== 'my-uikit.less') {
                        fileURLToPath(
                            new URL(
                                './resources/images' + updatedId,
                                import.meta.url
                            )
                        );
                        return '../';
                    }*!/

                    return fileURLToPath(
                        new URL(
                            './node_modules/uikit/src/images' + updatedId,
                            import.meta.url
                        )
                    );
                },
            }
           // '@' : path.resolve(__dirname, './resource/js')
        ],
    },*/
    plugins: [
        //htmlPurge(),
        laravel({
            input: 'resources/js/app.js',
            ssr: 'resources/js/ssr.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),

    ],
    ssr: {
        noExternal: ['@inertiajs/server'],
    },
});
