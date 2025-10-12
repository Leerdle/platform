import { createInertiaApp, Head, Link } from '@inertiajs/vue3'
import createServer from '@inertiajs/vue3/server'
import { renderToString } from '@vue/server-renderer'
import { createSSRApp, h } from 'vue'
import { ZiggyVue } from "ziggy-js";
import MainLayout from "@/Layouts/MainLayout.vue";
import CustomButton from "@/Components/Buttons/CustomButton.vue";

createServer(page =>
    createInertiaApp({
        page,
        render: renderToString,
        title: (title) => `Leerdle | ${title}`,
        resolve: (name) => {
            const pages = import.meta.glob('./Pages/**/*.vue', {
                eager: true
            });
            let page = pages[`./Pages/${name}.vue`];

            page.default.layout = page.default.layout || MainLayout;
            return page;
        },
        setup({ App, props, plugin }) {
            return createSSRApp({
                render: () => h(App, props),
            }).use(plugin)
                .use(ZiggyVue, {
                    ...page.props.ziggy,
                    location: new URL(page.props.ziggy.location),
                })
                .component("Head", Head)
                .component("Link", Link)
                .component("Button", CustomButton)
        },
    }),
    { cluster: true },
)
