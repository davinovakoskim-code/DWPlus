import './bootstrap'; 
import '../css/app.css'; 

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';


import { Quasar, Notify, Dialog } from 'quasar';
import quasarLang from 'quasar/lang/pt-BR'; 


import '@quasar/extras/material-icons/material-icons.css';
import 'quasar/src/css/index.sass';

createInertiaApp({
    
    resolve: (name) => resolvePageComponent(
        `./Pages/${name}.vue`,
        import.meta.glob('./Pages/**/*.vue')
    ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin) 
            .use(Quasar, { 
                plugins: {
                    Notify, 
                    Dialog  
                },
                lang: quasarLang, 
            })
            .mount(el);
    },
    progress: {
        
        color: '#1976D2',
    },
});