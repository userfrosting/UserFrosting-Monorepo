import type { App } from 'vue'

// Import sub-plugins
import PinkCupcakeComponents from './plugins/components'
import PinkCupcakeViews from './plugins/views'
import AdminSprinkle from './plugins/admin'
import FontAwesome from './plugins/font-awesome'

// Init UIkit
import UIkit from 'uikit'
import Icons from 'uikit/dist/js/uikit-icons'
UIkit.use(Icons)

/* Install plugins */
export default {
    install: (app: App) => {
        app.use(PinkCupcakeComponents)
        app.use(PinkCupcakeViews)
        app.use(AdminSprinkle) // TODO : Add option to disable this or load on demand
        app.use(FontAwesome)
    }
}
