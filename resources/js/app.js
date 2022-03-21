require('./bootstrap');

import { createApp, h } from 'vue';
import Vue from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import moment from 'moment';
import store from './store'

moment.locale("pt-br");

// Vue.filter('formatDate', function (value) {
//     if(value){
//         return moment(value).format('DD/MM/YYYY HH:mm:ss')
//     }
// });

store.dispatch('userStateAction')

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
