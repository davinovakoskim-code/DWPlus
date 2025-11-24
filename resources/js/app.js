import './bootstrap'; // Configuração padrão do Laravel (axios, etc)
import '../css/app.css'; // Seu CSS global (Tailwind ou custom)

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

// --- Importações do Quasar ---
import { Quasar, Notify, Dialog } from 'quasar';
import quasarLang from 'quasar/lang/pt-BR'; // Tradução para PT-BR

// Importar ícones e estilos do Quasar
import '@quasar/extras/material-icons/material-icons.css';
import 'quasar/src/css/index.sass';

createInertiaApp({
    // Define onde o Vite vai buscar suas páginas Vue
    resolve: (name) => resolvePageComponent(
        `./Pages/${name}.vue`,
        import.meta.glob('./Pages/**/*.vue')
    ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin) // Ativa o Inertia
            .use(Quasar, { // Ativa o Quasar
                plugins: {
                    Notify, // Habilita notificações flutuantes
                    Dialog  // Habilita modais de confirmação nativos
                },
                lang: quasarLang, // Define o idioma dos componentes (calendário, etc)
            })
            .mount(el);
    },
    progress: {
        // Cor da barrinha de carregamento no topo quando muda de página
        color: '#1976D2',
    },
});