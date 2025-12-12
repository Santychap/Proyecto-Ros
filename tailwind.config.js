/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        gold: {
          DEFAULT: '#D4AF37', // dorado clásico
          light: '#F5E1A4',   // dorado claro
          dark: '#9B7B1F'     // dorado oscuro
        },
        blackBg: '#121212' // fondo negro no tan negro para menos cansancio visual
      },
    },
  },
  plugins: [],
}
