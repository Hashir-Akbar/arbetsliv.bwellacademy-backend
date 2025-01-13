import React from 'react'
import {createRoot} from 'react-dom/client'
import {createInertiaApp } from '@inertiajs/inertia-react'

createInertiaApp({
    // Below you can see that we are going to get all React components from resources/js/Pages folder
    resolve: name => import(`./pages/${name}.jsx`),
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />)
    },
})

