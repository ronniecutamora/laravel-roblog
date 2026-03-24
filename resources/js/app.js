import '../css/app.css';
import { createInertiaApp } from '@inertiajs/svelte';
import { mount } from 'svelte';
import AppLayout from './Layouts/AppLayout.svelte';

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.svelte', { eager: true });
        let page = pages[`./Pages/${name}.svelte`];
        return { default: page.default, layout: page.layout || AppLayout };
    },
    setup({ el, App, props }) {
        mount(App, { target: el, props });
    },
});
