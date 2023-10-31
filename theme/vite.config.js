import { defineConfig } from 'vite';
import usePHP from 'vite-plugin-php';

export default defineConfig({
  plugins: [
    usePHP({
      entry: [
        "index.php",
        "partials/nav-top.php",
        "partials/message.php",
        "partials/footer.php",
      ]
    })
  ],
  // base: process.env.APP_ENV === 'dev'
  //   ? '/'
  //   : '/dist/',
  base: '/dist',
  build: {
    // Output dir for production build.
    outDir: './../public/dist',
    emptyOutDir: true,
    // Create manifest so PHP can find the hashed files.
    manifest: true,
    // Our entry.
    rollupOptions: {
      output: {
        // No hash in files.
        assetFileNames: `assets/[name].[ext]`,
        chunkFileNames: 'assets/[name]-[hash].js',
        entryFileNames: 'assets/[name]-[hash].js',
      },
    }
  },
});