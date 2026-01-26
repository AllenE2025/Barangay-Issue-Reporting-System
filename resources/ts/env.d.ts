/// <reference types="vite/client" />

interface ImportMetaEnv {
    readonly VITE_APP_NAME?: string;
    readonly VITE_API_URL?: string; // add more if needed
}

interface ImportMeta {
    readonly env: ImportMetaEnv;

    /**
     * For Vite's glob imports
     */
    glob(pattern: string): Record<string, () => Promise<any>>;
    globEager(pattern: string): Record<string, any>;
}
