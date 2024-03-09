import './bootstrap';
import '../css/app.css';

import { createApp, h, DefineComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { Article } from './types';
import { SnackbarService, Vue3Snackbar } from "vue3-snackbar";
import "vue3-snackbar/styles";
const appName = import.meta.env.VITE_APP_NAME || 'Artikkelit';
window.Echo.channel('article-editing')
    .listen('ArticleEditing', (e: { articleId: number, editing: boolean, userName: string }) => {
        console.log(e);
    });
window.Echo.channel('shoutbox')
    .listen('ShoutboxMsg', (e: { userName: string, msg: string }) => {
        console.log(e);
    });

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(SnackbarService)
            .component("vue3-snackbar", Vue3Snackbar)
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
