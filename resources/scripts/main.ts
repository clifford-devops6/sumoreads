import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { resolvePageComponent } from 'vite-plugin-laravel/inertia'
import axios from "axios";
axios.defaults.baseURL=import.meta.env.VITE_APP_URL;
createInertiaApp({
	resolve: (name) => resolvePageComponent(name, import.meta.glob('../views/pages/**/*.vue')),
	setup({ el, app, props, plugin }) {
		createApp({ render: () => h(app, props), })

			.use(plugin)
            .mixin({ methods: { route: window.route } })
			.mount(el)
	},
    title: title => `${title} | Sumoreads`,
})
