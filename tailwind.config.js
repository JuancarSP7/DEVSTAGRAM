/** @type {import('tailwindcss').Config} */
module.exports = {
  // Para que Tailwind aplique clases 'dark:' cuando detecte la clase 'dark' en <html>
  darkMode: 'class',

  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
  ],

  theme: {
    extend: {},
  },

  plugins: [],
}
