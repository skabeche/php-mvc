import { defineConfig, loadEnv } from 'vite';
import usePHP from 'vite-plugin-php';
import path from 'path';

// Get env variables from root folder.
const env = loadEnv(
  'all',
  path.resolve(path.dirname(__filename), "../")
);

export default defineConfig({
  plugins: [
    usePHP({
      entry: [
        "index.php",
        "partials/nav-top.php",
        "partials/message.php",
        "partials/footer.php",
      ],
    }),
  ],
  base: env.VITE_APP_ENV === 'dev' ? '/' : '/dist',
  build: {
    // Output dir for production build.
    outDir: './../public/dist',
    emptyOutDir: true,
    // Create manifest so PHP can find the hashed files.
    manifest: true,
    // Our entry.
    rollupOptions: {
      input: path.resolve(path.dirname(__filename), "/scripts.js"),
      output: {
        // No hash in files.
        assetFileNames: `assets/[name].[ext]`,
        chunkFileNames: 'assets/[name]-[hash].js',
        entryFileNames: 'assets/[name]-[hash].js',
      },
    }
  },
});