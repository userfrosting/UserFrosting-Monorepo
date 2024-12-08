/// <reference types="vitest" />
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import dts from 'vite-plugin-dts'

// https://vitejs.dev/config/
// https://stackoverflow.com/a/74397545/445757
export default defineConfig({
    plugins: [vue(), dts()],
    publicDir: false,
    build: {
        outDir: './dist',
        lib: {
            entry: {
                main: 'src/index.ts',
                interfaces: 'src/interfaces/index.ts',
                stores: 'src/stores/index.ts',
                composables: 'src/composables/index.ts'
            }
        },
        rollupOptions: {
            external: ['vue', 'pinia'],
            output: {
                exports: 'named',
                globals: {
                    vue: 'Vue',
                }
            }
        }
    },
    test: {
        coverage: {
            reportsDirectory: './_meta/_coverage',
            include: ['src/**/*.*'],
            // exclude: ['src/tests/**/*.*', 'src/interfaces/routes.ts']
        },
        environment: 'happy-dom'
    }
})
