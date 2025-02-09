export {}

declare module 'vue' {
    interface ComponentCustomProperties {
        // TODO : Use interface from sprinkle-core
        $t: (key: string, placeholders?: string | number | object) => string
        $tdate: (date: string, format?: string | object) => string
    }
}
