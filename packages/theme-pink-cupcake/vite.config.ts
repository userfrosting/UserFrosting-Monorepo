/// <reference types="vitest" />
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import dts from 'vite-plugin-dts'

// https://vitejs.dev/config/
// https://stackoverflow.com/a/74397545/445757
export default defineConfig({
    plugins: [vue(), dts()],
    build: {
        outDir: './dist',
        lib: {
            entry: {
                plugins: 'src/index.ts',
                components: 'src/components.ts'
            }
        },
        rollupOptions: {
            external: ['vue', 'vue-router', 'pinia', '@userfrosting/sprinkle-core'],
            output: {
                exports: 'named',
                globals: {
                    vue: 'Vue',
                    'vue-router': 'vueRouter'
                }
            }
        }
    },
    // Add UIKit alias : https://stackoverflow.com/a/75264118/445757
    resolve: {
        alias: {
            '../../images/backgrounds': 'uikit/src/images/backgrounds',
            '../../images/components': 'uikit/src/images/components',
            '../../images/icons': 'uikit/src/images/icons'
        }
    },
    test: {
        coverage: {
            reportsDirectory: './_meta/_coverage',
            include: ['src/**/*.*'],
        },
        setupFiles: ['src/tests/translator.setup.ts'],
        environment: 'happy-dom'
    }
})
