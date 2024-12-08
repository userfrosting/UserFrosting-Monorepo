import { useConfigStore } from './stores'

export default {
    install: () => {
        const config = useConfigStore()
        config.load()
    }
}
