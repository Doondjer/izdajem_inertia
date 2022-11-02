
import '../less/uikit.theme.less';

import { createSSRApp, h } from 'vue';
import { renderToString } from '@vue/server-renderer';
import {createInertiaApp, Head, Link} from '@inertiajs/inertia-vue3';
import createServer from '@inertiajs/server';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import Layout from "./Layouts/AppLayout.vue";
import _ from "lodash";

const appName = 'izdajem.rs';

global._ = _;

createServer((page) =>
    createInertiaApp({
        page,
        render: renderToString,
        title: (title) => `${title} - ${appName}`,
      //  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
        resolve: (name) => {
            const page = resolvePageComponent(
                `./Pages/${name}.vue`,
                import.meta.glob("./Pages/**/*.vue")
            );
            page.then((module) => {
                module.default.layout = module.default.layout || Layout;
            });
            return page;
        },
        setup({ app, props, plugin }) {
            return createSSRApp({ render: () => h(app, props) })
                .use(plugin)
                .component('Link', Link)
                .component('Head', Head)
                .use(ZiggyVue, {
                    ...page.props.ziggy,
                    location: new URL(page.props.ziggy.location),
                });
        },
    })
);
